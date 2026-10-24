<?php

namespace Tests\Feature;

use App\Services\FacebookFeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * El feed de /noticias se trae con la Graph API desde el servidor (el Page
 * Plugin oficial de Facebook dejó de cargar el timeline). Estos tests cubren
 * el mapeo, el comportamiento sin token y la caché.
 */
class FacebookFeedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        Cache::flush();

        config([
            'services.facebook.page_id' => '279471448578826',
            'services.facebook.token' => 'token-de-prueba',
            'services.facebook.version' => 'v21.0',
        ]);
    }

    public function test_mapea_las_publicaciones_de_la_api(): void
    {
        Http::fake([
            'graph.facebook.com/*' => Http::response([
                'data' => [
                    [
                        'id' => '1_2',
                        'message' => "Hola comunidad\nBienvenidos",
                        'created_time' => '2026-10-01T12:00:00+0000',
                        'permalink_url' => 'https://www.facebook.com/permalink/1',
                        'full_picture' => 'https://scontent.xx.fbcdn.net/img.jpg',
                    ],
                    // Sin texto ni imagen: se descarta.
                    ['id' => '3_4', 'created_time' => '2026-09-01T12:00:00+0000'],
                ],
            ], 200),
        ]);

        $posts = app(FacebookFeed::class)->posts(6);

        $this->assertCount(1, $posts);
        $this->assertSame("Hola comunidad\nBienvenidos", $posts[0]['message']);
        $this->assertSame('01/10/2026', $posts[0]['date']);
        $this->assertSame('https://scontent.xx.fbcdn.net/img.jpg', $posts[0]['image']);
        $this->assertSame('https://www.facebook.com/permalink/1', $posts[0]['permalink_url']);
    }

    public function test_sin_token_devuelve_vacio_y_no_llama_a_la_api(): void
    {
        Http::fake();
        config(['services.facebook.token' => '']);

        $this->assertSame([], app(FacebookFeed::class)->posts(6));
        Http::assertNothingSent();
    }

    public function test_si_la_api_falla_devuelve_vacio(): void
    {
        Http::fake([
            'graph.facebook.com/*' => Http::response(['error' => ['message' => 'nope']], 500),
        ]);

        $this->assertSame([], app(FacebookFeed::class)->posts(6));
    }

    public function test_cachea_los_resultados(): void
    {
        Http::fake([
            'graph.facebook.com/*' => Http::response([
                'data' => [
                    ['id' => '1', 'message' => 'Hola', 'created_time' => '2026-10-01T12:00:00+0000'],
                ],
            ], 200),
        ]);

        $feed = app(FacebookFeed::class);
        $feed->posts(6);
        $feed->posts(6);

        Http::assertSentCount(1);
    }

    public function test_la_pagina_de_noticias_muestra_las_publicaciones(): void
    {
        $posts = app(FacebookFeed::class)->posts(6);

        Http::fake([
            'graph.facebook.com/*' => Http::response([
                'data' => [
                    [
                        'id' => '1',
                        'message' => 'MENSAJE_UNICO_DE_PRUEBA_RICARDINO',
                        'created_time' => '2026-10-01T12:00:00+0000',
                    ],
                ],
            ], 200),
        ]);

        $posts = app(FacebookFeed::class)->posts(6);
        $this->assertNotEmpty($posts);
        $this->assertSame('MENSAJE_UNICO_DE_PRUEBA_RICARDINO', $posts[0]['message']);
    }

    public function test_la_pagina_de_noticias_muestra_aviso_si_no_hay_feed(): void
    {
        Http::fake();
        config(['services.facebook.token' => '']);

        $this->get('/noticias')
            ->assertOk()
            ->assertSee('Visitar Página');
    }
}
