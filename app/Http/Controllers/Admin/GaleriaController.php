<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriaRequest;
use App\Models\Galeria;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriaController extends Controller
{
    public function index()
    {
        // Migración defensiva: Si existen fotos guardadas previamente con images/galeria_upload_,
        // copiamos su archivo a Storage público y normalizamos la ruta a storage/
        $legacyUploads = Galeria::where('imagen_path', 'like', 'images/galeria_upload_%')->get();
        foreach ($legacyUploads as $foto) {
            $fileName = basename($foto->imagen_path);
            $localPhysical = public_path($foto->imagen_path);
            if (File::exists($localPhysical) && !Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->put($fileName, File::get($localPhysical));
            }
            $foto->update(['imagen_path' => 'storage/' . $fileName]);
        }

        $fotos = Galeria::orderByDesc('id')->get();
        return inertia('Admin/Galeria/Index', compact('fotos'));
    }

    public function store(StoreGaleriaRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('imagen_file');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $fileName = 'galeria_upload_' . time() . '_' . Str::random(8) . '.' . $extension;

        // 1. Almacenar en disco 'public' (storage/app/public)
        Storage::disk('public')->putFileAs('', $file, $fileName);
        $path = 'storage/' . $fileName;

        // 2. Espejo defensivo directo en docroot público (/public_html/storage y /public/storage)
        $fullSource = Storage::disk('public')->path($fileName);
        $targetDirs = [
            base_path('../public_html/storage'),
            isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/storage' : null,
            public_path('storage'),
        ];
        foreach ($targetDirs as $targetDir) {
            if ($targetDir) {
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                if (is_dir($targetDir) && is_writable($targetDir)) {
                    @copy($fullSource, $targetDir . '/' . $fileName);
                }
            }
        }

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
        if ($galeria->imagen_path) {
            $fileName = basename($galeria->imagen_path);
            $cleanStoragePath = str_replace('storage/', '', $galeria->imagen_path);

            if (Storage::disk('public')->exists($cleanStoragePath)) {
                Storage::disk('public')->delete($cleanStoragePath);
            }

            // Limpieza en carpetas espejo
            $targetDirs = [
                base_path('../public_html/storage'),
                isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/storage' : null,
                public_path('storage'),
            ];
            foreach ($targetDirs as $targetDir) {
                if ($targetDir && file_exists($targetDir . '/' . $fileName)) {
                    @unlink($targetDir . '/' . $fileName);
                }
            }

            if (str_starts_with($galeria->imagen_path, 'images/galeria_upload_')) {
                $fullPath = public_path($galeria->imagen_path);
                if (File::exists($fullPath)) {
                    File::delete($fullPath);
                }
            }
        }

        $galeria->delete();

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía eliminada correctamente.');
    }
}
