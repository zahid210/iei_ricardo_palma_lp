<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Galeria;
use App\Models\GaleriaEtiqueta;
use App\Models\Noticia;
use App\Services\FacebookFeed;
use Database\Seeders\DocenteSeeder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        $noticias = Noticia::orderBy('orden')
            ->orderByDesc('fecha_publicacion')
            ->take(3)
            ->get();

        $galeria = Galeria::latest()->get();
        $docentesCount = Docente::where('activo', true)->count();

        return inertia('Home', [
            'noticias' => $noticias,
            'galeria' => $galeria,
            'docentesCount' => $docentesCount,
        ]);
    }

    public function nosotros()
    {
        return inertia('Nosotros');
    }

    public function docentes()
    {
        // Guardamos arrays simples en la caché para evitar que serialize()/unserialize()
        // devuelvan una __PHP_Incomplete_Class (política de seguridad de Laravel 13).
        $datos = Cache::get('docentes:todos');

        if (! is_array($datos)) {
            // Si la tabla estuviera vacía en el servidor, autoseed desde el json
            if (Docente::count() === 0 && file_exists(database_path('data/docentes.json'))) {
                (new DocenteSeeder)->run();
            }

            $datos = Docente::where('activo', true)
                ->orderBy('orden')
                ->orderBy('nombres_apellidos')
                ->get()
                ->toArray();
            Cache::put('docentes:todos', $datos, now()->addHours(12));
        }

        $docentes = Docente::hydrate($datos);

        $porNivel = [
            'Inicial' => $docentes->where('nivel', 'Inicial')->values(),
            'Primaria' => $docentes->where('nivel', 'Primaria')->values(),
            'Secundaria' => $docentes->where('nivel', 'Secundaria')->values(),
        ];

        return inertia('Docentes', compact('porNivel'));
    }

    public function noticias(FacebookFeed $facebook)
    {
        $noticias = Noticia::orderBy('orden')->orderByDesc('fecha_publicacion')->get();

        $destacada = $noticias->firstWhere('destacada', true) ?? $noticias->first();
        $secundarias = $noticias->where('id', '!==', $destacada?->id)->take(4);
        $otrasNoticias = $noticias->where('id', '!==', $destacada?->id)->skip(4);

        return inertia('Noticias', [
            'destacada' => $destacada,
            'secundarias' => $secundarias->values(),
            'otrasNoticias' => $otrasNoticias->values(),
            'facebookPosts' => $facebook->posts(6),
        ]);
    }

    public function noticiaDetalle(string $slug)
    {
        $noticia = Noticia::where('slug', $slug)->firstOrFail();

        $anterior = Noticia::where('id', '<', $noticia->id)
            ->orderByDesc('id')
            ->first();

        $relacionadas = Noticia::where('id', '!=', $noticia->id)
            ->orderByDesc('fecha_publicacion')
            ->take(3)
            ->get();

        return inertia('NoticiaDetalle', [
            'noticia' => $noticia,
            'anterior' => $anterior,
            'relacionadas' => $relacionadas,
        ]);
    }

    public function contacto()
    {
        return inertia('Contacto');
    }

    public function galeria()
    {
        $etiquetaFiltro = request()->query('etiqueta');

        // Cacheamos DATOS (arrays simples) con relación a etiqueta
        $datos = Cache::get('galeria:todas');

        if (! is_array($datos)) {
            $datos = Galeria::with('etiqueta')->orderByDesc('id')->get()->toArray();
            Cache::put('galeria:todas', $datos, now()->addHours(12));
        }

        // Etiquetas para los filtros
        $etiquetas = Cache::remember('galeria:etiquetas', now()->addHours(12), function () {
            return GaleriaEtiqueta::has('fotos')->orderBy('nombre')->get()->toArray();
        });

        // Reconstruimos los modelos en memoria
        $todas = Galeria::hydrate($datos);

        // Cargar relación 'etiqueta' desde los datos hydrate
        foreach ($todas as $idx => $modelo) {
            if (isset($datos[$idx]['etiqueta']) && $datos[$idx]['etiqueta']) {
                $modelo->setRelation('etiqueta', new GaleriaEtiqueta($datos[$idx]['etiqueta']));
            }
        }

        // Filtrado por etiqueta si se solicitó
        if ($etiquetaFiltro) {
            $todas = $todas->filter(function ($item) use ($etiquetaFiltro) {
                return $item->etiqueta && $item->etiqueta->slug === $etiquetaFiltro;
            })->values();
        }

        // Paginamos en memoria (12 por página, armónico en 1, 2, 3 y 4 columnas).
        $perPage = 12;
        $page = Paginator::resolveCurrentPage();

        $imagenes = new LengthAwarePaginator(
            $todas->forPage($page, $perPage)->values(),
            $todas->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath(), 'query' => request()->query()]
        );

        return inertia('Galeria', [
            'imagenes' => $imagenes,
            'etiquetas' => $etiquetas,
            'etiquetaActual' => $etiquetaFiltro,
        ]);
    }
}
