<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\CaseFile;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{
    /**
     * Display invoices with status filtering and client search.
     */
    public function index(Request $request)
    {
        $invoices = Invoice::with(['client', 'case'])
            // Filter by status
            ->when(
                $request->filled('status'),
                fn ($q) => $q->where(
                    'status',
                    $request->input('status')
                )
            )

            // Search by client name or email
            ->when(
                $request->filled('search'),
                function ($q) use ($request) {
                    $search = trim($request->input('search'));

                    $q->whereHas('client', function ($clientQuery) use ($search) {
                        $clientQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }
            )

            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'accountant.invoices.index',
            compact('invoices')
        );
    }

    /**
     * Show the create invoice form.
     */
    public function create()
    {
        $cases = CaseFile::with('client')
            ->where('status', 'opened')
            ->get();

        return view(
            'accountant.invoices.create',
            compact('cases')
        );
    }

    /**
     * Store a newly created invoice.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id' => [
                'required',
                'exists:cases,id',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'due_date' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'sent',
                    'paid',
                    'overdue',
                    'void',
                ]),
            ],
        ]);

        $case = CaseFile::findOrFail($data['case_id']);

        $invoiceData = [
            'case_id' => $case->id,
            'client_id' => $case->client_id,
            'accountant_id' => Auth::id(),
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'status' => $data['status'],
        ];

        /*
        |--------------------------------------------------------------------------
        | Paid timestamp
        |--------------------------------------------------------------------------
        |
        | If the accountant creates the invoice directly as paid,
        | record the payment timestamp automatically.
        |
        */
        if ($data['status'] === 'paid') {
            $invoiceData['paid_at'] = now();
        }

        $invoice = Invoice::create($invoiceData);

        return redirect()
            ->route('accountant.invoices.show', $invoice)
            ->with('status', 'Invoice created.');
    }

    /**
     * Display a single invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'case',
            'accountant',
        ]);

        return view(
            'accountant.invoices.show',
            compact('invoice')
        );
    }

    /**
     * Show the edit invoice form.
     */
    public function edit(Invoice $invoice)
    {
        return view(
            'accountant.invoices.edit',
            compact('invoice')
        );
    }

    /**
     * Update an existing invoice.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0',
                'max:999999.99',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'sent',
                    'paid',
                    'overdue',
                    'void',
                ]),
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Paid timestamp
        |--------------------------------------------------------------------------
        |
        | Set paid_at when the invoice changes to paid.
        |
        */
        if (
            $data['status'] === 'paid'
            && $invoice->status !== 'paid'
        ) {
            $data['paid_at'] = now();
        }

        /*
        | If an invoice is changed away from paid,
        | remove the old paid timestamp.
        */
        if (
            $data['status'] !== 'paid'
            && $invoice->status === 'paid'
        ) {
            $data['paid_at'] = null;
        }

        $invoice->update($data);

        return back()->with(
            'status',
            'Invoice updated.'
        );
    }
}