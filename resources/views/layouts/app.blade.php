<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Gestión') - {{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <div class="sidebar-brand">
                    <a href="{{ route('dashboard') }}">
                        <i class="bi bi-mortarboard-fill"></i>
                        <span>Gestión Académica</span>
                    </a>
                </div>
                <div class="sidebar-menu">
                    <ul>
                        <li class="sidebar-dropdown">
                            <a href="#">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#usuarios">
                                <i class="bi bi-people"></i>
                                <span>Usuarios</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#roles">
                                <i class="bi bi-person-badge"></i>
                                <span>Roles y Permisos</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#docentes">
                                <i class="bi bi-person-workspace"></i>
                                <span>Docentes</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#materias">
                                <i class="bi bi-book"></i>
                                <span>Materias</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#grupos">
                                <i class="bi bi-people-fill"></i>
                                <span>Grupos</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#aulas">
                                <i class="bi bi-building"></i>
                                <span>Aulas</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#horarios">
                                <i class="bi bi-calendar3"></i>
                                <span>Horarios</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown">
                            <a href="#asistencias">
                                <i class="bi bi-clipboard-check"></i>
                                <span>Asistencias</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="sidebar-footer">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-light text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Session::get('user_name', 'Usuario') }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser">
                        <li><a class="dropdown-item" href="{{ route('change-password') }}">Cambiar Contraseña</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container-fluid">
                    <button type="button" id="toggle-sidebar" class="btn btn-link text-dark">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link" href="#"><i class="bi bi-bell"></i></a>
                        <a class="nav-link" href="#"><i class="bi bi-envelope"></i></a>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content">
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
