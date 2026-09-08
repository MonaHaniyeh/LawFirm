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
        | DASHBOARD STATISTICS
        |--------------------------------------------------------------------------
        */
        $activeCases = CaseFile::where('status', 'opened')->count();
        $totalCases = CaseFile::count();

        $clientsCount = User::where('role', 'client')->count();
        $lawyersCount = User::where('role', 'lawyer')->count();
        $totalUsers = User::count();

        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        $totalDocuments = class_exists(Document::class) ? Document::count() : 0;
        $totalMessages = class_exists(Message::class) ? Message::count() : 0;

        /*
        |--------------------------------------------------------------------------
        | RECENT CASES
        |--------------------------------------------------------------------------
        */
        $cases = CaseFile::with([
            'client',
            'lawyer',
        ])
            ->latest('start_date')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PENDING APPOINTMENTS
        |--------------------------------------------------------------------------
        |
        | These are the REAL pending appointments that will appear
        | in the Admin Dashboard.
        |
        */
        $appointments = Appointment::with([
            'client',
            'lawyer',
            'case',
        ])
            ->where('status', 'pending')
            ->orderBy('appointment_date', 'asc')
            ->take(10)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | RECENT ACTIVITY
        |--------------------------------------------------------------------------
        |
        | We don't need a separate Activity model.
        |
        | We collect recent actions from existing tables:
        |
        | - Users
        | - Cases
        | - Appointments
        | - Documents
        | - Messages
        |
        */
        $activities = collect();

        /*
        |--------------------------------------------------------------------------
        | RECENT USERS
        |--------------------------------------------------------------------------
        */
        $recentUsers = User::latest('created_at')
            ->take(5)
            ->get();

        foreach ($recentUsers as $user) {
            $activities->push([
                'type' => 'user',
                'title' => 'New user registered',
                'description' => "{$user->name} joined the system.",
                'details' => ucfirst($user->role ?? 'User') . ' account created',
                'created_at' => $user->created_at,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT CASES
        |--------------------------------------------------------------------------
        */
        $recentCases = CaseFile::latest('created_at')
            ->take(5)
            ->get();

        foreach ($recentCases as $case) {
            $caseNumber = $case->case_number ?? 'Case #' . $case->id;

            $activities->push([
                'type' => 'case',
                'title' => 'New case created',
                'description' => "{$caseNumber} was added to the system.",
                'details' => 'Case file created',
                'created_at' => $case->created_at,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT APPOINTMENTS
        |--------------------------------------------------------------------------
        */
        $recentAppointments = Appointment::with('client')
            ->latest('created_at')
            ->take(5)
            ->get();

        foreach ($recentAppointments as $appointment) {
            $clientName = $appointment->client->name ?? 'A client';
            $status = ucfirst(strtolower($appointment->status ?? 'pending'));

            $activities->push([
                'type' => 'appointment',
                'title' => 'Appointment requested',
                'description' => "{$clientName} requested an appointment.",
                'details' => "Status: {$status}",
                'created_at' => $appointment->created_at,
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT DOCUMENTS
        |--------------------------------------------------------------------------
        */
        if (class_exists(Document::class)) {
            $recentDocuments = Document::latest('created_at')
                ->take(5)
                ->get();

            foreach ($recentDocuments as $document) {
                $documentTitle = $document->title ?? $document->name ?? 'A document';

                $activities->push([
                    'type' => 'document',
                    'title' => 'Document uploaded',
                    'description' => "{$documentTitle} was uploaded.",
                    'details' => 'Document added to the system',
                    'created_at' => $document->created_at,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RECENT MESSAGES
        |--------------------------------------------------------------------------
        */
        if (class_exists(Message::class)) {
            $recentMessages = Message::latest('created_at')
                ->take(5)
                ->get();

            foreach ($recentMessages as $message) {
                $activities->push([
                    'type' => 'message',
                    'title' => 'New message',
                    'description' => 'A new message was received.',
                    'details' => 'Communication activity',
                    'created_at' => $message->created_at,
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SORT ALL ACTIVITY
        |--------------------------------------------------------------------------
        */
        $activities = $activities
            ->sortByDesc(function ($activity) {
                return $activity['created_at'];
            })
            ->take(8)
            ->values();

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD STATS ARRAY
        |--------------------------------------------------------------------------
        */
        $stats = [
            'active_cases' => $activeCases,
            'registered_clients' => $clientsCount,
            'lawyers_on_staff' => $lawyersCount,
            'pending_appointments' => $pendingAppointments,
            'total_users' => $totalUsers,
            'total_cases' => $totalCases,
            'total_documents' => $totalDocuments,
            'total_messages' => $totalMessages,
            'total_appointments' => $totalAppointments,
        ];

        /*
        |--------------------------------------------------------------------------
        | RETURN DASHBOARD
        |--------------------------------------------------------------------------
        */
        return view('admin.dashboard', compact(
            'activeCases',
            'clientsCount',
            'lawyersCount',
            'pendingAppointments',
            'totalUsers',
            'totalCases',
            'totalAppointments',
            'totalDocuments',
            'totalMessages',
            'cases',
            'appointments',
            'activities',
            'stats'
        ));
    }
}