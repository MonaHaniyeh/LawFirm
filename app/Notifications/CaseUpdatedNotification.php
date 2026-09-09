<?php

namespace App\Notifications;

use App\Models\CaseFile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CaseUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public CaseFile $case
    ) {
    }

    // ...
}