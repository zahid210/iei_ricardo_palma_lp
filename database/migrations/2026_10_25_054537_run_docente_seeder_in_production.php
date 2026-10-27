<?php

use App\Models\Docente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'Database\\Seeders\\DocenteSeeder',
            '--force' => true,
        ]);
        Cache::forget('docentes:todos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Docente::truncate();
    }
};
