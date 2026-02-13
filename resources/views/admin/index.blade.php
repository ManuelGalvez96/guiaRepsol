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
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">guia repsol</div>
        <button type="button" class="logout-btn" onclick="logoutUser()">Cerrar sesión</button>
    </div>

    <!-- Container -->
    <div class="container">
        <div class="top-section">
            <h1>Gestión de restaurantes</h1>
            <button type="button" class="create-btn" onclick="openCreateModal()">Crear Restaurante</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="filters">
            <input type="text" name="buscar" class="filter-search" id="filterBuscar" 
                   placeholder="🔍 Buscar restaurante..." 
                   value="{{ request('buscar') }}">

            <select name="tipo_comida" class="filter-select" id="filterTipoComida">
                <option value="">Tipo de comida</option>
                @foreach($tiposComida as $tipo)
                    <option value="{{ $tipo->id }}" {{ request('tipo_comida') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="valoracion" class="filter-select" id="filterValoracion">
                <option value="">Valoración</option>
                <option value="5" {{ request('valoracion') == '5' ? 'selected' : '' }}>5 estrellas</option>
                <option value="4" {{ request('valoracion') == '4' ? 'selected' : '' }}>4 estrellas</option>
                <option value="3" {{ request('valoracion') == '3' ? 'selected' : '' }}>3 estrellas</option>
                <option value="2" {{ request('valoracion') == '2' ? 'selected' : '' }}>2 estrellas</option>
                <option value="1" {{ request('valoracion') == '1' ? 'selected' : '' }}>1 estrella</option>
            </select>

            <select name="precio" class="filter-select" id="filterPrecio">
                <option value="">Precio</option>
                <option value="0-10" {{ request('precio') == '0-10' ? 'selected' : '' }}>0-10€</option>
                <option value="10-20" {{ request('precio') == '10-20' ? 'selected' : '' }}>10-20€</option>
                <option value="20-30" {{ request('precio') == '20-30' ? 'selected' : '' }}>20-30€</option>
                <option value="30-50" {{ request('precio') == '30-50' ? 'selected' : '' }}>30-50€</option>
                <option value="50+" {{ request('precio') == '50+' ? 'selected' : '' }}>50€+</option>
            </select>
            
            <button type="button" class="btn btn-reset" id="resetFilters">Limpiar Filtros</button>
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

    <!-- JavaScript separado para mejor mantenimiento -->
    <script>
        // Pasar variables de PHP a JavaScript
        window.adminConfig = {
            csrfToken: '{{ csrf_token() }}',
            currentFilters: {
                buscar: '{{ request('buscar', '') }}',
                tipo_comida: '{{ request('tipo_comida', '') }}',
                valoracion: '{{ request('valoracion', '') }}',
                precio: '{{ request('precio', '') }}', 
                page: {{ $restaurantes->currentPage() }}
            },
            routes: {
                adminIndex: '{{ route('admin.index') }}',
                adminCreate: '{{ route('admin.create') }}',
                logout: '{{ route('logout') }}'
            }
        };
    </script>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #e74c3c;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Cargar funciones para modales -->
    @vite(['resources/js/admin_js/admin_create.js', 'resources/js/admin_js/admin_edit.js', 'resources/js/admin_js/admin_index.js'])
</body>
</html>

