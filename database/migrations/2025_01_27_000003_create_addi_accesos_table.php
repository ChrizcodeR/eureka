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
        Schema::create('addi_accesos', function (Blueprint $table) {
            $table->id();
            $table->string('plataforma')->default('ADDI');
            $table->string('url')->nullable();
            $table->string('user');
            $table->text('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addi_accesos');
    }
};

