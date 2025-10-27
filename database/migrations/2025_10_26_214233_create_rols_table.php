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
        Schema::create('rols', function (Blueprint $table) {
            $table->id('id_rol');
            $table->string('nombre', 50)->unique();
            $table->timestamps();
        });

        // Agregar la relación foránea a la tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('id_rol')->references('id_rol')->on('rols');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rols');
    }
};
