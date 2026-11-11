<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriaEtiqueta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GaleriaEtiquetaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:60', 'unique:galeria_etiquetas,nombre'],
        ], [
            'nombre.required' => 'El nombre de la etiqueta es obligatorio.',
            'nombre.unique' => 'Ya existe una etiqueta con este nombre.',
            'nombre.max' => 'El nombre de la etiqueta no debe exceder los 60 caracteres.',
        ]);

        GaleriaEtiqueta::create([
            'nombre' => trim($validated['nombre']),
            'slug' => Str::slug($validated['nombre']),
        ]);

        Cache::forget('galeria:todas');
        Cache::forget('galeria:etiquetas');
        Cache::put('app:content_version', time());

        return back()->with('success', "Etiqueta '{$validated['nombre']}' creada con éxito.");
    }

    public function destroy(GaleriaEtiqueta $etiqueta)
    {
        $nombre = $etiqueta->nombre;
        // Al eliminar la etiqueta, las fotos asociadas pasan a tener etiqueta_id = null (onDelete null)
        $etiqueta->delete();

        Cache::forget('galeria:todas');
        Cache::forget('galeria:etiquetas');
        Cache::put('app:content_version', time());

        return back()->with('success', "Etiqueta '{$nombre}' eliminada.");
    }
}
