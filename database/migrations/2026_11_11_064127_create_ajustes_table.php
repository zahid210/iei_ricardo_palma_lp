<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ajustes', function (Blueprint $table) {
            $table->id();
            $table->string('telefono')->default('+51 921 896 330');
            $table->string('whatsapp')->default('51921896330');
            $table->string('email')->default('contacto@rpalma.edu.pe');
            $table->string('horario_atencion')->default('Lunes a Viernes: 8:00 a.m. a 1:00 p.m.');
            $table->string('direccion')->default('Barrio La Esperanza s/n, Chaupimarca — Cerro de Pasco, Región Pasco, Perú.');
            $table->text('google_maps_url')->nullable();
            $table->string('facebook_url')->default('https://www.facebook.com/ricardinosemprendeores');
            $table->string('youtube_url')->default('https://www.youtube.com/@ricardopalma4155');
            $table->timestamps();
        });

        // Insertar registro inicial por defecto
        DB::table('ajustes')->insert([
            'telefono' => '+51 921 896 330',
            'whatsapp' => '51921896330',
            'email' => 'contacto@rpalma.edu.pe',
            'horario_atencion' => 'Lunes a Viernes: 8:00 a.m. a 1:00 p.m.',
            'direccion' => 'Barrio La Esperanza s/n, Chaupimarca — Cerro de Pasco, Región Pasco, Perú.',
            'google_maps_url' => 'https://maps.app.goo.gl/UFgLwdUeNxSo5gAa9',
            'facebook_url' => 'https://www.facebook.com/ricardinosemprendeores',
            'youtube_url' => 'https://www.youtube.com/@ricardopalma4155',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
