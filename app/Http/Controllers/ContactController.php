<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;

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
        ],[
            'required' => 'Este campo es obligatorio',
            'email' => 'Ingresa un correo válido',
            'mensaje' => 'El texto es demasiado largo',
        ]);

        $contact = Contact::create($validated);

        Mail::to('iericard@iericardopalmapasco.edu.pe')->send(new ContactNotification($contact));

        return back()->with('success', '¡Gracias por escribirnos! Tu consulta ha sido recibido exitosamente.');

    }

}
