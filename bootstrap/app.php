<?php

use App\Support\EntradaSegura;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

// ---------------------------------------------------------------------------
//  Seguridad: descarta cabeceras de entrada peligrosas ANTES de construir la
//  Request (mitigación del ReDoS CVE-2026-108082 de symfony/http-foundation;
//  ver App\Support\EntradaSegura para el detalle).
// ---------------------------------------------------------------------------
EntradaSegura::sanear();

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cache.response' => \App\Http\Middleware\CacheResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
