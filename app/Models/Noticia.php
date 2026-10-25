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
        'orden' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Resuelve enlace de ruta tanto por slug como por ID numérico
     * para garantizar compatibilidad con rutas públicas (/noticias/{slug}) y de administración (/admin/noticias/{id}).
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field) {
            return $this->where($field, $value)->first();
        }

        if (is_numeric($value)) {
            $byNumericId = $this->where('id', $value)->first();
            if ($byNumericId) {
                return $byNumericId;
            }
        }

        return $this->where('slug', $value)->orWhere('id', $value)->first();
    }
}
