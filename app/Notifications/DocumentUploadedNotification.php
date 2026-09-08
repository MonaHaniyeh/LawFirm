<?php

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentUploadedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Number of times the queued notification should be attempted.
     */
    public int $tries = 3;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Document $document
    ) {
        //
    }

    /**
     * Notification channels.
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
        $document = $this->document;
        $case = $document->case;

        return [
            'type' => 'document_uploaded',
            'title' => 'New Document Uploaded',
            'message' => 'A new document has been uploaded to your case.',
            'document_id' => $document->id,
            'document_title' => $document->title,
            'case_id' => $case?->id,
            'case_number' => $case?->case_number,
            'uploaded_by' => $document->uploaded_by,
            'uploader_name' => $document->uploader?->name,
            'mime_type' => $document->mime_type,
            'size_bytes' => $document->size_bytes,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Email notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $document = $this->document;
        $case = $document->case;

        /*
        |--------------------------------------------------------------------------
        | Determine where the recipient should go.
        |--------------------------------------------------------------------------
        | Lawyer → Lawyer case page
        | Client → Client case page
        |--------------------------------------------------------------------------
        */
        if ($notifiable->role === 'lawyer') {
            $caseUrl = url('/lawyer/cases/' . $case->id);
        } else {
            $caseUrl = url('/client/cases/' . $case->id);
        }

        return (new MailMessage)
            ->subject('New Document Uploaded - LawFirm')
            ->greeting(
                'Hello ' . ($notifiable->name ?? 'User') . ','
            )
            ->line(
                'A new document has been uploaded to one of your cases.'
            )
            ->line(
                'Document: ' . ($document->title ?? 'Untitled Document')
            )
            ->line(
                'Case Number: ' . ($case?->case_number ?? 'N/A')
            )
            ->line(
                'Uploaded By: ' . ($document->uploader?->name ?? 'User')
            )
            ->line(
                'File Type: ' . ($document->mime_type ?? 'Unknown')
            )
            ->action(
                'View Case',
                $caseUrl
            )
            ->line(
                'Please log in to your LawFirm account to review the uploaded document.'
            );
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document_uploaded',
            'title' => 'New Document Uploaded',
            'message' => 'A new document has been uploaded to your case.',
            'document_id' => $this->document->id,
            'document_title' => $this->document->title,
            'case_id' => $this->document->case?->id,
            'case_number' => $this->document->case?->case_number,
            'uploaded_by' => $this->document->uploaded_by,
            'uploader_name' => $this->document->uploader?->name,
        ];
    }
}