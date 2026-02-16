<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administración - Guía Repsol</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body
    data-csrf="{{ csrf_token() }}"
    data-buscar="{{ request('buscar', '') }}"
    data-tipo-comida="{{ request('tipo_comida', '') }}"
    data-valoracion="{{ request('valoracion', '') }}"
    data-precio="{{ request('precio', '') }}"
    data-page="{{ $restaurantes->currentPage() }}"
    data-route-index="{{ route('admin.index') }}"
    data-route-create="{{ route('admin.create') }}"
    data-route-logout="{{ route('logout') }}"
>
    <!-- Header -->
    <div class="header">
        <div class="logo">guia repsol</div>
        <button type="button" class="logout-btn" onclick="logoutUser()">Cerrar sesión</button>
    </div>

    <!-- contenedires  -->
    <div class="container">
        <div class="top-section">
            <h1>Gestión de restaurantes</h1>
            <div style="display: flex; gap: 10px;">
                <a href="{{ route('admin.solicitudes') }}" class="create-btn" style="background-color: #f39c12;">Solicitudes de negocio</a>
                <a href="{{ route('admin.create') }}" class="create-btn">Crear Restaurante</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <div class="filters">
            <input type="text" name="buscar" class="filter-search" id="filterBuscar" 
                   placeholder="🔍 Buscar restaurante..." 
                   value="{{ request('buscar') }}"
                   oninput="filtroConDelay()">

            <select name="tipo_comida" class="filter-select" id="filterTipoComida" onchange="aplicarFiltros()">
                <option value="">Tipo de comida</option>
                @foreach($tiposComida as $tipo)
                    <option value="{{ $tipo->id }}" {{ request('tipo_comida') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="valoracion" class="filter-select" id="filterValoracion" onchange="aplicarFiltros()">
                <option value="">Valoración</option>
                <option value="5" {{ request('valoracion') == '5' ? 'selected' : '' }}>5 estrellas</option>
                <option value="4" {{ request('valoracion') == '4' ? 'selected' : '' }}>4 estrellas</option>
                <option value="3" {{ request('valoracion') == '3' ? 'selected' : '' }}>3 estrellas</option>
                <option value="2" {{ request('valoracion') == '2' ? 'selected' : '' }}>2 estrellas</option>
                <option value="1" {{ request('valoracion') == '1' ? 'selected' : '' }}>1 estrella</option>
            </select>

            <select name="precio" class="filter-select" id="filterPrecio" onchange="aplicarFiltros()">
                <option value="">Precio</option>
                <option value="0-10" {{ request('precio') == '0-10' ? 'selected' : '' }}>0-10€</option>
                <option value="10-20" {{ request('precio') == '10-20' ? 'selected' : '' }}>10-20€</option>
                <option value="20-30" {{ request('precio') == '20-30' ? 'selected' : '' }}>20-30€</option>
                <option value="30-50" {{ request('precio') == '30-50' ? 'selected' : '' }}>30-50€</option>
                <option value="50+" {{ request('precio') == '50+' ? 'selected' : '' }}>50€+</option>
            </select>
            
            <button type="button" class="btn btn-reset" id="resetFilters" onclick="resetearFiltros()">Limpiar Filtros</button>
        </div>

        <!-- Table Container -->
        <div id="restaurantesContainer">
            @include('admin.partials.restaurantes-table', ['restaurantes' => $restaurantes])
        </div>
    </div>

    <!-- Modales -->
    <div id="modalOverlay" class="modal-overlay modal-hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Modal</h2>
                <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenido del modal se carga aquí -->
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin_js/admin_index.js') }}"></script>
    <script src="{{ asset('js/admin_js/admin_edit.js') }}"></script>
    <script src="{{ asset('js/admin_js/admin_create.js') }}"></script>
</body>
</html>

