<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->query('filtro', 'todos');
        $search = $request->query('q', '');

        $query = Contact::query();

        if ($filtro === 'no_leidos') {
            $query->where('leido', false);
        } elseif ($filtro === 'leidos') {
            $query->where('leido', true);
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('correo', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%")
                    ->orWhere('mensaje', 'like', "%{$search}%");
            });
        }

        $mensajes = $query->orderBy('leido', 'asc')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        $totalCount = Contact::count();
        $noLeidos = Contact::where('leido', false)->count();
        $leidos = Contact::where('leido', true)->count();

        return inertia('Admin/Mensajes/Index', [
            'mensajes' => $mensajes,
            'noLeidos' => $noLeidos,
            'leidos' => $leidos,
            'totalCount' => $totalCount,
            'filters' => [
                'filtro' => $filtro,
                'q' => $search,
            ],
        ]);
    }

    public function show(Contact $contacto)
    {
        if (! $contacto->leido) {
            $contacto->update(['leido' => true]);
        }

        return inertia('Admin/Mensajes/Show', compact('contacto'));
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
