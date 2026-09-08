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
     */
    public function toMail(object $notifiable): MailMessage
    {
        $appointment = $this->appointment;

        return (new MailMessage)
            ->subject('New Appointment Request - LawFirm')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have received a new appointment request.')
            ->line('Appointment Date: ' . $appointment->appointment_date)
            ->line('Appointment Time: ' . $appointment->appointment_time)
            ->line('Status: Pending')
            ->action('View Appointments',
                url('/lawyer/appointments')
            )->line('Please log in to your LawFirm account to review the appointment.');
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