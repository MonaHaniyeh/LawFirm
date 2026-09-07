<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function index()
    {
        $recentInvoices = Invoice::with(['client', 'case'])
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'total_outstanding' => Invoice::whereIn('status', ['sent', 'overdue'])->sum('amount'),
            'paid_this_month' => Invoice::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->whereYear('paid_at', now()->year)
                ->sum('amount'),
            'overdue_count' => Invoice::where('status', 'overdue')->count(),
            'draft_count' => Invoice::where('status', 'draft')->count(),
        ];

        return view('accountant.dashboard', compact('recentInvoices', 'stats'));
    }
}
