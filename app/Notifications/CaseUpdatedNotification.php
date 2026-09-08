<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Number of attempts before the job is marked as failed.
     */
    public int $tries = 3;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Appointment $appointment
    ) {
        //
    }

    /**
     * Notification channels.
     *
     * Database = notification appears inside the application.
     * Mail = notification is sent to Mailpit.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    /**
     * Database notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_appointment',
            'title' => 'New Appointment',
            'message' => 'You have received a new appointment request.',
            'appointment_id' => $this->appointment->id,
            'case_id' => $this->appointment->case_id,
            'date' => $this->appointment->appointment_date,
            'time' => $this->appointment->appointment_time,
        ];
    }

    /**
     * Email notification.
     *
     * Uses the custom LawFirm Blade email view.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appointment = $this->appointment;

        return (new MailMessage)
            ->subject('New Appointment | LawFirm')
            ->view('emails.lawfirm-notification', [
                'subject' => 'New Appointment | LawFirm',

                'type' => 'Appointments',

                'heading' => 'New Appointment Scheduled',

                'greeting' => 'Hello ' . $notifiable->name . ',',

                'message' => 'You have received a new appointment request through the LawFirm system.',

                'details' => [
                    'Date' => $appointment->appointment_date,
                    'Time' => $appointment->appointment_time,
                    'Status' => 'Pending',
                ],

                'actionUrl' => url('/lawyer/appointments'),

                'actionText' => 'VIEW APPOINTMENT',
            ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_appointment',
            'title' => 'New Appointment',
            'message' => 'You have received a new appointment request.',
            'appointment_id' => $this->appointment->id,
        ];
    }
}