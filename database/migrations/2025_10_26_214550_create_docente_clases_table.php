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
        Schema::create('docente_clases', function (Blueprint $table) {
            $table->id('id_docente_clase');
            $table->string('periodo', 10);
            $table->foreignId('id_docente')->references('id_docente')->on('docentes');
            $table->foreignId('id_grupo_materia')->references('id_grupo_materia')->on('grupo_materias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_clases');
    }
};
