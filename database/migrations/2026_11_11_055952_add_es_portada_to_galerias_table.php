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
        Schema::table('galerias', function (Blueprint $table) {
            $table->boolean('es_portada')->default(false)->after('etiqueta_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galerias', function (Blueprint $table) {
            $table->dropColumn('es_portada');
        });
    }
};
