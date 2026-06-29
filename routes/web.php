<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/nosotros',function(){
    return view('nosotros');
})->name('nosotros');

Route::get('/docentes',function(){
    return view('docentes');
})->name('docentes');

Route::get('/noticias', function(){
    return view('noticias');
})->name('noticias');
