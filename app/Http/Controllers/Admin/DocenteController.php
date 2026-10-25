<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::orderBy('nivel')
            ->orderBy('orden')
            ->orderBy('nombres_apellidos')
            ->get();

        $porNivel = [
            'Inicial' => $docentes->where('nivel', 'Inicial')->values(),
            'Primaria' => $docentes->where('nivel', 'Primaria')->values(),
            'Secundaria' => $docentes->where('nivel', 'Secundaria')->values(),
        ];

        return inertia('Admin/Docentes/Index', compact('docentes', 'porNivel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nivel' => ['required', 'string', 'in:Inicial,Primaria,Secundaria'],
            'nombres_apellidos' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20'],
            'orden' => ['nullable', 'integer'],
        ]);

        Docente::create([
            'nivel' => $validated['nivel'],
            'nombres_apellidos' => $validated['nombres_apellidos'],
            'cargo' => $validated['cargo'],
            'dni' => $validated['dni'] ?? null,
            'orden' => $validated['orden'] ?? 0,
            'activo' => true,
        ]);

        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Docente agregado correctamente.');
    }

    public function update(Request $request, Docente $docente)
    {
        $validated = $request->validate([
            'nivel' => ['required', 'string', 'in:Inicial,Primaria,Secundaria'],
            'nombres_apellidos' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20'],
            'orden' => ['nullable', 'integer'],
        ]);

        $docente->update([
            'nivel' => $validated['nivel'],
            'nombres_apellidos' => $validated['nombres_apellidos'],
            'cargo' => $validated['cargo'],
            'dni' => $validated['dni'] ?? null,
            'orden' => $validated['orden'] ?? 0,
        ]);

        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Información del docente actualizada.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Docente eliminado correctamente.');
    }
}
