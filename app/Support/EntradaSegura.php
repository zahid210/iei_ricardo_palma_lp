<?php

namespace App\Support;

/**
 * Saneamiento de las cabeceras HTTP de entrada, ANTES de que PHP/Laravel
 * construyan la Request.
 *
 * CVE-2026-108082 (symfony/http-foundation < 8.1.7): HeaderUtils::split()
 * sufre backtracking catastrófico. HeaderBag::set() parsea SIEMPRE la cabecera
 * "Cache-Control" (la vuelca en cacheControl vía parseCacheControl()), y PHP
 * crea esa HeaderBag desde $_SERVER en CADA petición. Así que una cabecera
 * Cache-Control maliciosa agota la CPU (ReDoS) a cualquier visitante anónimo.
 *
 * Esta web no usa la cabecera Cache-Control de ENTRADA, así que la descartamos.
 * El refresco manual de caché usa la cabecera propia "X-Cache-Refresh"
 * (ver App\Http\Middleware\CacheResponse).
 *
 * De paso descartamos un "Accept" que no tenga pinta de venir de un navegador:
 * también acaba en HeaderUtils::split() (AcceptHeader).
 *
 * Se llama desde bootstrap/app.php, que se carga ANTES de Request::capture()
 * en los dos front controllers. Cuando vendor/ se actualice a
 * symfony/http-foundation >= 8.1.7, esto puede retirarse (ver deploy/README.md).
 */
final class EntradaSegura
{
    /**
     * Cabeceras de entrada que jamás envía un navegador legítimo de forma
     * anómala y que, aun así, acaban en HeaderUtils::split().
     */
    private const CABECERAS_RIESGO = ['HTTP_ACCEPT'];

    /** Longitud máxima razonable para una de esas cabeceras. */
    private const LONGITUD_MAXIMA = 2048;

    public static function sanear(): void
    {
        // CVE-2026-108082: no necesitamos la cabecera Cache-Control de entrada.
        unset($_SERVER['HTTP_CACHE_CONTROL']);

        foreach (self::CABECERAS_RIESGO as $cabecera) {
            if (! isset($_SERVER[$cabecera])) {
                continue;
            }

            $valor = $_SERVER[$cabecera];

            // Un navegador nunca manda comillas ni barras invertidas en "Accept"
            // (eso es la firma del payload que dispara el backtracking).
            if (strlen($valor) > self::LONGITUD_MAXIMA || strpbrk($valor, "\"\\") !== false) {
                unset($_SERVER[$cabecera]);
            }
        }
    }
}
