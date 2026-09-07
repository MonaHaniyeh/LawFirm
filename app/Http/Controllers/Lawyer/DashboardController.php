<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseFile;
use App\Models\Document;
use App\Models\Invoice;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lawyer = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | MY CASES
        |--------------------------------------------------------------------------
        */

        $cases = CaseFile::with('client')
            ->where('lawyer_id', $lawyer->id)
            ->latest('start_date')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PENDING APPOINTMENTS
        |--------------------------------------------------------------------------
        */

        $pendingAppointments = Appointment::with([
                'client',
                'case',
            ])
            ->where('lawyer_id', $lawyer->id)
            ->where('status', 'pending')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT MESSAGES
        |--------------------------------------------------------------------------
        |
        | A lawyer can be involved in a message as:
        | sender OR receiver.
        |
        */

        $recentMessages = Message::with([
                'sender',
                'receiver',
                'case',
            ])
            ->where(function ($query) use ($lawyer) {
                $query->where('sender_id', $lawyer->id)
                    ->orWhere('receiver_id', $lawyer->id);
            })
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT DOCUMENTS
        |--------------------------------------------------------------------------
        |
        | Documents don't have lawyer_id.
        | They belong to cases.
        |
        */

        $recentDocuments = Document::with([
                'case',
                'uploader',
            ])
            ->whereHas('case', function ($query) use ($lawyer) {
                $query->where('lawyer_id', $lawyer->id);
            })
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT INVOICES
        |--------------------------------------------------------------------------
        |
        | Invoices don't have lawyer_id.
        | They belong to cases.
        |
        */

        $recentInvoices = Invoice::with([
                'case',
                'client',
            ])
            ->whereHas('case', function ($query) use ($lawyer) {
                $query->where('lawyer_id', $lawyer->id);
            })
            ->latest()
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD STATISTICS
        |--------------------------------------------------------------------------
        */

        $stats = [

            /*
            | Your database uses:
            | opened / closed
            */

            'open_cases' => CaseFile::where(
                    'lawyer_id',
                    $lawyer->id
                )
                ->where('status', 'opened')
                ->count(),

            /*
            | Your database uses:
            | pending / scheduled / completed / rejected
            */

            'pending_appointments' => Appointment::where(
                    'lawyer_id',
                    $lawyer->id
                )
                ->where('status', 'pending')
                ->count(),

            /*
            | Number of unique clients assigned to this lawyer.
            */

            'clients' => CaseFile::where(
                    'lawyer_id',
                    $lawyer->id
                )
                ->whereNotNull('client_id')
                ->distinct('client_id')
                ->count('client_id'),

            /*
            | New messages received by the lawyer.
            */

            'unread_messages' => Message::where(
                    'receiver_id',
                    $lawyer->id
                )
                ->where('is_new', true)
                ->count(),

            /*
            | Documents belonging to this lawyer's cases.
            */

            'documents' => Document::whereHas(
                    'case',
                    function ($query) use ($lawyer) {
                        $query->where(
                            'lawyer_id',
                            $lawyer->id
                        );
                    }
                )
                ->count(),

            /*
            | Invoices belonging to this lawyer's cases.
            */

            'invoices' => Invoice::whereHas(
                    'case',
                    function ($query) use ($lawyer) {
                        $query->where(
                            'lawyer_id',
                            $lawyer->id
                        );
                    }
                )
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('lawyer.dashboard', [
            'lawyer' => $lawyer,
            'cases' => $cases,
            'pendingAppointments' => $pendingAppointments,
            'recentMessages' => $recentMessages,
            'recentDocuments' => $recentDocuments,
            'recentInvoices' => $recentInvoices,
            'stats' => $stats,
        ]);
    }
}