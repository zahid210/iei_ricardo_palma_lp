<?php

namespace Database\Seeders;

use App\Models\Docente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/docentes.json');
        if (! File::exists($jsonPath)) {
            return;
        }

        $docentes = json_decode(File::get($jsonPath), true);

        foreach ($docentes as $item) {
            Docente::updateOrCreate(
                [
                    'nivel' => $item['nivel'],
                    'nombres_apellidos' => $item['nombres_apellidos'],
                ],
                [
                    'cargo' => $item['cargo'] ?? 'DOCENTE DE AULA',
                    'dni' => $item['dni'] ?? null,
                    'orden' => $item['orden'] ?? 0,
                    'activo' => $item['activo'] ?? true,
                ]
            );
        }
    }
}
