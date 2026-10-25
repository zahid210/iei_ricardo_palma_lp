<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDocenteRequest;
use App\Http\Requests\Admin\UpdateDocenteRequest;
use App\Models\Docente;
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

    public function store(StoreDocenteRequest $request)
    {
        $validated = $request->validated();

        Docente::create([
            'nivel' => $validated['nivel'],
            'nombres_apellidos' => $validated['nombres_apellidos'],
            'cargo' => $validated['cargo'],
            'dni' => $validated['dni'] ?? null,
            'orden' => $validated['orden'] ?? 0,
            'activo' => true,
        ]);

        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Profesor registrado con éxito.');
    }

    public function update(UpdateDocenteRequest $request, Docente $docente)
    {
        $validated = $request->validated();

        $docente->update([
            'nivel' => $validated['nivel'],
            'nombres_apellidos' => $validated['nombres_apellidos'],
            'cargo' => $validated['cargo'],
            'dni' => $validated['dni'] ?? null,
            'orden' => $validated['orden'] ?? 0,
        ]);

        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Datos del profesor actualizados.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();
        Cache::forget('docentes:todos');

        return redirect()->route('admin.docentes.index')->with('success', 'Profesor retirado de la lista.');
    }
}
