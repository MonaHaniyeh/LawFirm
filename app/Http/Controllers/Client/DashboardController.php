<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $client */
        $client = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Recent Cases
        |--------------------------------------------------------------------------
        */
        $cases = $client->casesAsClient()
            ->with('lawyer')
            ->latest('start_date')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Upcoming Appointments
        |--------------------------------------------------------------------------
        |
        | New appointments are created as "pending".
        | Therefore we must include:
        |
        | pending
        | scheduled
        | confirmed
        |
        */
        $appointments = $client->appointmentsAsClient()
            ->with([
                'lawyer',
                'case',
            ])
            ->whereIn('status', [
                'pending',
                'scheduled',
                'confirmed',
            ])
            ->where(function ($query) {
                $query
                    ->whereDate('appointment_date', '>', today())

                    ->orWhere(function ($query) {
                        $query
                            ->whereDate('appointment_date', today())
                            ->where(function ($query) {
                                $query
                                    ->whereNull('appointment_time')
                                    ->orWhereTime(
                                        'appointment_time',
                                        '>=',
                                        now()->format('H:i:s')
                                    );
                            });
                    });
            })
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Client Cases Query
        |--------------------------------------------------------------------------
        */
        $clientCases = $client->casesAsClient();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */
        $stats = [

            /*
            |--------------------------------------------------------------------------
            | Open Cases
            |--------------------------------------------------------------------------
            */
            'open_cases' => (clone $clientCases)
                ->whereIn('status', [
                    'open',
                    'opened',
                    'active',
                ])
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Upcoming Appointments
            |--------------------------------------------------------------------------
            */
            'upcoming_appointments' => $client->appointmentsAsClient()
                ->whereIn('status', [
                    'pending',
                    'scheduled',
                    'confirmed',
                ])
                ->where(function ($query) {
                    $query
                        ->whereDate(
                            'appointment_date',
                            '>',
                            today()
                        )

                        ->orWhere(function ($query) {
                            $query
                                ->whereDate(
                                    'appointment_date',
                                    today()
                                )
                                ->where(function ($query) {
                                    $query
                                        ->whereNull(
                                            'appointment_time'
                                        )
                                        ->orWhereTime(
                                            'appointment_time',
                                            '>=',
                                            now()->format('H:i:s')
                                        );
                                });
                        });
                })
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Unread Messages
            |--------------------------------------------------------------------------
            */
            'unread_messages' => Message::where(
                'receiver_id',
                $client->id
            )
                ->where('is_new', true)
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Documents
            |--------------------------------------------------------------------------
            */
            'documents' => Document::whereIn(
                'case_id',
                $client->casesAsClient()->pluck('id')
            )->count(),
        ];

        return view(
            'client.dashboard',
            compact(
                'cases',
                'appointments',
                'stats'
            )
        );
    }
}