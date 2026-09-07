<?php

namespace App\Http\Controllers\Client;

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
use Illuminate\Validation\Rules\File;

class CaseController extends Controller
{
    /**
     * Legal case type codes.
     */
    private const TYPE_CODES = [
        'Criminal Law' => 'CRIM',
        'Civil Law' => 'CIVL',
        'Family Law' => 'FAML',
        'Corporate Law' => 'CORP',
        'Bankruptcy Law' => 'BANK',
        'Employment Law' => 'EMPL',
        'Intellectual Law' => 'INTP',
        'Tax Law' => 'TAX',
        'Immigration Law' => 'IMMG',
        'Environmental Law' => 'ENVI',
        'Constitutional Law' => 'CONST',
        'International Law' => 'INTIL',
        'Human Rights Law' => 'HUMN',
        'Labor Law' => 'LABR',
        'Contract Law' => 'CNTR',
        'Real Estate Law' => 'REAL',
        'Insurance Law' => 'INSR',
        'Consumer Law' => 'CNSM',
    ];


    /**
     * Display the client's cases.
     */
    public function index()
    {
        Gate::authorize('viewAny', CaseFile::class);

        /** @var User $user */
        $user = Auth::user();

        $cases = $user->casesAsClient()
            ->with('lawyer')
            ->latest('start_date')
            ->paginate(15);

        return view('client.cases.index', compact('cases'));
    }


    /**
     * Show the create case form.
     */
    public function create()
    {
        Gate::authorize('create', CaseFile::class);

        $lawyers = User::where('role', 'lawyer')
            ->orderBy('name')
            ->get();

        $caseTypes = array_keys(self::TYPE_CODES);

        return view(
            'client.cases.create',
            compact('lawyers', 'caseTypes')
        );
    }


    /**
     * Store a new case.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', CaseFile::class);

        $data = $request->validate(
            [
                'case_type' => [
                    'required',
                    'string',
                    Rule::in(array_keys(self::TYPE_CODES)),
                ],

                'lawyer_id' => [
                    'required',
                    'integer',
                    Rule::exists('users', 'id')
                        ->where(function ($query) {
                            $query->where('role', 'lawyer');
                        }),
                ],

                'description' => [
                    'required',
                    'string',
                    'min:20',
                ],
            ],
            [
                'case_type.required' =>
                    'Please select a case type.',

                'case_type.in' =>
                    'The selected case type is invalid. Please choose one of the available legal categories.',

                'lawyer_id.required' =>
                    'Please select a lawyer.',

                'lawyer_id.exists' =>
                    'The selected lawyer is not available.',

                'description.required' =>
                    'Please describe your legal matter.',

                'description.min' =>
                    'Please provide at least 20 characters describing your legal matter.',
            ]
        );

        /** @var User $client */
        $client = Auth::user();

        $case = CaseFile::create([
            'case_number' => $this->generateCaseNumber(
                $data['lawyer_id'],
                $client->id,
                $data['case_type']
            ),

            'client_id' => $client->id,
            'lawyer_id' => $data['lawyer_id'],
            'case_type' => $data['case_type'],
            'description' => $data['description'],
            'status' => 'opened',
            'start_date' => now(),
        ]);

        return redirect()
            ->route('client.cases.show', $case)
            ->with(
                'status',
                'Your case has been filed — case number ' .
                $case->case_number
            );
    }


    /**
     * Display a specific case.
     */
    public function show(CaseFile $case)
    {
        Gate::authorize('view', $case);

        /*
        |--------------------------------------------------------------------------
        | Load the case relationships
        |--------------------------------------------------------------------------
        */

        $case->load([
            'lawyer',
            'documents.uploader',
            'messages.sender',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Explicitly pass documents and messages to the Blade view.
        |--------------------------------------------------------------------------
        */

        $documents = $case->documents;

        $messages = $case->messages;

        return view(
            'client.cases.show',
            compact(
                'case',
                'documents',
                'messages'
            )
        );
    }


    /**
     * Send a message to the lawyer.
     */
    public function sendMessage(
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
            'receiver_id' => $case->lawyer_id,
            'subject' => $data['subject'] ?? null,
            'content' => $data['content'],
            'is_new' => true,
        ]);

        return back()->with(
            'status',
            'Message sent.'
        );
    }


    /**
     * Upload a document to a case.
     *
     * Allowed:
     * - PDF
     * - DOCX
     *
     * Maximum:
     * - 10 MB
     *
     * Storage:
     * - storage/app/private/cases/{case_id}/documents/
     */
    public function uploadDocument(
        Request $request,
        CaseFile $case
    ) {
        Gate::authorize('participate', $case);

        /*
        |--------------------------------------------------------------------------
        | Validate upload
        |--------------------------------------------------------------------------
        */

        $data = $request->validate(
            [
                'title' => [
                    'required',
                    'string',
                    'max:150',
                ],

                'document' => [
                    'required',
                    File::types([
                        'pdf',
                        'docx',
                    ])->max(10 * 1024),
                ],
            ],
            [
                'title.required' =>
                    'Please enter a document title.',

                'title.max' =>
                    'The document title may not exceed 150 characters.',

                'document.required' =>
                    'Please select a document.',

                'document.max' =>
                    'The document may not be larger than 10 MB.',

                'document.file' =>
                    'The uploaded document is invalid.',

                'document.extensions' =>
                    'Only PDF and DOCX documents are allowed.',

                'document.mimes' =>
                    'Only PDF and DOCX documents are allowed.',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Get uploaded file
        |--------------------------------------------------------------------------
        */

        $file = $request->file('document');


        /*
        |--------------------------------------------------------------------------
        | Store privately
        |--------------------------------------------------------------------------
        |
        | Laravel generates a random filename.
        |
        | Example:
        |
        | storage/app/private/
        |     cases/
        |         1/
        |             documents/
        |                 abc123xyz.pdf
        |
        */

        $path = $file->store(
            "cases/{$case->id}/documents",
            'private'
        );


        /*
        |--------------------------------------------------------------------------
        | Save document information
        |--------------------------------------------------------------------------
        */

        Document::create([
            'case_id' => $case->id,

            'uploaded_by' => Auth::id(),

            'title' => $data['title'],

            'file_path' => $path,

            'mime_type' => $file->getMimeType(),

            'size_bytes' => $file->getSize(),
        ]);


        /*
        |--------------------------------------------------------------------------
        | Return to case page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('client.cases.show', $case)
            ->with(
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
        Gate::authorize('participate', $case);

        /*
        |--------------------------------------------------------------------------
        | Make sure the document belongs to this case
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $document->case_id === $case->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Use private disk
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
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Download private file
        |--------------------------------------------------------------------------
        */

        return $disk->download(
            $document->file_path,
            $document->title
        );
    }


    /**
     * Generate case number.
     */
    private function generateCaseNumber(
        int $lawyerId,
        int $clientId,
        string $caseType
    ): string {
        $requestSequence = CaseFile::where(
            'client_id',
            $clientId
        )->count() + 1;

        $typeCode = self::TYPE_CODES[$caseType] ?? 'MISC';

        return sprintf(
            '%s%d%d%d-%s',
            now()->format('Y'),
            $lawyerId,
            $clientId,
            $requestSequence,
            $typeCode
        );
    }
}
