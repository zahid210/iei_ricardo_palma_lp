<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/nosotros', [PageController::class, 'nosotros'])->name('nosotros');
Route::get('/docentes', [PageController::class, 'docentes'])->name('docentes');
Route::get('/noticias', [PageController::class, 'noticias'])->name('noticias');
Route::get('/contacto', [PageController::class, 'contacto'])->name('contacto');
Route::get('/galeria', [PageController::class, 'galeria'])->name('galeria');

Route::post('/contacto', [ContactController::class, 'store'])
    ->name('contacto.store');
