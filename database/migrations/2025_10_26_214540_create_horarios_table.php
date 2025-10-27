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
        Schema::create('horarios', function (Blueprint $table) {
            $table->id('id_horario');
            $table->string('horario_inicio', 10);
            $table->string('horario_fin', 10);
            $table->string('diasemana', 10);
            $table->foreignId('id_aula')->references('id_aula')->on('aulas');
            $table->foreignId('id_grupo_materia')->references('id_grupo_materia')->on('grupo_materias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
