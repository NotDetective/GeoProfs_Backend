<?php

namespace App\Jobs;

use App\Mail\NotificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $message,
        public string $receiver
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new NotificationMail($this->message, $this->receiver);
        Mail::to($this->receiver->email)->send($email);
    }
}
