<?php

namespace App\Jobs;

use App\Mail\AppointmentRejectedMail;
use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAppointmentRejectedMail implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public Appointment $appointment
    ) {
    }

    public function handle(): void
    {
        $this->appointment->load([
            'client',
            'case',
            'lawyer',
        ]);

        if (!$this->appointment->client) {
            return;
        }

        Mail::to($this->appointment->client->email)
            ->send(
                new AppointmentRejectedMail(
                    $this->appointment
                )
            );
    }
}
