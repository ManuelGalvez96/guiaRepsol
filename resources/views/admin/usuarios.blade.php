<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios - Guía Repsol</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-csrf="{{ csrf_token() }}"
    data-buscar="{{ request('buscar', '') }}"
    data-rol="{{ request('rol', '') }}"
    data-page="{{ $usuarios->currentPage() }}"
    data-route-usuarios="{{ route('admin.usuarios') }}"
    data-route-usuarios-crear="{{ route('admin.usuarios.crear') }}"
    data-route-logout="{{ route('logout') }}">

    <!-- Header -->
    <div class="header">
        <div class="servicios-iconos">
            <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        </div>
        <button type="button" class="logout-btn" onclick="logoutUser()">Cerrar sesión</button>
    </div>

    <!-- Contenido -->
    <div class="container">
        <div class="top-section">
            <h1>Gestión de Usuarios</h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.index') }}" class="create-btn" style="background-color: #3498db; color: #fff;">← Volver a Restaurantes</a>
                <a href="#" onclick="openCreateUserModal(); return false;" class="create-btn">Crear Usuario</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="filters">
            <input type="text" name="buscar" class="filter-search" id="filterBuscar"
                placeholder="🔍 Buscar por nombre, apellidos o email..." value="{{ request('buscar') }}"
                oninput="filtroConDelayUsuarios()">

            <select name="rol" class="filter-select" id="filterRol" onchange="aplicarFiltrosUsuarios()">
                <option value="">Todos los roles</option>
                <option value="administrador" {{ request('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                <option value="usuario" {{ request('rol') == 'usuario' ? 'selected' : '' }}>Usuario</option>
                <option value="gerente" {{ request('rol') == 'gerente' ? 'selected' : '' }}>Gerente</option>
            </select>

            <button type="button" class="btn btn-reset" id="resetFilters" onclick="resetearFiltrosUsuarios()">Limpiar Filtros</button>
        </div>

        <!-- Tabla de usuarios -->
        <div id="usuariosContainer">
            @include('admin.partials.usuarios-table', ['usuarios' => $usuarios])
        </div>
    </div>

    <!-- Modal -->
    <div id="modalOverlay" class="modal-overlay modal-hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Modal</h2>
                <button type="button" class="modal-close" onclick="closeUserModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenido del modal se carga aquí -->
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_js/admin_usuarios.js') }}"></script>
</body>

</html>
