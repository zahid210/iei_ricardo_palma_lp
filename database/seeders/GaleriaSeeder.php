<?php

namespace Database\Seeders;

use App\Models\Galeria;
use Illuminate\Database\Seeder;

class GaleriaSeeder extends Seeder
{
    public function run(): void
    {
        if (Galeria::count() === 0) {
            Galeria::create([
                'titulo' => 'Reconocimiento escolar a estudiante',
                'imagen_path' => 'images/galeria_1.jpg',
            ]);
            Galeria::create([
                'titulo' => 'Equipo femenino campeón de futsal',
                'imagen_path' => 'images/galeria_2.jpg',
            ]);
            Galeria::create([
                'titulo' => 'Equipo masculino campeón de futsal',
                'imagen_path' => 'images/galeria_3.jpg',
            ]);
        }
    }
}
