<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeria_etiquetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::table('galerias', function (Blueprint $table) {
            $table->text('leyenda')->nullable()->after('titulo');
            $table->foreignId('etiqueta_id')->nullable()->after('leyenda')->constrained('galeria_etiquetas')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galerias', function (Blueprint $table) {
            $table->dropForeign(['etiqueta_id']);
            $table->dropColumn(['leyenda', 'etiqueta_id']);
        });

        Schema::dropIfExists('galeria_etiquetas');
    }
};
