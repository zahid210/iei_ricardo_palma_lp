<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = [
        'nivel',
        'nombres_apellidos',
        'cargo',
        'dni',
        'foto',
        'orden',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    /**
     * URL o ruta de imagen para el docente.
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->foto) {
                    if (str_starts_with($this->foto, 'http://') || str_starts_with($this->foto, 'https://')) {
                        return $this->foto;
                    }
                    if (str_starts_with($this->foto, '/')) {
                        return $this->foto;
                    }
                    return '/' . $this->foto;
                }
                return null;
            }
        );
    }
}
