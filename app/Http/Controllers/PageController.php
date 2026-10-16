<?php

namespace App\Http\Controllers;
use App\Models\Galeria;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function nosotros()
    {
        return view('nosotros');
    }

    public function docentes()
    {
        return view('docentes');
    }

    public function noticias()
    {
        return view('noticias');
    }

    public function contacto()
    {
        return view('contacto');
    }

    public function galeria()
    {
        // Cacheamos la lista completa de imágenes (una sola consulta a BD cada 12 h).
        $todas = Cache::remember('galeria:todas', now()->addHours(12), function () {
            return Galeria::latest()->get();
        });

        // Paginamos en memoria (4 por página) para no golpear la base de datos.
        $perPage = 4;
        $page = Paginator::resolveCurrentPage();

        $imagenes = new LengthAwarePaginator(
            $todas->forPage($page, $perPage)->values(),
            $todas->count(),
            $perPage,
            $page,
            ['path' => Paginator::resolveCurrentPath(), 'query' => request()->query()]
        );

        return view('galeria', compact('imagenes'));
    }
}
