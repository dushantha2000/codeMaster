<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Mail;
use App\Mail\VerificationMail;

class SendVerificationMailJob implements ShouldQueue
{
    use Queueable;

    public $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->details["email"])->send(new VerificationMail($this->details["code"]));
    }
}
