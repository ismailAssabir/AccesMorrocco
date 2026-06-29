<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmployeeUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public array $changes
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Access Morocco — Votre profil a été mis à jour',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.employee-updated',
        );
    }
}
