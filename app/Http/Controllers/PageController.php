<?php

namespace App\Http\Controllers;
use App\Models\Galeria;
use App\Services\FacebookFeed;
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

    public function noticias(FacebookFeed $facebook)
    {
        return view('noticias', [
            'facebookPosts' => $facebook->posts(6),
        ]);
    }

    public function contacto()
    {
        return view('contacto');
    }

    public function galeria()
    {
        // Cacheamos DATOS (arrays), nunca objetos Eloquent.
        //
        // Laravel 13 ya NO deserializa clases desde la cache por defecto
        // (config/cache.php: 'serializable_classes' => false, por seguridad frente
        // a "gadget chain attacks"). Un Collection cacheado vuelve como
        // __PHP_Incomplete_Class y rompe la pagina con error 500. Guardando arrays
        // simples evitamos el problema y mantenemos la caché.
        $datos = Cache::get('galeria:todas');

        // Si no hay dato o quedo un valor viejo/invalido, lo regeneramos.
        if (! is_array($datos)) {
            $datos = Galeria::latest()->get()->toArray();
            Cache::put('galeria:todas', $datos, now()->addHours(12));
        }

        // Reconstruimos los modelos en memoria (sin volver a consultar la BD).
        $todas = Galeria::hydrate($datos);

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
