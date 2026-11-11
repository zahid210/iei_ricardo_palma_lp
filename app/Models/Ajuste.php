<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ajuste extends Model
{
    protected $table = 'ajustes';

    protected $fillable = [
        'telefono',
        'whatsapp',
        'email',
        'horario_atencion',
        'direccion',
        'google_maps_url',
        'facebook_url',
        'youtube_url',
    ];

    /**
     * Obtener los datos institucionales cacheados como array para compatibilidad
     * con cache no serializable (Laravel 13).
     *
     * @return array<string, mixed>
     */
    public static function obtener(): array
    {
        $cached = Cache::rememberForever('ajustes_institucionales', function () {
            $modelo = self::firstOrCreate(
                ['id' => 1],
                [
                    'telefono' => '+51 921 896 330',
                    'whatsapp' => '51921896330',
                    'email' => 'contacto@rpalma.edu.pe',
                    'horario_atencion' => 'Lunes a Viernes: 8:00 a.m. a 1:00 p.m.',
                    'direccion' => 'Barrio La Esperanza s/n, Chaupimarca — Cerro de Pasco, Región Pasco, Perú.',
                    'google_maps_url' => 'https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9',
                    'facebook_url' => 'https://www.facebook.com/ricardinosemprendeores',
                    'youtube_url' => 'https://www.youtube.com/@ricardopalma4155',
                ]
            );

            return $modelo->toArray();
        });

        return is_array($cached) ? $cached : (array) $cached;
    }

    /**
     * Limpiar caché al actualizar
     */
    public static function limpiarCache(): void
    {
        Cache::forget('ajustes_institucionales');
    }
}
