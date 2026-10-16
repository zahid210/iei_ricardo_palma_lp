<?php

namespace Tests\Feature;

use App\Support\EntradaSegura;
use Tests\TestCase;

/**
 * Regresión: saneamiento de cabeceras de entrada.
 *
 * CVE-2026-108082: HeaderUtils::split() (symfony/http-foundation < 8.1.7) sufre
 * backtracking catastrófico y HeaderBag::set() parsea SIEMPRE la cabecera
 * "Cache-Control" de la petición. Como PHP crea esa HeaderBag desde $_SERVER en
 * cada request, un visitante anónimo puede provocar un ReDoS con una cabecera
 * Cache-Control maliciosa.
 *
 * La defensa (App\Support\EntradaSegura) se ejecuta en bootstrap/app.php, antes
 * de construir la Request. Aquí comprobamos el comportamiento y, además, que el
 * arranque sigue llamándola.
 */
class EntradaSeguraTest extends TestCase
{
    /**
     * El arranque (bootstrap/app.php) debe descartar Cache-Control de entrada.
     * Si alguien quita la llamada a EntradaSegura::sanear(), este test falla.
     */
    public function test_el_arranque_descarta_la_cabecera_cache_control(): void
    {
        $_SERVER['HTTP_CACHE_CONTROL'] = 'no-cache, no-store';

        // Vuelve a cargar bootstrap/app.php (usa require, no require_once).
        $this->refreshApplication();

        $this->assertArrayNotHasKey('HTTP_CACHE_CONTROL', $_SERVER);
    }

    public function test_sanear_descarta_siempre_cache_control(): void
    {
        $this->conCabecera('HTTP_CACHE_CONTROL', 'max-age=0, private', function (): void {
            EntradaSegura::sanear();

            $this->assertArrayNotHasKey('HTTP_CACHE_CONTROL', $_SERVER);
        });
    }

    public function test_sanear_descarta_un_accept_anomalo(): void
    {
        $anomalos = [
            'comillas (firma del payload)' => 'text/html,"'.str_repeat('a', 50),
            'demasiado largo' => 'text/html,'.str_repeat('a', 5000),
        ];

        foreach ($anomalos as $descripcion => $valor) {
            $this->conCabecera('HTTP_ACCEPT', $valor, function () use ($descripcion): void {
                EntradaSegura::sanear();

                $this->assertArrayNotHasKey('HTTP_ACCEPT', $_SERVER, "Accept no descartado: {$descripcion}");
            });
        }
    }

    public function test_sanear_conserva_un_accept_normal(): void
    {
        $normal = 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';

        $this->conCabecera('HTTP_ACCEPT', $normal, function () use ($normal): void {
            EntradaSegura::sanear();

            $this->assertSame($normal, $_SERVER['HTTP_ACCEPT']);
        });
    }

    /**
     * Ejecuta $fn con $_SERVER[$nombre] fijado a $valor y restaura el original.
     */
    private function conCabecera(string $nombre, ?string $valor, callable $fn): void
    {
        $original = $_SERVER[$nombre] ?? null;

        if ($valor === null) {
            unset($_SERVER[$nombre]);
        } else {
            $_SERVER[$nombre] = $valor;
        }

        try {
            $fn();
        } finally {
            if ($original === null) {
                unset($_SERVER[$nombre]);
            } else {
                $_SERVER[$nombre] = $original;
            }
        }
    }
}
