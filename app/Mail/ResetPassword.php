<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $mailMessage;
    public $subject;
    public $url;

    public function __construct($message , $subject , $url)
    {
        $this->mailMessage = $message;
        $this->subject = $subject;
        $this->url = $url;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'mail',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
