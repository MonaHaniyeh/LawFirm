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
     *
     * database = notification inside the application
     * mail     = email notification sent to Mailpit
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
     *
     * Uses the custom LawFirm email Blade view.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $document = $this->document;
        $case = $document->case;

        /*
        |--------------------------------------------------------------------------
        | Determine the case URL based on the recipient role.
        |--------------------------------------------------------------------------
        |
        | Lawyer → Lawyer case page
        | Client → Client case page
        |
        */

        if ($notifiable->role === 'lawyer') {

            $caseUrl = $case
                ? url('/lawyer/cases/' . $case->id)
                : url('/lawyer/cases');

        } else {

            $caseUrl = $case
                ? url('/client/cases/' . $case->id)
                : url('/client/cases');
        }

        /*
        |--------------------------------------------------------------------------
        | Custom LawFirm Email
        |--------------------------------------------------------------------------
        */

        return (new MailMessage)
            ->subject('New Document | LawFirm')

            ->view('emails.lawfirm-notification', [

                /*
                |--------------------------------------------------------------------------
                | Email subject
                |--------------------------------------------------------------------------
                */
                'subject' => 'New Document | LawFirm',

                /*
                |--------------------------------------------------------------------------
                | Small category label
                |--------------------------------------------------------------------------
                */
                'type' => 'Documents',

                /*
                |--------------------------------------------------------------------------
                | Main email heading
                |--------------------------------------------------------------------------
                */
                'heading' => 'New Document Uploaded',

                /*
                |--------------------------------------------------------------------------
                | Recipient greeting
                |--------------------------------------------------------------------------
                */
                'greeting' => 'Hello ' . ($notifiable->name ?? 'User') . ',',

                /*
                |--------------------------------------------------------------------------
                | Main message
                |--------------------------------------------------------------------------
                */
                'message' =>
                    'A new document has been uploaded to one of your cases through the LawFirm system.',

                /*
                |--------------------------------------------------------------------------
                | Information displayed in the email
                |--------------------------------------------------------------------------
                */
                'details' => [

                    'Document' =>
                        $document->title ?? 'Untitled Document',

                    'Case Number' =>
                        $case?->case_number ?? 'N/A',

                    'Uploaded By' =>
                        $document->uploader?->name ?? 'User',

                    'File Type' =>
                        $document->mime_type ?? 'Unknown',
                ],

                /*
                |--------------------------------------------------------------------------
                | Button URL
                |--------------------------------------------------------------------------
                */
                'actionUrl' => $caseUrl,

                /*
                |--------------------------------------------------------------------------
                | Button text
                |--------------------------------------------------------------------------
                */
                'actionText' => 'VIEW CASE',
            ]);
    }

    /**
     * Array representation.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'document_uploaded',

            'title' => 'New Document Uploaded',

            'message' =>
                'A new document has been uploaded to your case.',

            'document_id' =>
                $this->document->id,

            'document_title' =>
                $this->document->title,

            'case_id' =>
                $this->document->case?->id,

            'case_number' =>
                $this->document->case?->case_number,

            'uploaded_by' =>
                $this->document->uploaded_by,

            'uploader_name' =>
                $this->document->uploader?->name,
        ];
    }
}