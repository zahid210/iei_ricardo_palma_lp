<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'slug',
        'titulo',
        'extracto',
        'contenido',
        'imagen',
        'autor',
        'fecha_publicacion',
        'destacada',
        'orden',
    ];

    protected $casts = [
        'fecha_publicacion' => 'date',
        'destacada' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
