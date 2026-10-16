<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * Regresión: la página de galería usa caché.
 *
 * El driver de caché por defecto en los tests ("array") NO serializa los valores,
 * así que oculta un bug real: en producción la caché es "database", que SÍ
 * serializa, y Laravel 13 por defecto NO permite deserializar clases
 * (config/cache.php: 'serializable_classes' => false). Por eso, cachear un objeto
 * Eloquent (un Collection) hace que vuelva como __PHP_Incomplete_Class y la página
 * devuelva 500.
 *
 * Este test fuerza el driver "database" para reproducir el comportamiento real.
 */
class GaleriaCacheTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        // Fuerza un driver que serializa (como en producción).
        config(['cache.default' => 'database']);
        Cache::forget('galeria:todas');
    }

    public function test_galeria_page_works_across_a_real_cache_round_trip(): void
    {
        // 1er acceso: rellena la caché. 2º acceso: la lee.
        // Con el bug (objeto cacheado) el 2º devolvía 500.
        $this->get('/galeria')->assertOk();
        $this->get('/galeria')->assertOk();
    }
}
