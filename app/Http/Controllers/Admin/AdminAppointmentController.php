<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;

class AdminAppointmentController extends Controller
{
    /**
     * Display all appointments.
     */
    public function index()
    {
        $appointments = Appointment::with([
            'client:id,name,email',
            'lawyer:id,name,email',
            'case:id,case_number',
        ])
            ->latest()
            ->paginate(15);

        return view(
            'admin.appointments.index',
            compact('appointments')
        );
    }

    /**
     * Display one appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load([
            'client',
            'lawyer',
            'case',
        ]);

        return view(
            'admin.appointments.show',
            compact('appointment')
        );
    }
}