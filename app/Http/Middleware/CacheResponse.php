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
 * "versión" del despliegue, que deploy/deploy.sh escribe en deploy-version.txt (en
 * la raíz de la app) con el SHA del commit y sube SIEMPRE. Así, tras cada push, las
 * páginas se vuelven a generar una vez y luego se sirven desde caché.
 *
 * OJO: NO usamos filemtime(public_path('index.php')). En este hosting partido
 * public_path() = /ricardo_palma_core/public, que NO es el document root
 * (/public_html), así que ese archivo no existe y su filemtime era siempre 0
 * (la caché nunca se invalidaba). El marcador con el SHA no depende de las rutas.
 *
 * Al navegador se le pide que revalide siempre (max-age=0, must-revalidate), de
 * modo que los cambios de contenido se ven al instante sin perder velocidad: el
 * trabajo pesado (BD + Blade) lo evita la caché del servidor, no la del navegador.
 */
class CacheResponse
{
    public function handle(Request $request, Closure $next, int $ttl = 3600): Response
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if (! $this->shouldCache($request)) {
            return $next($request);
        }

        $key = $this->cacheKey($request);

        // Permite forzar refresco enviando la cabecera propia "X-Cache-Refresh: 1".
        // (No usamos Cache-Control: la descartamos en bootstrap/app.php como
        //  mitigación de la ReDoS CVE-2026-108082.)
        if ($request->header('X-Cache-Refresh') === '1') {
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
        // La "version" la escribe deploy/deploy.sh en cada despliegue: escribe el
        // SHA del commit en deploy-version.txt (raiz de la app) y lo sube siempre.
        // Asi las respuestas cacheadas se invalidan solas tras cada push. Si el
        // archivo aun no existe (primer despliegue), version = 0 (caché igualmente
        // válida; simplemente no se invalida hasta el primer deploy con marcador).
        $version = @file_get_contents(base_path('deploy-version.txt')) ?: 0;

        return 'response:' . sha1($version . '|' . $request->fullUrl());
    }
}
