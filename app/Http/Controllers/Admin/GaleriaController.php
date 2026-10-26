<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriaRequest;
use App\Models\Galeria;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GaleriaController extends Controller
{
    public function index()
    {
        $fotos = Galeria::orderByDesc('id')->get();
        return inertia('Admin/Galeria/Index', compact('fotos'));
    }

    public function store(StoreGaleriaRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('imagen_file');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $fileName = 'galeria_upload_' . time() . '_' . Str::random(8) . '.' . $extension;
        $file->move(public_path('images'), $fileName);
        $path = 'images/' . $fileName;

        Galeria::create([
            'titulo' => $validated['titulo'],
            'imagen_path' => $path,
        ]);

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía publicada en la galería.');
    }

    public function destroy(Galeria $galeria)
    {
        // Limpieza de archivo físico solo si es una imagen subida por el panel administrativo
        if ($galeria->imagen_path && str_starts_with($galeria->imagen_path, 'images/galeria_upload_')) {
            $fullPath = public_path($galeria->imagen_path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $galeria->delete();

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía eliminada correctamente.');
    }
}
