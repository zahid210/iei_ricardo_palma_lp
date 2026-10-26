<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNoticiaRequest;
use App\Http\Requests\Admin\UpdateNoticiaRequest;
use App\Models\Noticia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
    private function mirrorToDocroot(string $fileName): void
    {
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
    }

    private function removeFromDocroot(string $fileName): void
    {
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
    }

    public function index()
    {
        // Migración defensiva: Si existen noticias guardadas previamente con images/noticia_upload_,
        // copiamos su archivo a Storage público y normalizamos la ruta a storage/
        $legacyUploads = Noticia::where('imagen', 'like', 'images/noticia_upload_%')->get();
        foreach ($legacyUploads as $noticia) {
            $fileName = basename($noticia->imagen);
            $localPhysical = public_path($noticia->imagen);
            if (File::exists($localPhysical) && !Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->put($fileName, File::get($localPhysical));
            }
            $this->mirrorToDocroot($fileName);
            $noticia->update(['imagen' => 'storage/' . $fileName]);
        }

        $noticias = Noticia::orderBy('orden')->orderByDesc('fecha_publicacion')->get();
        return inertia('Admin/Noticias/Index', compact('noticias'));
    }

    public function create()
    {
        return inertia('Admin/Noticias/Create');
    }

    public function store(StoreNoticiaRequest $request)
    {
        $validated = $request->validated();

        $slug = Str::slug($validated['titulo']);
        $originalSlug = $slug;
        $counter = 1;
        while (Noticia::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagenPath = 'images/fachada_colegio.jpg';
        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
            $fileName = 'noticia_upload_' . time() . '_' . Str::random(8) . '.' . $extension;

            // Almacenar en disco 'public' (storage/app/public)
            Storage::disk('public')->putFileAs('', $file, $fileName);
            $this->mirrorToDocroot($fileName);
            $imagenPath = 'storage/' . $fileName;
        }

        Noticia::create([
            'slug' => $slug,
            'titulo' => $validated['titulo'],
            'extracto' => $validated['extracto'],
            'contenido' => $validated['contenido'],
            'imagen' => $imagenPath,
            'autor' => $validated['autor'] ?? 'Colegio Ricardo Palma',
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'destacada' => $request->boolean('destacada'),
            'orden' => $validated['orden'] ?? 0,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia publicada con éxito.');
    }

    public function edit(Noticia $noticia)
    {
        return inertia('Admin/Noticias/Edit', compact('noticia'));
    }

    public function update(UpdateNoticiaRequest $request, Noticia $noticia)
    {
        $validated = $request->validated();

        $imagenPath = $noticia->imagen;
        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $extension = strtolower($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg');
            $fileName = 'noticia_upload_' . time() . '_' . Str::random(8) . '.' . $extension;

            // Almacenar en disco 'public' y espejo en docroot
            Storage::disk('public')->putFileAs('', $file, $fileName);
            $this->mirrorToDocroot($fileName);
            $newPath = 'storage/' . $fileName;

            // Limpieza del archivo anterior
            if ($noticia->imagen) {
                $oldFileName = basename($noticia->imagen);
                $cleanOld = str_replace('storage/', '', $noticia->imagen);
                if (Storage::disk('public')->exists($cleanOld)) {
                    Storage::disk('public')->delete($cleanOld);
                }
                $this->removeFromDocroot($oldFileName);
                if (str_starts_with($noticia->imagen, 'images/noticia_upload_')) {
                    $oldFile = public_path($noticia->imagen);
                    if (File::exists($oldFile)) {
                        File::delete($oldFile);
                    }
                }
            }

            $imagenPath = $newPath;
        }

        // Mantener o regenerar slug si cambió el título
        $slug = $noticia->slug;
        if (empty($slug) || $noticia->titulo !== $validated['titulo']) {
            $candidateSlug = Str::slug($validated['titulo']);
            $originalCandidate = $candidateSlug;
            $counter = 1;
            while (Noticia::where('slug', $candidateSlug)->where('id', '!=', $noticia->id)->exists()) {
                $candidateSlug = "{$originalCandidate}-{$counter}";
                $counter++;
            }
            $slug = $candidateSlug;
        }

        $noticia->update([
            'slug' => $slug,
            'titulo' => $validated['titulo'],
            'extracto' => $validated['extracto'],
            'contenido' => $validated['contenido'],
            'imagen' => $imagenPath,
            'autor' => $validated['autor'] ?? $noticia->autor,
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'destacada' => $request->boolean('destacada'),
            'orden' => $validated['orden'] ?? 0,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy(Noticia $noticia)
    {
        if ($noticia->imagen) {
            $fileName = basename($noticia->imagen);
            $cleanStoragePath = str_replace('storage/', '', $noticia->imagen);
            if (Storage::disk('public')->exists($cleanStoragePath)) {
                Storage::disk('public')->delete($cleanStoragePath);
            }
            $this->removeFromDocroot($fileName);

            if (str_starts_with($noticia->imagen, 'images/noticia_upload_')) {
                $file = public_path($noticia->imagen);
                if (File::exists($file)) {
                    File::delete($file);
                }
            }
        }

        $noticia->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
