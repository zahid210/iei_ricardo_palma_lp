<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable; // <- Volvemos a importar esto
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels; // <- Y esto

class ContactNotification extends Mailable
{
    use Queueable, SerializesModels; // <- Los declaramos aquí adentro

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consulta Web - I.E.I. Ricardo Palma',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
