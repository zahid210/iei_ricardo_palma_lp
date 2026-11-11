<?php

namespace Database\Seeders;

use App\Models\Galeria;
use Illuminate\Database\Seeder;

class GaleriaSeeder extends Seeder
{
    public function run(): void
    {
        $deportes = \App\Models\GaleriaEtiqueta::firstOrCreate(['nombre' => 'Deportes'], ['slug' => 'deportes']);
        $eventos = \App\Models\GaleriaEtiqueta::firstOrCreate(['nombre' => 'Eventos'], ['slug' => 'eventos']);
        $academico = \App\Models\GaleriaEtiqueta::firstOrCreate(['nombre' => 'Académico'], ['slug' => 'academico']);

        if (Galeria::count() === 0) {
            Galeria::create([
                'titulo' => 'Reconocimiento escolar a estudiante',
                'leyenda' => 'Ceremonia de distinción al mérito académico y esfuerzo estudiantil.',
                'etiqueta_id' => $academico->id,
                'imagen_path' => 'images/galeria_1.jpg',
            ]);
            Galeria::create([
                'titulo' => 'Equipo femenino campeón de futsal',
                'leyenda' => 'Nuestras estudiantes consiguieron el primer lugar en los juegos deportivos escolares.',
                'etiqueta_id' => $deportes->id,
                'imagen_path' => 'images/galeria_2.jpg',
            ]);
            Galeria::create([
                'titulo' => 'Equipo masculino campeón de futsal',
                'leyenda' => 'Gran participación de nuestros alumnos en el torneo intercolegial.',
                'etiqueta_id' => $deportes->id,
                'imagen_path' => 'images/galeria_3.jpg',
            ]);
        }
    }
}
