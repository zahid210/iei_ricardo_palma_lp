<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Galeria extends Model
{
    protected $fillable = ['titulo', 'imagen_path'];

    protected $appends = ['url'];

    /**
     * URL pública de la imagen, contemplando rutas con 'images/', 'storage/' o archivos sueltos.
     */
    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                $path = $this->imagen_path;
                if (! $path) {
                    return asset('images/logo_color.png');
                }
                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                    return $path;
                }
                if (str_starts_with($path, 'images/') || str_starts_with($path, 'storage/')) {
                    return asset($path);
                }
                return asset('storage/' . $path);
            }
        );
    }
}
