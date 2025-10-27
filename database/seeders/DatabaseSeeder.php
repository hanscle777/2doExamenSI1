<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Materia;
use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $rolAdmin = Rol::firstOrCreate(['nombre' => 'Administrador']);
        $rolDocente = Rol::firstOrCreate(['nombre' => 'Docente']);
        $rolEstudiante = Rol::firstOrCreate(['nombre' => 'Estudiante']);

        // Crear usuario administrador
        User::firstOrCreate(
            ['correo' => 'admin@admin.com'],
            [
                'nombre' => 'Admin',
                'apellido' => 'Sistema',
                'contrasena' => Hash::make('admin123'),
                'telefono' => 1234567890,
                'estado' => 'activo',
                'id_rol' => $rolAdmin->id_rol,
            ]
        );

        // Crear usuario docente
        User::firstOrCreate(
            ['correo' => 'docente@docente.com'],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'contrasena' => Hash::make('docente123'),
                'telefono' => 9876543210,
                'estado' => 'activo',
                'id_rol' => $rolDocente->id_rol,
            ]
        );

        // Crear algunas materias
        Materia::firstOrCreate(['nombre' => 'Matemáticas'], ['descripcion' => 'Álgebra y geometría']);
        Materia::firstOrCreate(['nombre' => 'Programación'], ['descripcion' => 'Lenguajes de programación']);
        Materia::firstOrCreate(['nombre' => 'Base de Datos'], ['descripcion' => 'Diseño y administración de BD']);

        // Crear algunos grupos
        Grupo::firstOrCreate(['codigo' => 'GR001']);
        Grupo::firstOrCreate(['codigo' => 'GR002']);
    }
}