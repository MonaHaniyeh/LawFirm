<?php

namespace App\Http\Controllers\Client;

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
use Illuminate\Support\Str;

class CaseController extends Controller
{
    /**
     * Display the client's cases.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', CaseFile::class);

        /** @var User $client */
        $client = Auth::user();

        $casesQuery = $client->casesAsClient()
            ->with('lawyer');

        /*
        |--------------------------------------------------------------------------
        | Filter by case type
        |--------------------------------------------------------------------------
        */
        if ($request->filled('case_type')) {
            $casesQuery->where(
                'case_type',
                $request->case_type
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Filter by status
        |--------------------------------------------------------------------------
        */
        if ($request->filled('status')) {
            $casesQuery->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        if ($request->filled('search')) {
            $search = $request->search;

            $casesQuery->where(function ($query) use ($search) {
                $query->where(
                    'title',
                    'like',
                    "%{$search}%"
                )
                    ->orWhere(
                        'description',
                        'like',
                        "%{$search}%"
                    )
                    ->orWhereHas('lawyer', function ($lawyerQuery) use ($search) {
                        $lawyerQuery
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
        | Get cases
        |--------------------------------------------------------------------------
        */
        $cases = $casesQuery
            ->latest('start_date')
            ->paginate(15)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Get case types used by this client
        |--------------------------------------------------------------------------
        */
        $caseTypes = $client->casesAsClient()
            ->whereNotNull('case_type')
            ->where('case_type', '!=', '')
            ->distinct()
            ->orderBy('case_type')
            ->pluck('case_type');

        return view(
            'client.cases.index',
            compact(
                'cases',
                'caseTypes'
            )
        );
    }

    /**
     * Show the form for filing a new case.
     */
    public function create()
    {
        Gate::authorize('create', CaseFile::class);

        $lawyers = User::where('role', 'lawyer')
            ->orderBy('name')
            ->get();

        $caseTypes = [
            'Criminal Law',
            'Civil Law',
            'Family Law',
            'Corporate Law',
            'Labor Law',
            'Real Estate Law',
            'Commercial Law',
            'Administrative Law',
            'Intellectual Property',
            'Personal Injury',
            'Other',
        ];

        return view(
            'client.cases.create',
            compact('lawyers', 'caseTypes')
        );
    }

    /**
     * Store a newly filed case.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', CaseFile::class);

        /*
        |--------------------------------------------------------------------------
        | Validate request
        |--------------------------------------------------------------------------
        */
        $data = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'lawyer_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where(function ($query) {
                        $query->where('role', 'lawyer');
                    }),
            ],

            'case_type' => [
                'required',
                'string',
                'max:100',
            ],

            'description' => [
                'required',
                'string',
                'min:10',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Generate unique case number
        |--------------------------------------------------------------------------
        |
        | Example:
        | CASE-2026-A8F31C2D
        |
        */
        do {
            $caseNumber =
                'CASE-' .
                now()->format('Y') .
                '-' .
                strtoupper(Str::random(8));
        } while (
            CaseFile::where(
                'case_number',
                $caseNumber
            )->exists()
        );

        /*
        |--------------------------------------------------------------------------
        | Create case
        |--------------------------------------------------------------------------
        */
        $case = CaseFile::create([
            'case_number' => $caseNumber,
            'client_id' => Auth::id(),
            'lawyer_id' => $data['lawyer_id'],
            'title' => $data['title'],
            'case_type' => $data['case_type'],
            'description' => $data['description'],
            'status' => 'opened',
            'start_date' => now()->toDateString(),
        ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect to case
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'client.cases.show',
                $case
            )
            ->with(
                'status',
                'Your case has been filed successfully.'
            );
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
        Gate::authorize('view', $case);

        /*
        |--------------------------------------------------------------------------
        | Load case relationships
        |--------------------------------------------------------------------------
        */
        $case->load([
            'client',
            'lawyer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Get case documents
        |--------------------------------------------------------------------------
        */
        $documents = Document::where(
            'case_id',
            $case->id
        )
            ->with('uploader')
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Get case messages
        |--------------------------------------------------------------------------
        */
        $messages = Message::where(
            'case_id',
            $case->id
        )
            ->with('sender')
            ->oldest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Return case details page
        |--------------------------------------------------------------------------
        */
        return view('client.cases.show', [
            'case' => $case,
            'documents' => $documents,
            'messages' => $messages,
        ]);
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
            'client.cases.edit',
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
        Gate::authorize(
            'update',
            $case
        );

        /*
        |--------------------------------------------------------------------------
        | Validate request
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
        | Update case
        |--------------------------------------------------------------------------
        */
        $case->update($data);

        /*
        |--------------------------------------------------------------------------
        | Load relationships
        |--------------------------------------------------------------------------
        */
        $case->load([
            'client',
            'lawyer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify lawyer
        |--------------------------------------------------------------------------
        */
        if ($case->lawyer) {
            $case->lawyer->notify(
                new CaseUpdatedNotification($case)
            );
        }

        return back()->with(
            'status',
            'Case updated successfully.'
        );
    }

    /**
     * Send a message to the lawyer.
     */
    public function sendMessage(
        Request $request,
        CaseFile $case
    ) {
        Gate::authorize(
            'participate',
            $case
        );

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
            'receiver_id' => $case->lawyer_id,
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
     * IMPORTANT:
     * This method is called uploadDocument()
     * because the route uses:
     *
     * CaseController@uploadDocument
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
        | Validate document
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
        | Get uploaded file
        |--------------------------------------------------------------------------
        */
        $file = $request->file('document');

        /*
        |--------------------------------------------------------------------------
        | Store file in private storage
        |--------------------------------------------------------------------------
        */
        $path = $file->store(
            "cases/{$case->id}/documents",
            'private'
        );

        /*
        |--------------------------------------------------------------------------
        | Create document record
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
        | Load document relationships
        |--------------------------------------------------------------------------
        */
        $document->load([
            'case',
            'uploader',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Load case relationships
        |--------------------------------------------------------------------------
        */
        $case->load([
            'client',
            'lawyer',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Notify lawyer
        |--------------------------------------------------------------------------
        */
        if ($case->lawyer) {
            $case->lawyer->notify(
                new DocumentUploadedNotification($document)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Return to case page
        |--------------------------------------------------------------------------
        */
        return back()->with(
            'status',
            'Document uploaded successfully.'
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
        | Make sure document belongs to this case
        |--------------------------------------------------------------------------
        */
        abort_unless(
            $document->case_id === $case->id,
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Get private storage disk
        |--------------------------------------------------------------------------
        */
         /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('private');

        /*
        |--------------------------------------------------------------------------
        | Make sure file exists
        |--------------------------------------------------------------------------
        */
        abort_unless(
            $disk->exists($document->file_path),
            404,
            'Document not found.'
        );

        /*
        |--------------------------------------------------------------------------
        | Download document
        |--------------------------------------------------------------------------
        */
        return $disk->download(
            $document->file_path,
            $document->title
        );
    }
}
