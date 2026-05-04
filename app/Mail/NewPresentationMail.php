<?php

namespace App\Mail;

use App\Models\Presentation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPresentationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $presentation;
    public $client;

    public function __construct(Presentation $presentation)
    {
        $this->presentation = $presentation;
        $this->client = $presentation->dossier->client;
    }

    public function build()
    {
        return $this->subject('Nouvelle présentation de voyage — Access Morocco')
                    ->view('emails.new_presentation');
    }
}
