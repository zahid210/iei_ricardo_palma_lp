<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cachea la respuesta HTML completa de páginas públicas de solo lectura.
 *
 * Se aplica SOLO a rutas sin formularios ni datos de sesión (nunca a /contacto,
 * que contiene el token CSRF). Añade la cabecera X-Cache (HIT/MISS) para depurar.
 *
 * La caché del servidor se invalida SOLA en cada despliegue: la clave incluye la
 * fecha de modificación de public/index.php, y el despliegue (deploy/deploy.sh)
 * siempre vuelve a subir ese archivo. Así, tras cada push, las páginas se vuelven
 * a generar una vez y luego se sirven desde caché.
 *
 * Al navegador se le pide que revalide siempre (max-age=0, must-revalidate), de
 * modo que los cambios de contenido se ven al instante sin perder velocidad: el
 * trabajo pesado (BD + Blade) lo evita la caché del servidor, no la del navegador.
 */
class CacheResponse
{
    public function handle(Request $request, Closure $next, int $ttl = 3600): Response
    {
        if (! $this->shouldCache($request)) {
            return $next($request);
        }

        $key = $this->cacheKey($request);

        // Permite forzar refresco enviando Cache-Control: no-cache desde el cliente.
        if ($request->header('Cache-Control') === 'no-cache') {
            Cache::forget($key);
        }

        if (Cache::has($key)) {
            return response(Cache::get($key))
                ->header('Content-Type', 'text/html; charset=UTF-8')
                ->header('X-Cache', 'HIT')
                ->header('Cache-Control', 'public, max-age=0, must-revalidate');
        }

        $response = $next($request);

        if (
            $response->getStatusCode() === 200
            && is_string($response->getContent())
            && $response->getContent() !== ''
        ) {
            Cache::put($key, $response->getContent(), $ttl);
        }

        return $response
            ->header('X-Cache', 'MISS')
            ->header('Cache-Control', 'public, max-age=0, must-revalidate');
    }

    /**
     * Solo cacheamos GET/HEAD anónimos y sin mensajes flash ni errores de validación.
     */
    protected function shouldCache(Request $request): bool
    {
        if (! $request->isMethod('GET') && ! $request->isMethod('HEAD')) {
            return false;
        }

        if ($request->ajax() || $request->is('contacto*')) {
            return false;
        }

        if (auth()->check()) {
            return false;
        }

        $session = $request->session();

        if ($session->has('success') || $session->has('error')) {
            return false;
        }

        $errors = $session->get('errors');

        if ($errors && method_exists($errors, 'any') && $errors->any()) {
            return false;
        }

        return true;
    }

    protected function cacheKey(Request $request): string
    {
        // La "version" cambia en cada despliegue: deploy/deploy.sh siempre vuelve
        // a subir public_html/index.php y FTP actualiza su fecha de modificacion,
        // asi que las respuestas cacheadas se invalidan solas tras cada push.
        $version = @filemtime(public_path('index.php')) ?: 0;

        return 'response:' . sha1($version . '|' . $request->fullUrl());
    }
}
