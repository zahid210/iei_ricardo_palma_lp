<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

// Páginas públicas de solo lectura: se cachea la respuesta HTML completa (TTL 1 h).
Route::middleware('cache.response:3600')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
    Route::get('/docentes', [PageController::class, 'docentes'])->name('docentes');
});

// Noticias: TTL corto. La respuesta HTML lleva dentro el feed de Facebook, así
// que se regenera seguido para que las publicaciones se refresquen solas.
Route::middleware('cache.response:900')->group(function () {
    Route::get('/noticias', [PageController::class, 'noticias'])->name('noticias');
});

// Galería: se cachean los datos (no el HTML) y se invalidan con `galeria:sync`.
Route::get('/galeria', [PageController::class, 'galeria'])->name('galeria');

// Contacto: NUNCA se cachea (contiene el token CSRF y mensajes flash).
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');

Route::post('/contacto', [ContactController::class, 'store'])
    ->middleware('throttle:3,5')
    ->name('contacto.store');
