<?php

namespace App\Http\Controllers;

use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:9',
            'correo' => 'required|email|max:255',
            'nivel' => 'required|string',
            'mensaje' => 'required|string|max:255',
        ], [
            'required' => 'Este campo es obligatorio.',
            'nombre.max' => 'El nombre no debe exceder los 255 caracteres.',
            'telefono.max' => 'El teléfono no debe exceder los 9 dígitos.',
            'correo.email' => 'Ingresa un correo electrónico válido.',
            'correo.max' => 'El correo no debe exceder los 255 caracteres.',
            'mensaje.max' => 'El mensaje no debe exceder los 255 caracteres.',
        ]);

        $contact = Contact::create($validated);

        try {
            $destinatario = config('mail.to.address', env('MAIL_TO_ADDRESS', 'soporte@iericardopalmapasco.edu.pe'));
            Mail::to($destinatario)->send(new ContactNotification($contact));
        } catch (\Throwable $e) {
            Log::error('Error enviando notificación de contacto', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
            ]);
        }

        return back()->with('success', '¡Gracias por escribirnos! Tu consulta ha sido recibida exitosamente.');
    }
}
