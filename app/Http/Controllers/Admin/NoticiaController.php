<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNoticiaRequest;
use App\Http\Requests\Admin\UpdateNoticiaRequest;
use App\Models\Noticia;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class NoticiaController extends Controller
{
    public function index()
    {
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
            $file->move(public_path('images'), $fileName);
            $imagenPath = 'images/' . $fileName;
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
            $file->move(public_path('images'), $fileName);
            $newPath = 'images/' . $fileName;

            // Limpieza del archivo anterior si era una imagen subida por el gestor de noticias
            if ($noticia->imagen && str_starts_with($noticia->imagen, 'images/noticia_upload_')) {
                $oldFile = public_path($noticia->imagen);
                if (File::exists($oldFile)) {
                    File::delete($oldFile);
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
        if ($noticia->imagen && str_starts_with($noticia->imagen, 'images/noticia_upload_')) {
            $file = public_path($noticia->imagen);
            if (File::exists($file)) {
                File::delete($file);
            }
        }

        $noticia->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
