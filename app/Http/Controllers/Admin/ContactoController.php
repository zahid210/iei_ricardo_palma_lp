<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $mensajes = Contact::orderByDesc('created_at')->paginate(20);
        return view('admin.mensajes.index', compact('mensajes'));
    }

    public function show(Contact $contacto)
    {
        return view('admin.mensajes.show', compact('contacto'));
    }

    public function destroy(Contact $contacto)
    {
        $contacto->delete();
        return redirect()->route('admin.mensajes.index')->with('success', 'Mensaje eliminado correctamente.');
    }
}
