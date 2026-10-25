<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GaleriaController extends Controller
{
    public function index()
    {
        $fotos = Galeria::orderByDesc('id')->get();
        return view('admin.galeria.index', compact('fotos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'imagen_file' => ['required', 'image', 'max:5120'],
        ]);

        $file = $request->file('imagen_file');
        $fileName = 'galeria_' . time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $fileName);
        $path = 'images/' . $fileName;

        Galeria::create([
            'titulo' => $validated['titulo'],
            'imagen_path' => $path,
        ]);

        Cache::forget('galeria_items');

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía agregada a la galería.');
    }

    public function destroy(Galeria $galerium)
    {
        $galerium->delete();
        Cache::forget('galeria_items');
        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía eliminada correctamente.');
    }
}
