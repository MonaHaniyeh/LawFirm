<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\CaseFile;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /** * Display the client's appointments. */
    public function index() {
        $user = Auth::user(); 
        /* |-------------------------------------------------------------------------- 
        | Client's Cases 
        |-------------------------------------------------------------------------- */
        $cases = CaseFile::where('client_id', $user->id)->with('lawyer')->orderByDesc('start_date')->get();
        
        /* |-------------------------------------------------------------------------- 
        | Client's Appointments 
        |-------------------------------------------------------------------------- */
        $appointments = Appointment::where('client_id', $user->id)->with(['lawyer', 'case',])->orderByDesc('appointment_date')->orderByDesc('appointment_time')->get(); 
        
        /* |-------------------------------------------------------------------------- | Return Appointments Page |-------------------------------------------------------------------------- */
        return view('client.appointments.index', compact('cases', 'appointments'));
    }


    /** * Store a new appointment request. */
    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate(
            ['case_id' => ['required', 'exists:cases,id',], 
            'date' => ['required', 'date',], 
            'time' => ['required',], 
            'location' => ['required', 'string', 'max:255',], 
            'note' => ['nullable', 'string', 'max:2000',],]); 
            
            /* |-------------------------------------------------------------------------- 
            | Make Sure The Case Belongs To This Client 
            |-------------------------------------------------------------------------- */
        $case = CaseFile::where('id', $validated['case_id'])->where('client_id', $user->id)->firstOrFail(); 
        
        /* |-------------------------------------------------------------------------- 
        | Create Appointment 
        |-------------------------------------------------------------------------- */
        $appointment = Appointment::create(['client_id' => $user->id, 'lawyer_id' => $case->lawyer_id, 'case_id' => $case->id, 'appointment_date' => $validated['date'], 'appointment_time' => $validated['time'], 
        
        /* |-------------------------------------------------------------------------- 
        | IMPORTANT: | The Appointment model/database uses meeting_location, | not location. 
        |-------------------------------------------------------------------------- */ 
        'meeting_location' => $validated['location'], 
        'note' => $validated['note'] ?? null, 
        
        /* |-------------------------------------------------------------------------- 
        | New appointment requests start as pending. | The lawyer can approve/reject them. 
        |-------------------------------------------------------------------------- */ 
        'status' => 'pending',]); 
        
        /* |-------------------------------------------------------------------------- 
        | Load Appointment Relationships 
        |-------------------------------------------------------------------------- */
        $appointment->load(['client', 'lawyer', 'case',]); 
        
        /* |-------------------------------------------------------------------------- 
        | Notify The Lawyer |-------------------------------------------------------------------------- 
        | | The client created the appointment, so the lawyer receives | the new appointment notification. 
        | | The notification uses: | - Database channel | - Email channel | - Queue 
        |-------------------------------------------------------------------------- */


        $appointment->lawyer->notify(new NewAppointmentNotification($appointment)); 
        
        /* |-------------------------------------------------------------------------- 
        | Redirect Back To Client Appointments 
        |-------------------------------------------------------------------------- */
        return redirect()->route('client.appointments')
        ->with('success', 'Your appointment request has been submitted successfully.');
    }
}
