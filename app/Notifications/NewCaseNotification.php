<?php

namespace App\Notifications;

use App\Models\CaseFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCaseNotification extends Notification implements ShouldQueue
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
        public CaseFile $case
    ) {
        //
    }

    /**
     * Get the notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    /**
     * Store the notification in the database.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'new_case',
            'title' => 'New Case Filed',
            'message' => 'A new legal case has been filed and assigned to you.',
            'case_id' => $this->case->id,
            'case_number' => $this->case->case_number,
            'case_type' => $this->case->case_type,
            'client_id' => $this->case->client_id,
            'client_name' => $this->case->client?->name,
            'status' => $this->case->status,
        ];
    }

    /**
     * Send the notification by email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $case = $this->case;

        return (new MailMessage)
            ->subject('New Case Filed - LawFirm')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line(
                'A new legal case has been filed and assigned to you.'
            )
            ->line(
                'Case Number: ' . $case->case_number
            )
            ->line(
                'Case Type: ' . $case->case_type
            )
            ->line(
                'Client: ' . ($case->client?->name ?? 'Client')
            )
            ->line(
                'Status: ' . ucfirst($case->status)
            )
            ->action(
                'View Case',
                url('/lawyer/cases/' . $case->id)
            )
            ->line(
                'Please log in to your LawFirm account to review the new case.'
            );
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'new_case',
            'title' => 'New Case Filed',
            'message' => 'A new legal case has been filed and assigned to you.',
            'case_id' => $this->case->id,
            'case_number' => $this->case->case_number,
            'case_type' => $this->case->case_type,
            'client_id' => $this->case->client_id,
            'status' => $this->case->status,
        ];
    }
}