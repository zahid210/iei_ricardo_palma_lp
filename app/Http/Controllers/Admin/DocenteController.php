<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DocenteController extends Controller
{
    public function index()
    {
        return view('admin.docentes.index');
    }
}
