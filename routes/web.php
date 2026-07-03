<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/docentes', function () {
    return view('docentes');
})->name('docentes');

Route::get('/noticias', function () {
    return view('noticias');
})->name('noticias');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::get('/galeria', function (){
    return view('galeria');
})->name('galeria');

Route::post('/contacto', [ContactController::class, 'store'])->name('contacto.store');
