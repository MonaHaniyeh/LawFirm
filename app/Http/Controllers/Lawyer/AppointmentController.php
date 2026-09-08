<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Jobs\SendAppointmentApprovedMail;
use App\Jobs\SendAppointmentRejectedMail;
use App\Models\Appointment;
use App\Models\CaseFile;
use App\Notifications\NewAppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display lawyer appointments.
     */
    public function index()
    {
        $appointments = Appointment::query()
            ->where('lawyer_id', Auth::id())
            ->with(['client', 'case'])
            ->latest()
            ->paginate(15);

        return view(
            'lawyer.appointments.index',
            compact('appointments')
        );
    }

    /**
     * Display appointment scheduling page.
     */
    public function schedule()
    {
        // Only show cases belonging to the logged-in lawyer.
        $cases = CaseFile::query()
            ->where('lawyer_id', Auth::id())
            ->with('client')
            ->latest()
            ->get();

        return view(
            'lawyer.appointments.schedule',
            compact('cases')
        );
    }

    /**
     * Store a new appointment.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'case_id' => [
                'required',
                'exists:cases,id',
            ],

            'appointment_date' => [
                'required',
                'date',
            ],

            'appointment_time' => [
                'required',
            ],

            'reason' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'note' => [
                'nullable',
                'string',
                'max:2000',
            ],

            'meeting_location' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        // Make sure the selected case belongs to this lawyer.
        $case = CaseFile::query()
            ->where('id', $data['case_id'])
            ->where('lawyer_id', Auth::id())
            ->firstOrFail();

        // Get the client from the selected case.
        $clientId = $case->client_id;

        // Create appointment.
        $appointment = Appointment::create([
            'case_id' => $case->id,
            'client_id' => $clientId,
            'lawyer_id' => Auth::id(),
            'appointment_date' => $data['appointment_date'],
            'appointment_time' => $data['appointment_time'],
            'meeting_location' => $data['meeting_location'] ?? null,
            'note' => $data['note'] ?? ($data['reason'] ?? null),
            'status' => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | SEND NOTIFICATION TO CLIENT
        |--------------------------------------------------------------------------
        |
        | The appointment has been created by the lawyer.
        | Notify the client through:
        |
        | 1. Database notification
        | 2. Email notification
        |
        | Because NewAppointmentNotification implements ShouldQueue,
        | Laravel will place the notification into the jobs table.
        |
        */

        $appointment->load([
            'client',
            'lawyer',
            'case',
        ]);

        $appointment->client->notify(
            new NewAppointmentNotification($appointment)
        );

        return redirect()
            ->route('lawyer.appointments.index')
            ->with(
                'status',
                'Appointment scheduled successfully.'
            );
    }

    /**
     * Approve or reject an appointment.
     *
     * This endpoint uses POST.
     */
    public function respond(
        Request $request,
        Appointment $appointment
    ) {
        // Make sure this appointment belongs to the logged-in lawyer.
        abort_unless(
            (int) $appointment->lawyer_id === (int) Auth::id(),
            403
        );

        // Validate the requested action.
        $data = $request->validate([
            'status' => [
                'required',
                'in:approved,rejected',
            ],
        ]);

        // Update appointment status.
        $appointment->update([
            'status' => $data['status'],
        ]);

        // Refresh the appointment with the new status.
        $appointment->refresh();

        /*
        |--------------------------------------------------------------------------
        | APPROVED
        |--------------------------------------------------------------------------
        */

        if ($data['status'] === 'approved') {

            SendAppointmentApprovedMail::dispatch($appointment);

            return redirect()
                ->route('lawyer.appointments.index')
                ->with(
                    'status',
                    'Appointment approved successfully.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | REJECTED
        |--------------------------------------------------------------------------
        */

        if ($data['status'] === 'rejected') {

            SendAppointmentRejectedMail::dispatch($appointment);

            return redirect()
                ->route('lawyer.appointments.index')
                ->with(
                    'status',
                    'Appointment rejected successfully.'
                );
        }

        // Fallback.
        return redirect()
            ->route('lawyer.appointments.index');
    }
}