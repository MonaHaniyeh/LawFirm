<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display the client's appointments.
     */
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Client's Cases
        |--------------------------------------------------------------------------
        */
        $cases = CaseFile::where('client_id', $user->id)
            ->with('lawyer')
            ->orderByDesc('start_date')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Client's Appointments
        |--------------------------------------------------------------------------
        */
        $appointments = Appointment::where('client_id', $user->id)
            ->with([
                'lawyer',
                'case',
            ])
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Appointments Page
        |--------------------------------------------------------------------------
        */
        return view('client.appointments.index', compact(
            'cases',
            'appointments'
        ));
    }


    /**
     * Store a new appointment request.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'case_id' => [
                'required',
                'exists:cases,id',
            ],

            'date' => [
                'required',
                'date',
            ],

            'time' => [
                'required',
            ],

            'location' => [
                'required',
                'string',
                'max:255',
            ],

            'note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Make Sure The Case Belongs To This Client
        |--------------------------------------------------------------------------
        */
        $case = CaseFile::where('id', $validated['case_id'])
            ->where('client_id', $user->id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Create Appointment
        |--------------------------------------------------------------------------
        */
        Appointment::create([
            'client_id' => $user->id,
            'lawyer_id' => $case->lawyer_id,
            'case_id' => $case->id,

            'appointment_date' => $validated['date'],
            'appointment_time' => $validated['time'],

            'location' => $validated['location'],
            'note' => $validated['note'] ?? null,

            'status' => 'pending',
        ]);


        return redirect()
            ->route('client.appointments')
            ->with('success', 'Your appointment request has been submitted successfully.');
    }
}