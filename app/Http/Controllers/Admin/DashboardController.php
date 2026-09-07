<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseFile;
use App\Models\Document;
use App\Models\Message;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $activeCases = CaseFile::where('status', 'opened')->count();

        $clientsCount = User::where('role', 'client')->count();

        $lawyersCount = User::where('role', 'lawyer')->count();

        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $totalUsers = User::count();

        $totalDocuments = class_exists(Document::class)
            ? Document::count()
            : 0;

        $totalMessages = class_exists(Message::class)
            ? Message::count()
            : 0;


        /*
        |--------------------------------------------------------------------------
        | Recent Cases
        |--------------------------------------------------------------------------
        */

        $cases = CaseFile::with(['client', 'lawyer'])
            ->latest('start_date')
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Pending Appointments
        |--------------------------------------------------------------------------
        */

        $appointments = Appointment::with(['client', 'lawyer', 'case'])
            ->where('status', 'pending')
            ->orderBy('appointment_date')
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Activity
        |--------------------------------------------------------------------------
        |
        | We do not assume an Activity model exists yet.
        | Send an empty collection so the dashboard does not crash.
        |
        */

        $activities = collect();


        /*
        |--------------------------------------------------------------------------
        | Stats Array
        |--------------------------------------------------------------------------
        */

        $stats = [
            'active_cases' => $activeCases,
            'registered_clients' => $clientsCount,
            'lawyers_on_staff' => $lawyersCount,
            'pending_appointments' => $pendingAppointments,
            'total_users' => $totalUsers,
            'total_documents' => $totalDocuments,
            'total_messages' => $totalMessages,
        ];


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'activeCases',
            'clientsCount',
            'lawyersCount',
            'pendingAppointments',
            'totalUsers',
            'totalDocuments',
            'totalMessages',
            'cases',
            'appointments',
            'activities',
            'stats'
        ));
    }
}