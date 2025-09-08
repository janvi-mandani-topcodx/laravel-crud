<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailUserData extends Mailable
{
    use Queueable, SerializesModels;


    public  $mailMessage;
    public  $subject;
    public function __construct($message , $subject)
    {
        $this->mailMessage = $message;
        $this->subject = $subject;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email User Data',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'user-data-mail',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
