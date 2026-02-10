<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administración - Guía Repsol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
        }

        /* Header */
        .header {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 500;
        }

        .logo::before {
            content: "☀️";
            font-size: 24px;
        }

        .logout-btn {
            background: #fff;
            border: 1px solid #ddd;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #f5f5f5;
        }

        /* Container */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        /* Title and Create Button */
        .top-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .create-btn {
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            color: #000;
            display: inline-block;
        }

        .create-btn:hover {
            background: #f5f5f5;
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-select {
            min-width: 150px;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #fff;
            font-size: 14px;
        }

        /* Table */
        .table-container {
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f8f9fa;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Image */
        .restaurant-img {
            width: 60px;
            height: 60px;
            background: #e0e0e0;
            border-radius: 4px;
            object-fit: cover;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .btn-edit {
            background: #ffd500;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-edit:hover {
            background: #e6c000;
        }

        .btn-delete {
            background: #e74c3c;
            border: none;
            padding: 8px 20px;
            border-radius: 4px;
            cursor: pointer;
            color: #fff;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            padding: 20px;
            background: #fff;
        }

        .page-link {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #000;
            min-width: 35px;
            text-align: center;
        }

        .page-link:hover {
            background: #f5f5f5;
        }

        .page-link.active {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .page-dots {
            padding: 8px;
        }

        /* Alert Messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">guia repsol</div>
        <button class="logout-btn" onclick="window.location.href='{{ route('login') }}'">Cerrar sesión</button>
    </div>

    <!-- Container -->
    <div class="container">
        <div class="top-section">
            <h1>Gestión de restaurantes</h1>
            <a href="{{ route('admin.create') }}" class="create-btn">Crear Restaurante</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('admin.index') }}">
            <div class="filters">
                <select name="tipo_cocina" class="filter-select" onchange="this.form.submit()">
                    <option value="">Tipo de cocina</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ request('tipo_cocina') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>

                <select name="valoracion" class="filter-select" onchange="this.form.submit()">
                    <option value="">⭐ Valoración</option>
                    <option value="4">4+ estrellas</option>
                    <option value="3">3+ estrellas</option>
                    <option value="2">2+ estrellas</option>
                </select>

                <select name="precio" class="filter-select" onchange="this.form.submit()">
                    <option value="">💰 Precio</option>
                    <option value="20">Hasta 20€</option>
                    <option value="50">Hasta 50€</option>
                    <option value="100">Hasta 100€</option>
                </select>
            </div>
        </form>

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Precio</th>
                        <th>Varacion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restaurantes as $restaurante)
                    <tr>
                        <td>
                            @if($restaurante->imagenes->first())
                                <img src="{{ asset('storage/' . $restaurante->imagenes->first()->ruta_imagen) }}" alt="{{ $restaurante->nombre }}" class="restaurant-img">
                            @else
                                <div class="restaurant-img"></div>
                            @endif
                        </td>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->direccion }}, {{ $restaurante->ubicacion->ciudad ?? '' }}</td>
                        <td>{{ $restaurante->telefono ?? '-' }}</td>
                        <td>{{ number_format($restaurante->precio, 2) }}€</td>
                        <td>{{ number_format($restaurante->valoracion_promedio, 1) }} ⭐</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.edit', $restaurante) }}">
                                    <button class="btn-edit">Editar</button>
                                </a>
                                <button type="button" class="btn-delete" onclick="deleteRestaurante({{ $restaurante->id }})">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px;">
                            No hay restaurantes disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                @if($restaurantes->onFirstPage())
                    <span class="page-link" style="opacity: 0.5;">1</span>
                @else
                    <a href="{{ $restaurantes->url(1) }}" class="page-link">1</a>
                @endif

                @if($restaurantes->currentPage() > 1)
                    <a href="{{ $restaurantes->previousPageUrl() }}" class="page-link">{{ $restaurantes->currentPage() - 1 }}</a>
                @endif

                @if($restaurantes->hasMorePages())
                    <span class="page-dots">...</span>
                    <a href="{{ $restaurantes->url($restaurantes->lastPage() - 1) }}" class="page-link">{{ $restaurantes->lastPage() - 1 }}</a>
                    <a href="{{ $restaurantes->url($restaurantes->lastPage()) }}" class="page-link">{{ $restaurantes->lastPage() }}</a>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Configurar CSRF token para todas las peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Función para eliminar restaurante con AJAX
        function deleteRestaurante(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Eliminando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/admin/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo eliminar el restaurante'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar el restaurante'
                        });
                    });
                }
            });
        }

        // Función para mostrar alertas con SweetAlert
        function showAlert(message, type) {
            Swal.fire({
                icon: type === 'success' ? 'success' : 'error',
                title: type === 'success' ? '¡Éxito!' : 'Error',
                text: message,
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        }

        // Aplicar filtros con AJAX (opcional)
        document.querySelectorAll('.filter-select').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
</body>
</html>
