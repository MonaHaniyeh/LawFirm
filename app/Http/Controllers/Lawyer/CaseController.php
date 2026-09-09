<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Document;
use App\Models\Message;
use App\Models\User;
use App\Notifications\CaseUpdatedNotification;
use App\Notifications\DocumentUploadedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CaseController extends Controller
{
    /**
     * Display the lawyer's cases.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', CaseFile::class);

        /** @var User $lawyer */
        $lawyer = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        */

        $casesQuery = $lawyer->casesAsLawyer()
            ->with('client');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        |
        | Search by:
        | - Case number
        | - Case title
        | - Case description
        | - Client name
        | - Client email
        |
        */

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $casesQuery->where(function ($query) use ($search) {

                $query->where(
                    'case_number',
                    'like',
                    "%{$search}%"
                )

                    ->orWhere(
                        'case_type',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'description',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhereHas('client', function ($clientQuery) use ($search) {

                        $clientQuery
                            ->where(
                                'name',
                                'like',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'email',
                                'like',
                                "%{$search}%"
                            );
                    });
            });
        }

        /*
    |--------------------------------------------------------------------------
    | Filter By Status
    |--------------------------------------------------------------------------
    */
        if ($request->filled('status')) {
            $status = $request->input('status');

            if ($status === 'open') {
                $status = 'opened';
            }

            $casesQuery->where('status', $status);
        }

        /*
    |--------------------------------------------------------------------------
    | Filter By Case Type
    |--------------------------------------------------------------------------
    */
        if ($request->filled('case_type')) {
            $casesQuery->where(
                'case_type',
                $request->input('case_type')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Get Case Types
    |--------------------------------------------------------------------------
    */
        $caseTypes = CaseFile::query()
            ->where('lawyer_id', $lawyer->id)
            ->whereNotNull('case_type')
            ->where('case_type', '!=', '')
            ->distinct()
            ->orderBy('case_type')
            ->pluck('case_type');

        /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
        $cases = $casesQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('lawyer.cases.index', compact(
            'cases',
            'caseTypes'
        ));
    }

    /**
     * Display a specific case.
     */
    public function show(CaseFile $case)
    {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'view',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Load Relationships
        |--------------------------------------------------------------------------
        */

        $case->load([
            'client',
            'lawyer',
            'documents.uploader',
            'messages.sender',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'lawyer.cases.show',
            compact('case')
        );
    }

    /**
     * Show the case edit form.
     */
    public function edit(CaseFile $case)
    {
        Gate::authorize(
            'update',
            $case
        );

        return view(
            'lawyer.cases.edit',
            compact('case')
        );
    }

    /**
     * Update a case.
     */
    public function update(
        Request $request,
        CaseFile $case
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'update',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Request
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'description' => [
                'required',
                'string',
                'min:10',
            ],

            'status' => [
                'required',
                Rule::in([
                    'opened',
                    'closed',
                ]),
            ],

            'end_date' => [
                'nullable',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Case
        |--------------------------------------------------------------------------
        */

        $case->update($data);

        /*
        |--------------------------------------------------------------------------
        | Load Client
        |--------------------------------------------------------------------------
        */

        $case->load([
            'client',
            'lawyer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify Client
        |--------------------------------------------------------------------------
        */

        if ($case->client) {
            $case->client->notify(
                new CaseUpdatedNotification($case)
            );
        }

        return back()->with(
            'status',
            'Case updated successfully.'
        );
    }

    /**
     * Send a message to the client.
     */
    public function storeMessage(
        Request $request,
        CaseFile $case
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'participate',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Message
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'subject' => [
                'nullable',
                'string',
                'max:150',
            ],

            'content' => [
                'required',
                'string',
                'max:5000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Create Message
        |--------------------------------------------------------------------------
        */

        Message::create([
            'case_id' => $case->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $case->client_id,
            'subject' => $data['subject'] ?? null,
            'content' => $data['content'],
            'is_new' => true,
        ]);

        return back()->with(
            'status',
            'Message sent successfully.'
        );
    }

    /**
     * Upload a document to a case.
     *
     * This is the main document upload method.
     */
    public function uploadDocument(
        Request $request,
        CaseFile $case
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'participate',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Validate Document
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
            ],

            'document' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get Uploaded File
        |--------------------------------------------------------------------------
        */

        $file = $request->file('document');

        /*
        |--------------------------------------------------------------------------
        | Store File
        |--------------------------------------------------------------------------
        |
        | The file is stored on the private disk.
        |
        */

        $path = $file->store(
            "cases/{$case->id}/documents",
            'private'
        );

        /*
        |--------------------------------------------------------------------------
        | Create Document Record
        |--------------------------------------------------------------------------
        */

        $document = Document::create([
            'case_id' => $case->id,
            'uploaded_by' => Auth::id(),
            'title' => $data['title'],
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Load Document Relationships
        |--------------------------------------------------------------------------
        */

        $document->load([
            'case',
            'uploader',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Load Case Relationships
        |--------------------------------------------------------------------------
        */

        $case->load([
            'client',
            'lawyer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify Client
        |--------------------------------------------------------------------------
        |
        | The lawyer uploaded a document,
        | so the client receives the notification.
        |
        */

        if ($case->client) {
            $case->client->notify(
                new DocumentUploadedNotification($document)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Return
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'status',
            'Document uploaded successfully.'
        );
    }

    /**
     * Backward-compatible document upload method.
     *
     * If your route still uses:
     *
     * CaseController@storeDocument
     *
     * it will still work.
     */
    public function storeDocument(
        Request $request,
        CaseFile $case
    ) {
        return $this->uploadDocument(
            $request,
            $case
        );
    }

    /**
     * Download a case document.
     */
    public function downloadDocument(
        CaseFile $case,
        Document $document
    ) {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        Gate::authorize(
            'participate',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Make Sure Document Belongs To Case
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->case_id === $case->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Get Private Storage Disk
        |--------------------------------------------------------------------------
        */

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('private');

        /*
        |--------------------------------------------------------------------------
        | Make Sure File Exists
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $disk->exists($document->file_path),
            404,
            'Document not found.'
        );

        /*
        |--------------------------------------------------------------------------
        | Download
        |--------------------------------------------------------------------------
        */

        return $disk->download(
            $document->file_path,
            $document->title
        );
    }
}
