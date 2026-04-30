<?php
namespace App\Mail;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $client;
    public $password;

    public function __construct(Client $client, $password)
    {
        $this->client = $client;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Bienvenue sur notre plateforme')
            ->view('emails.client-welcome');
    }
}