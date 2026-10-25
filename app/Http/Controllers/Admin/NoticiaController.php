<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'extracto' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'imagen_file' => ['nullable', 'image', 'max:5120'],
            'autor' => ['nullable', 'string', 'max:120'],
            'fecha_publicacion' => ['required', 'date'],
            'destacada' => ['nullable', 'boolean'],
            'orden' => ['nullable', 'integer'],
        ]);

        $slug = Str::slug($validated['titulo']);
        $originalSlug = $slug;
        $counter = 1;
        while (Noticia::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        $imagenPath = 'images/galeria_1.jpg';
        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $fileName = 'noticia_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $imagenPath = 'images/' . $fileName;
        }

        Noticia::create([
            'slug' => $slug,
            'titulo' => $validated['titulo'],
            'extracto' => $validated['extracto'],
            'contenido' => $validated['contenido'],
            'imagen' => $imagenPath,
            'autor' => $validated['autor'] ?? 'Comisión de Comunicaciones',
            'fecha_publicacion' => $validated['fecha_publicacion'],
            'destacada' => $request->boolean('destacada'),
            'orden' => $validated['orden'] ?? 0,
        ]);

        return redirect()->route('admin.noticias.index')->with('success', 'Noticia creada con éxito.');
    }

    public function edit(Noticia $noticia)
    {
        return inertia('Admin/Noticias/Edit', compact('noticia'));
    }

    public function update(Request $request, Noticia $noticia)
    {
        $validated = $request->validate([
            'titulo' => ['required', 'string', 'max:255'],
            'extracto' => ['required', 'string'],
            'contenido' => ['required', 'string'],
            'imagen_file' => ['nullable', 'image', 'max:5120'],
            'autor' => ['nullable', 'string', 'max:120'],
            'fecha_publicacion' => ['required', 'date'],
            'destacada' => ['nullable', 'boolean'],
            'orden' => ['nullable', 'integer'],
        ]);

        $imagenPath = $noticia->imagen;
        if ($request->hasFile('imagen_file')) {
            $file = $request->file('imagen_file');
            $fileName = 'noticia_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $imagenPath = 'images/' . $fileName;
        }

        $noticia->update([
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
        $noticia->delete();
        return redirect()->route('admin.noticias.index')->with('success', 'Noticia eliminada correctamente.');
    }
}
