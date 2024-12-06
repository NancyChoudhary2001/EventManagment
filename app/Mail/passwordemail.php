<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class passwordemail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $fullname;

    public function __construct($user, $password, $fullname)
    {
        $this->user = $user;
        $this->password = $password;
        $this->fullname = $fullname;
    }
    
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'User Password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.password',
            with: [
                'fullname' => $this->fullname,
                'password' => $this->password,
                'user' => $this->user,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
