<?php

namespace App\Console\Commands;

use App\Models\Galeria;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SincronizarGaleria extends Command
{
    protected $signature = 'galeria:sync';

    protected $description = 'Sincroniza archivos en storage con la base de datos';

    public function handle()
    {
        // 1. Obtenemos todos los archivos .jpg, .png, .jpeg de la carpeta
        $files = Storage::disk('public')->files();

        foreach ($files as $file) {
            // Sacamos solo el nombre del archivo (ej. "galeria_1.jpg")
            $filename = basename($file);

            // 2. Si no existe en la BD, lo agregamos
            $existe = Galeria::where('imagen_path', $filename)->exists();

            if (! $existe) {
                $cleanTitle = preg_match('/^galeria_(\d+)/i', $filename, $m)
                    ? 'Momento Institucional '.$m[1]
                    : 'Actividad Institucional';

                Galeria::create([
                    'titulo' => $cleanTitle,
                    'imagen_path' => $filename,
                ]);
                $this->info('Agregado: '.$filename);
            }
        }

        // Invalida la caché de la galería para que las nuevas fotos se vean de inmediato.
        Cache::forget('galeria:todas');
        Cache::put('app:content_version', time());

        $this->info('¡Sincronización completada!');
    }
}
