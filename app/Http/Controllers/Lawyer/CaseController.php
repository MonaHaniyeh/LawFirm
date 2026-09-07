<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Document;
use App\Models\Message;
use App\Models\User;
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

        $casesQuery = $lawyer->casesAsLawyer()
            ->with('client');

        // Filter by case type
        if ($request->filled('case_type')) {
            $casesQuery->where('case_type', $request->case_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $casesQuery->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $casesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $cases = $casesQuery
            ->latest('start_date')
            ->paginate(15)
            ->withQueryString();

        /*
         * Get the case types used by this lawyer.
         * This is required by lawyer/cases/index.blade.php
         */
        $caseTypes = $lawyer->casesAsLawyer()
            ->whereNotNull('case_type')
            ->where('case_type', '!=', '')
            ->distinct()
            ->orderBy('case_type')
            ->pluck('case_type');

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
        Gate::authorize('view', $case);

        $case->load([
            'client',
            'documents.uploader',
            'messages.sender',
        ]);

        return view('lawyer.cases.show', compact('case'));
    }

    /**
     * Show the case edit form.
     */
    public function edit(CaseFile $case)
    {
        Gate::authorize('update', $case);

        return view('lawyer.cases.edit', compact('case'));
    }

    /**
     * Update a case.
     */
    public function update(Request $request, CaseFile $case)
    {
        Gate::authorize('update', $case);

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

        $case->update($data);

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
        Gate::authorize('participate', $case);

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
     */
    public function storeDocument(
        Request $request,
        CaseFile $case
    ) {
        Gate::authorize('participate', $case);

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

        $file = $request->file('document');

        $path = $file->store(
            "cases/{$case->id}/documents",
            'private'
        );

        Document::create([
            'case_id' => $case->id,
            'uploaded_by' => Auth::id(),
            'title' => $data['title'],
            'file_path' => $path,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize(),
        ]);

        return back()->with(
            'status',
            'Document uploaded successfully.'
        );
    }

    /**
     * Download a case document.
     */

    public function downloadDocument(CaseFile $case, Document $document)
    {
        Gate::authorize('participate', $case);

        abort_unless(
            $document->case_id === $case->id,
            404
        );

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('private');

        abort_unless(
            $disk->exists($document->file_path),
            404,
            'Document not found.'
        );

        return $disk->download(
            $document->file_path,
            $document->title
        );
    }
}
