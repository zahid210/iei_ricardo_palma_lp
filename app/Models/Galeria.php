<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    protected $fillable = ['titulo', 'imagen_path'];

    protected $appends = ['url'];

    /**
     * URL pública de la imagen (ruta raíz relativa o URL externa)
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $path = $this->imagen_path;
                if (! $path) {
                    return '/images/logo_color.png';
                }
                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    return $path;
                }
                if (str_starts_with($path, '/')) {
                    return $path;
                }
                // Si proviene de una subida previa con ruta images/galeria_upload_, redirigir a /storage/
                if (str_starts_with($path, 'images/galeria_upload_')) {
                    return '/storage/' . basename($path);
                }
                if (str_starts_with($path, 'images/') || str_starts_with($path, 'storage/')) {
                    return '/' . $path;
                }
                return '/storage/' . $path;
            }
        );
    }
}
