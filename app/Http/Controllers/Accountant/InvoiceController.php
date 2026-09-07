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
    public function index(Request $request)
    {
        $invoices = Invoice::with(['client', 'case'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), fn($q) => $q->whereHas(
                'client',
                fn($c) => $c->where('name', 'like', "%{$request->q}%")
            ))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('accountant.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $cases = CaseFile::with('client')->where('status', 'opened')->get();

        return view('accountant.invoices.create', compact('cases'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id' => ['required', 'exists:cases,id'],
            'amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['nullable', 'date', 'after_or_equal:today'],
        ]);

        $case = CaseFile::findOrFail($data['case_id']);

        $invoice = Invoice::create([
            'case_id' => $case->id,
            'client_id' => $case->client_id,
            'accountant_id' => Auth::id(),
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'due_date' => $data['due_date'] ?? null,
            'status' => 'draft',
        ]);

        return redirect()->route('accountant.invoices.show', $invoice)
            ->with('status', 'Invoice created.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client', 'case', 'accountant']);

        return view('accountant.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('accountant.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['draft', 'sent', 'paid', 'overdue', 'void'])],
        ]);

        // Stamp paid_at the moment status transitions into 'paid' —
        // never let the client set this timestamp directly.
        if ($data['status'] === 'paid' && $invoice->status !== 'paid') {
            $data['paid_at'] = now();
        }

        $invoice->update($data);

        return back()->with('status', 'Invoice updated.');
    }
}
