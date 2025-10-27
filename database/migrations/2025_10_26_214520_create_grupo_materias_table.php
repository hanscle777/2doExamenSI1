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
        Schema::create('grupo_materias', function (Blueprint $table) {
            $table->id('id_grupo_materia');
            $table->foreignId('id_grupo')->references('id_grupo')->on('grupos');
            $table->foreignId('id_materia')->references('id_materia')->on('materias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_materias');
    }
};
