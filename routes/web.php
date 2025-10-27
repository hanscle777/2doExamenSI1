<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\GrupoMateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\DocenteClaseController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\AuthController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas para autenticación
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});

// Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Rutas protegidas
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Users Routes
    Route::resource('users', UserController::class);

    // Roles Routes
    Route::resource('rols', RolController::class);

    // Permisos Routes
    Route::resource('permisos', PermisoController::class);

    // Docentes Routes
    Route::resource('docentes', DocenteController::class);

    // Materias Routes
    Route::resource('materias', MateriaController::class);

    // Grupos Routes
    Route::resource('grupos', GrupoController::class);

    // Aulas Routes
    Route::resource('aulas', AulaController::class);

    // Grupo-Materias Routes
    Route::resource('grupo-materias', GrupoMateriaController::class);

    // Horarios Routes
    Route::resource('horarios', HorarioController::class);

    // Docente-Clases Routes
    Route::resource('docente-clases', DocenteClaseController::class);

    // Asistencias Routes
    Route::resource('asistencias', AsistenciaController::class);

    // Rol-Permisos Routes
    Route::resource('rol-permisos', RolPermisoController::class);
});
