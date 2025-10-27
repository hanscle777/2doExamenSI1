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
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id('id_asistencia');
            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->string('estado', 10);
            $table->foreignId('id_docente')->references('id_docente')->on('docentes');
            $table->foreignId('id_docente_clase')->references('id_docente_clase')->on('docente_clases');
            $table->foreignId('id_horario')->references('id_horario')->on('horarios');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
