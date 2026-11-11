<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGaleriaRequest;
use App\Http\Requests\Admin\UpdateGaleriaRequest;
use App\Models\Galeria;
use App\Models\GaleriaEtiqueta;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriaController extends Controller
{
    public function index()
    {
        // Migración defensiva si hay archivos antiguos
        $legacyUploads = Galeria::where('imagen_path', 'like', 'images/galeria_upload_%')->get();
        foreach ($legacyUploads as $foto) {
            $fileName = basename($foto->imagen_path);
            $localPhysical = public_path($foto->imagen_path);
            if (File::exists($localPhysical) && ! Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->put($fileName, File::get($localPhysical));
            }
            $foto->update(['imagen_path' => 'storage/'.$fileName]);
        }

        $fotos = Galeria::with('etiqueta')->orderByDesc('id')->get();
        $etiquetas = GaleriaEtiqueta::withCount('fotos')->orderBy('nombre')->get();

        return inertia('Admin/Galeria/Index', compact('fotos', 'etiquetas'));
    }

    public function store(StoreGaleriaRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('imagen_file');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
        $fileName = 'galeria_upload_'.time().'_'.Str::random(8).'.'.$extension;

        // 1. Almacenar en disco 'public' (storage/app/public)
        Storage::disk('public')->putFileAs('', $file, $fileName);
        $path = 'storage/'.$fileName;

        // 2. Espejo defensivo directo en docroot público
        $fullSource = Storage::disk('public')->path($fileName);
        $targetDirs = [
            base_path('../public_html/storage'),
            isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].'/storage' : null,
            public_path('storage'),
        ];
        foreach ($targetDirs as $targetDir) {
            if ($targetDir) {
                if (! is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                if (is_dir($targetDir) && is_writable($targetDir)) {
                    @copy($fullSource, $targetDir.'/'.$fileName);
                }
            }
        }

        Galeria::create([
            'titulo' => $validated['titulo'],
            'etiqueta_id' => $validated['etiqueta_id'] ?? null,
            'imagen_path' => $path,
        ]);

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');
        Cache::put('app:content_version', time());

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía publicada en la galería.');
    }

    public function update(UpdateGaleriaRequest $request, Galeria $galeria)
    {
        $validated = $request->validated();

        $dataToUpdate = [
            'titulo' => $validated['titulo'],
            'etiqueta_id' => $validated['etiqueta_id'] ?? null,
        ];

        // Si se subió un nuevo archivo para reemplazar
        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
            $fileName = 'galeria_upload_'.time().'_'.Str::random(8).'.'.$extension;

            Storage::disk('public')->putFileAs('', $file, $fileName);
            $newPath = 'storage/'.$fileName;

            // Espejo en docroot
            $fullSource = Storage::disk('public')->path($fileName);
            $targetDirs = [
                base_path('../public_html/storage'),
                isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].'/storage' : null,
                public_path('storage'),
            ];
            foreach ($targetDirs as $targetDir) {
                if ($targetDir) {
                    if (! is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    if (is_dir($targetDir) && is_writable($targetDir)) {
                        @copy($fullSource, $targetDir.'/'.$fileName);
                    }
                }
            }

            // Eliminar imagen anterior si era un upload
            $this->borrarArchivoFisico($galeria->imagen_path);

            $dataToUpdate['imagen_path'] = $newPath;
        }

        $galeria->update($dataToUpdate);

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');
        Cache::put('app:content_version', time());

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía actualizada correctamente.');
    }

    public function destroy(Galeria $galeria)
    {
        $this->borrarArchivoFisico($galeria->imagen_path);
        $galeria->delete();

        Cache::forget('galeria:todas');
        Cache::forget('galeria_items');
        Cache::put('app:content_version', time());

        return redirect()->route('admin.galeria.index')->with('success', 'Fotografía retirada de la galería.');
    }

    protected function borrarArchivoFisico(?string $path): void
    {
        if (! $path) {
            return;
        }

        $isUploadedFile = str_contains(basename($path), 'galeria_upload_');
        if (! $isUploadedFile) {
            return;
        }

        $fileName = basename($path);
        $cleanStoragePath = str_replace('storage/', '', $path);

        if (Storage::disk('public')->exists($cleanStoragePath)) {
            Storage::disk('public')->delete($cleanStoragePath);
        }

        $targetDirs = [
            base_path('../public_html/storage'),
            isset($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'].'/storage' : null,
            public_path('storage'),
        ];
        foreach ($targetDirs as $targetDir) {
            if ($targetDir && file_exists($targetDir.'/'.$fileName)) {
                @unlink($targetDir.'/'.$fileName);
            }
        }
    }
}
