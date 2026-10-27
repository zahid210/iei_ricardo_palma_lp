<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Consulta Web - I.E.I. Ricardo Palma: '.$this->contact->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->buildHtml(),
        );
    }

    protected function buildHtml(): string
    {
        $nombre = e($this->contact->nombre);
        $telefono = e($this->contact->telefono ?? 'No especificado');
        $correo = e($this->contact->correo);
        $nivel = e($this->contact->nivel ?? 'No especificado');
        $mensaje = nl2br(e($this->contact->mensaje));
        $fecha = now()->format('d/m/Y H:i');

        return <<<HTML
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Consulta Escolar</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #262626; line-height: 1.6; padding: 24px; background-color: #F8F9F8;">
<div style="max-width: 600px; margin: 0 auto; border: 1px solid #E5E7EB; border-radius: 16px; overflow: hidden; background-color: #FFFFFF; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
    <div style="background-color: #0C3831; border-bottom: 3px solid #129582; color: #FFFFFF; padding: 20px 24px;">
        <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: #F5A623; font-weight: bold; display: block; margin-bottom: 4px;">I.E.I. N° 31756 Ricardo Palma</span>
        <h2 style="margin: 0; font-size: 18px; font-weight: bold; text-transform: uppercase;">Nueva Consulta desde la Web</h2>
    </div>

    <div style="padding: 24px;">
        <p style="margin-top: 0; font-size: 14px; color: #525252;">
            Se ha recibido una nueva solicitud de contacto a través del sitio web oficial:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 13.5px;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #737373; width: 35%; font-weight: bold;">Remitente / Apoderado:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #171717; font-weight: 600;">{$nombre}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #737373; font-weight: bold;">Teléfono / WhatsApp:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #171717;">{$telefono}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #737373; font-weight: bold;">Correo Electrónico:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #129582; font-weight: 600;"><a href="mailto:{$correo}" style="color: #129582; text-decoration: none;">{$correo}</a></td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #737373; font-weight: bold;">Nivel de Interés:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #F3F4F6; color: #171717;"><span style="background-color: #F0FDFA; color: #129582; padding: 2px 8px; border-radius: 6px; font-weight: bold; font-size: 12px; border: 1px solid #CCFBF1;">{$nivel}</span></td>
            </tr>
            <tr>
                <td style="padding: 10px 0; color: #737373; font-weight: bold;">Fecha de Envío:</td>
                <td style="padding: 10px 0; color: #737373; font-size: 12px;">{$fecha}</td>
            </tr>
        </table>

        <div style="margin-top: 10px;">
            <span style="font-size: 12px; font-weight: bold; color: #404040; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 6px;">Mensaje del Usuario:</span>
            <div style="background-color: #FBFBFA; padding: 16px; border-radius: 12px; border: 1px solid #E5E7EB; font-size: 13.5px; color: #262626; line-height: 1.6;">
                {$mensaje}
            </div>
        </div>
    </div>

    <div style="background-color: #F8F9F8; padding: 14px 24px; text-align: center; font-size: 11px; color: #A3A3A3; border-top: 1px solid #E5E7EB;">
        Notificación interna automática generada para el Webmail institucional de la I.E.I. N° 31756 Ricardo Palma.
    </div>
</div>
</body>
</html>
HTML;
    }

    public function attachments(): array
    {
        return [];
    }
}
