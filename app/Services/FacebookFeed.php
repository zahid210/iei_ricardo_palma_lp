<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/**
 * Publicaciones de la página de Facebook de la institución.
 *
 * ¿Por qué existe esto?
 * El "Page Plugin" oficial de Facebook (el iframe) dejó de cargar el timeline a
 * nivel global: muestra la cabecera de la página pero deja el área de las
 * publicaciones en blanco/cargando. Para que la sección de noticias muestre
 * SIEMPRE el feed y se mantenga actualizada sin depender del iframe de
 * Facebook, traemos las publicaciones con la Graph API desde el servidor y las
 * pintamos con nuestro propio diseño.
 *
 * Requiere un "Page Access Token" en el .env del servidor:
 *   FACEBOOK_PAGE_ID=279471448578826
 *   FACEBOOK_PAGE_TOKEN=...
 *
 * Si no hay token (o Facebook falla) devuelve [] y la vista muestra un aviso
 * con un enlace a la página; nunca se rompe.
 */
class FacebookFeed
{
    /** Minutos que se cachean las publicaciones antes de volver a pedirlas. */
    protected const CACHE_MINUTES = 15;

    /**
     * Últimas publicaciones de la página, ya normalizadas para la vista.
     *
     * @return array<int, array{id:string, message:string, image:?string, permalink_url:?string, date:?string}>
     */
    public function posts(int $limit = 6): array
    {
        $pageId = trim((string) config('services.facebook.page_id'));
        $token = trim((string) config('services.facebook.token'));

        if ($pageId === '' || $token === '') {
            return [];
        }

        $limit = max(1, min($limit, 25));
        $key = "facebook:feed:{$pageId}:{$limit}";

        $cached = Cache::get($key);
        if (is_array($cached)) {
            return $cached;
        }

        $posts = $this->fetch($pageId, $token, $limit);

        // Solo cacheamos cuando trajimos datos: si Facebook falla no "congelamos"
        // una lista vacía y el siguiente visitante reintenta enseguida.
        if ($posts !== []) {
            Cache::put($key, $posts, now()->addMinutes(self::CACHE_MINUTES));
        }

        return $posts;
    }

    /**
     * Llama a la Graph API y normaliza la respuesta.
     *
     * @return array<int, array{id:string, message:string, image:?string, permalink_url:?string, date:?string}>
     */
    protected function fetch(string $pageId, string $token, int $limit): array
    {
        $version = (string) config('services.facebook.version', 'v21.0');

        try {
            $response = Http::timeout(10)
                ->retry(2, 400)
                ->acceptJson()
                ->get("https://graph.facebook.com/{$version}/{$pageId}/posts", [
                    'fields' => 'message,created_time,permalink_url,full_picture',
                    'limit' => $limit,
                    'access_token' => $token,
                ]);
        } catch (\Throwable $e) {
            report($e);

            return [];
        }

        if (! $response->successful()) {
            return [];
        }

        $data = $response->json('data');

        if (! is_array($data)) {
            return [];
        }

        return collect($data)
            ->filter(fn ($post) => is_array($post))
            ->map(fn (array $post) => [
                'id' => (string) ($post['id'] ?? ''),
                'message' => trim((string) ($post['message'] ?? '')),
                'image' => $post['full_picture'] ?? null,
                'permalink_url' => $post['permalink_url'] ?? null,
                'date' => $this->formatDate($post['created_time'] ?? null),
            ])
            // Descartamos publicaciones sin texto ni imagen (no se pueden mostrar).
            ->filter(fn (array $post) => $post['message'] !== '' || $post['image'] !== null)
            ->values()
            ->all();
    }

    protected function formatDate(?string $iso): ?string
    {
        if (! $iso) {
            return null;
        }

        try {
            return Carbon::parse($iso)->format('d/m/Y');
        } catch (\Throwable $e) {
            return null;
        }
    }
}
