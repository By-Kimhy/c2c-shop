<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $payload;
    // public $isCopy = false; // if you want copy behavior

    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    public function build()
    {
        return $this
            ->subject('New contact from: ' . ($this->payload['name'] ?? 'Unknown'))
            ->replyTo($this->payload['email'])
            ->view('emails.contact')
            ->with(['data' => $this->payload]);
    }
}
