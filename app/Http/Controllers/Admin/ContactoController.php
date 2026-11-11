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
            $query->where('archivado', false)->where('leido', false);
        } elseif ($filtro === 'leidos') {
            $query->where('archivado', false)->where('leido', true);
        } elseif ($filtro === 'archivados') {
            $query->where('archivado', true);
        } else {
            // 'todos': muestra todos los mensajes activos (no archivados)
            $query->where('archivado', false);
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

        $totalCount = Contact::where('archivado', false)->count();
        $noLeidos = Contact::where('archivado', false)->where('leido', false)->count();
        $leidos = Contact::where('archivado', false)->where('leido', true)->count();
        $archivados = Contact::where('archivado', true)->count();

        return inertia('Admin/Mensajes/Index', [
            'mensajes' => $mensajes,
            'noLeidos' => $noLeidos,
            'leidos' => $leidos,
            'archivados' => $archivados,
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
        if ($contacto->archivado) {
            return back()->with('error', 'No se puede cambiar el estado de lectura de un mensaje archivado. Debe desarchivarlo primero.');
        }

        $contacto->update([
            'leido' => ! $contacto->leido,
        ]);

        $estado = $contacto->leido ? 'marcado como leído' : 'marcado como no leído';

        return back()->with('success', "Mensaje de {$contacto->nombre} {$estado}.");
    }

    public function toggleArchivado(Contact $contacto)
    {
        $contacto->update([
            'archivado' => ! $contacto->archivado,
        ]);

        $estado = $contacto->archivado ? 'archivado' : 'desarchivado y devuelto a la bandeja';

        return back()->with('success', "Mensaje de {$contacto->nombre} {$estado}.");
    }

    public function destroy(Contact $contacto)
    {
        // Solo permitir eliminar si está archivado
        if (! $contacto->archivado) {
            return back()->with('error', 'Solo se pueden eliminar mensajes que estén en la sección de archivados.');
        }

        $nombre = $contacto->nombre;
        $contacto->delete();

        return back()->with('success', "Mensaje archivado de {$nombre} eliminado permanentemente.");
    }
}
