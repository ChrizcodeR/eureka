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
        Schema::table('usuarios', function (Blueprint $table) {
            // Índices para búsquedas rápidas
            $table->index('nombre_completo');
            $table->index('numero_cedula');
            $table->index('created_at');
            $table->index('imagen_descargada');
            $table->index(['imagen_descargada', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropIndex(['nombre_completo']);
            $table->dropIndex(['numero_cedula']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['imagen_descargada']);
            $table->dropIndex(['imagen_descargada', 'created_at']);
        });
    }
};
