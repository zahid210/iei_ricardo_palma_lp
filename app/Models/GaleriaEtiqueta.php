<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class GaleriaEtiqueta extends Model
{
    protected $table = 'galeria_etiquetas';

    protected $fillable = ['nombre', 'slug'];

    protected static function booted(): void
    {
        static::saving(function ($etiqueta) {
            if (empty($etiqueta->slug) && ! empty($etiqueta->nombre)) {
                $etiqueta->slug = Str::slug($etiqueta->nombre);
            }
        });
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(Galeria::class, 'etiqueta_id');
    }
}
