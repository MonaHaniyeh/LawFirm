<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Recent Invoices
        |--------------------------------------------------------------------------
        |
        | Get the 10 most recently created invoices from the database.
        |
        */
        $recentInvoices = Invoice::with(['client', 'case'])
            ->latest()
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Billing Statistics
        |--------------------------------------------------------------------------
        |
        | All values below are calculated directly from the invoices table.
        |
        */
        $totalOutstanding = Invoice::whereIn('status', [
            'sent',
            'overdue',
        ])->sum('amount');


        $paidThisMonth = Invoice::where('status', 'paid')
            ->whereNotNull('paid_at')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');


        $overdueCount = Invoice::where('status', 'overdue')
            ->count();


        $draftCount = Invoice::where('status', 'draft')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Statistics Array
        |--------------------------------------------------------------------------
        */
        $stats = [
            'total_outstanding' => $totalOutstanding,
            'paid_this_month'   => $paidThisMonth,
            'overdue_count'     => $overdueCount,
            'draft_count'       => $draftCount,
        ];


        return view(
            'accountant.dashboard',
            compact('recentInvoices', 'stats')
        );
    }
}
