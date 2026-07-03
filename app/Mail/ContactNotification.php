<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactNotification extends Mailable
{
    public $contact;

    /**
     * Create a new message instance.
     */
    public function __construct(Contact $contact)
    {
        // Inyectamos el contacto guardado en la base de datos
        $this->contact = $contact;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consulta Web - I.E.I. Ricardo Palma',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact', // <- Apunta a resources/views/emails/contact.blade.php
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
