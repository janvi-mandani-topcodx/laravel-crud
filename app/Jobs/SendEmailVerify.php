<?php

namespace App\Jobs;

use App\Mail\EmailVarification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailVerify implements ShouldQueue
{
    use Queueable;
    public $mailMessage;
    public $subject;
    public function __construct($message , $subject)
    {
        $this->mailMessage = $message;
        $this->subject = $subject;
    }

    public function handle(): void
    {
        $to = auth()->user();
        Mail::to($to)->send(new EmailVarification($this->mailMessage , $this->subject));
    }
}
