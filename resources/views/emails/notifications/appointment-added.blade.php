@include('emails.layouts.lawfirm', [
    'subject' => 'New Appointment | LawFirm',
    'label' => 'Appointments',
    'heading' => 'New Appointment Scheduled',
    'greeting' => 'Hello ' . ($user->name ?? 'there') . ',',
    'message' =>
        'A new appointment has been added to your LawFirm account. Please review the appointment details below.',
    'details' => [
        'Date' => isset($appointment->date)
            ? \Carbon\Carbon::parse($appointment->date)->format('F d, Y')
            : $appointment->appointment_date ?? 'N/A',
        'Time' => isset($appointment->time)
            ? \Carbon\Carbon::parse($appointment->time)->format('h:i A')
            : $appointment->appointment_time ?? 'N/A',
        'Lawyer' => $appointment->lawyer->name ?? ($appointment->lawyer_name ?? 'N/A'),
        'Status' => ucfirst($appointment->status ?? 'Scheduled'),
    ],
    'actionUrl' => $actionUrl ?? url('/appointments'),
    'actionText' => 'VIEW APPOINTMENT',
])
