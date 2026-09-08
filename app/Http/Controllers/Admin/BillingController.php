<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $lawyers = User::where('role', 'lawyer')
            ->orderBy('name')
            ->get();

        // Latest billing records shown in the table
        $billings = Invoice::with([
                'client',
                'case.lawyer',
                'accountant',
            ])
            ->latest()
            ->take(20)
            ->get();

        // Billing Summary
        $totalAmount = Invoice::sum('amount');

        $paidAmount = Invoice::where('status', 'paid')
            ->sum('amount');

        $pendingAmount = Invoice::whereIn('status', [
                'pending',
                'overdue',
            ])
            ->sum('amount');

        $outstandingAmount = Invoice::whereNotIn('status', [
                'paid',
                'void',
                'cancelled',
                'canceled',
            ])
            ->sum('amount');

        return view('admin.billing.index', compact(
            'lawyers',
            'billings',
            'totalAmount',
            'paidAmount',
            'pendingAmount',
            'outstandingAmount'
        ));
    }

    public function updateRate(Request $request, User $lawyer)
    {
        abort_unless($lawyer->role === 'lawyer', 404);

        $data = $request->validate([
            'billing_rate' => [
                'required',
                'numeric',
                'min:0',
                'max:9999.99',
            ],
        ]);

        $lawyer->update($data);

        return back()->with(
            'status',
            "Billing rate updated for {$lawyer->name}."
        );
    }

    /**
     * Display a single invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'client',
            'case.lawyer',
            'accountant',
        ]);

        return view(
            'admin.billing.show',
            compact('invoice')
        );
    }
}