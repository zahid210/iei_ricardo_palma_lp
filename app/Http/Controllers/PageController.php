<?php

namespace App\Http\Controllers;
use App\Models\Galeria;

class PageController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function nosotros()
    {
        return view('nosotros');
    }

    public function docentes()
    {
        return view('docentes');
    }

    public function noticias()
    {
        return view('noticias');
    }

    public function contacto()
    {
        return view('contacto');
    }

    public function galeria()
    {
        $imagenes = Galeria::latest()->paginate(4);
        return view('galeria', compact('imagenes'));
    }
}
