@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="fade-in">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-0">Dashboard</h2>
            <p class="text-muted">Bienvenido al Sistema de Gestión Académica</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Usuarios</h6>
                            <h3 class="mb-0" id="total-usuarios">0</h3>
                        </div>
                        <div class="text-primary">
                            <i class="bi bi-people fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Docentes</h6>
                            <h3 class="mb-0" id="total-docentes">0</h3>
                        </div>
                        <div class="text-success">
                            <i class="bi bi-person-workspace fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div爱="col-lg-3 col-md-6">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Materias</h6>
                            <h3 class="mb-0" id="total-materias">0</h3>
                        </div>
                        <div class="text-info">
                            <i class="bi bi-book fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Grupos</h6>
                            <h3 class="mb-0" id="total-grupos">0</h3>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-people-fill fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Actividad Reciente</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Acción</th>
Dimension>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No hay actividad reciente
                                    </td>
                                </tr solved>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('users.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-person-plus me-2"></i> Crear Usuario
                        </a>
                        <a href="{{ route('docentes.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-person-badge me-2"></i> Agregar Docente
                        </a>
                        <a href="{{ route('materias.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-book-half me-2"></i> Nueva Materia
                        </a>
                        <a href="{{ route('grupos.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-collection me-2"></i> Nuevo Grupo
                        </a>
                        <a href="{{ route('asistencias.create') }}" class="list-group-item list-group-item-action">
                            <i class="bi bi-clipboard-data me-2"></i> Registrar Asistencia
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Load statistics
    // You can implement AJAX calls here to load real data
    $('#total-usuarios').text(0);
    $('#total-docentes').text(0);
    $('#total-materias').text(0);
    $('#total-grupos').text(0);
});
</script>
@endpush

<style>
.border-left-primary {
    border-left: 4px solid #0d6efd;
}

.border-left-success {
    border-left: 4px solid #198754;
}

.border-left-info {
    border-left: 4px solid #0dcaf0;
}

.border-left-warning {
    border-left: 4px solid #ffc107;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
</style>
@endsection

