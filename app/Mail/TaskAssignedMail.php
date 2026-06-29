<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Tache;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Tache $tache
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Access Morocco — Nouvelle tâche assignée : ' . $this->tache->titre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task-assigned',
        );
    }
}
