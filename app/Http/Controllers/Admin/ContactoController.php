<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        $mensajes = Contact::orderBy('leido', 'asc')
            ->orderByDesc('created_at')
            ->paginate(20);

        $noLeidos = Contact::where('leido', false)->count();

        return view('admin.mensajes.index', compact('mensajes', 'noLeidos'));
    }

    public function show(Contact $contacto)
    {
        if (! $contacto->leido) {
            $contacto->update(['leido' => true]);
        }

        return view('admin.mensajes.show', compact('contacto'));
    }

    public function toggleLeido(Contact $contacto)
    {
        $contacto->update([
            'leido' => ! $contacto->leido,
        ]);

        $estado = $contacto->leido ? 'marcado como leído' : 'marcado como no leído';

        return back()->with('success', "Mensaje de {$contacto->nombre} {$estado}.");
    }
}
