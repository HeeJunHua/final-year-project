<?php

namespace App\Jobs;

use App\Mail\ThankYouMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ThankYouEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $event_name;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $event_name)
    {
        $this->email = $email;
        $this->event_name = $event_name;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Send the email
        Mail::to($this->email)->send(new ThankYouMail($this->event_name));
    }
}
