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
                <select name="tipo_comida" class="filter-select" onchange="this.form.submit()">
                    <option value="">Tipo de comida</option>
                    @foreach($tiposComida as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('tipo_comida') == $tipo->id ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                </select>

                <select name="valoracion" class="filter-select" onchange="this.form.submit()">
                    <option value="">⭐ Valoración</option>
                    <option value="5" {{ request('valoracion') == '5' ? 'selected' : '' }}>5 estrellas</option>
                    <option value="4" {{ request('valoracion') == '4' ? 'selected' : '' }}>4 estrellas</option>
                    <option value="3" {{ request('valoracion') == '3' ? 'selected' : '' }}>3 estrellas</option>
                    <option value="2" {{ request('valoracion') == '2' ? 'selected' : '' }}>2 estrellas</option>
                    <option value="1" {{ request('valoracion') == '1' ? 'selected' : '' }}>1 estrella</option>
                </select>

                <select name="precio" class="filter-select" onchange="this.form.submit()">
                    <option value="">💰 Precio</option>
                    <option value="0-10" {{ request('precio') == '0-10' ? 'selected' : '' }}>0-10€</option>
                    <option value="10-20" {{ request('precio') == '10-20' ? 'selected' : '' }}>10-20€</option>
                    <option value="20-30" {{ request('precio') == '20-30' ? 'selected' : '' }}>20-30€</option>
                    <option value="30-50" {{ request('precio') == '30-50' ? 'selected' : '' }}>30-50€</option>
                    <option value="50+" {{ request('precio') == '50+' ? 'selected' : '' }}>50€+</option>
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
                        <th>Tipo de Comida</th>
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
                                <img src="{{ asset('storage/' . $restaurante->imagenes->first()->url) }}" alt="{{ $restaurante->nombre }}" class="restaurant-img">
                            @else
                                <div class="restaurant-img"></div>
                            @endif
                        </td>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->direccion }}, {{ $restaurante->ubicacion->ciudad ?? '' }}</td>
                        <td>
                            @if($restaurante->tiposComida->count() > 0)
                                {{ $restaurante->tiposComida->pluck('nombre')->join(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $restaurante->telefono ?? '-' }}</td>
                        <td>{{ number_format($restaurante->precio, 2) }}€</td>
                        <td>{{ number_format($restaurante->valoracion_promedio, 1) }} ⭐</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.edit', $restaurante) }}">
                                    <button class="btn-edit">✏️</button>
                                </a>
                                <button type="button" class="btn-delete" onclick="deleteRestaurante({{ $restaurante->id }})">🗑️</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No hay restaurantes disponibles
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{-- Botón Anterior --}}
                @if($restaurantes->onFirstPage())
                    <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">«</span>
                @else
                    <a href="{{ $restaurantes->previousPageUrl() }}" class="page-link">«</a>
                @endif

                {{-- Primera página --}}
                @if($restaurantes->currentPage() > 3)
                    <a href="{{ $restaurantes->url(1) }}" class="page-link">1</a>
                    @if($restaurantes->currentPage() > 4)
                        <span class="page-dots">...</span>
                    @endif
                @endif

                {{-- Páginas alrededor de la actual --}}
                @for($i = max(1, $restaurantes->currentPage() - 2); $i <= min($restaurantes->lastPage(), $restaurantes->currentPage() + 2); $i++)
                    @if($i == $restaurantes->currentPage())
                        <span class="page-link active">{{ $i }}</span>
                    @else
                        <a href="{{ $restaurantes->url($i) }}" class="page-link">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Última página --}}
                @if($restaurantes->currentPage() < $restaurantes->lastPage() - 2)
                    @if($restaurantes->currentPage() < $restaurantes->lastPage() - 3)
                        <span class="page-dots">...</span>
                    @endif
                    <a href="{{ $restaurantes->url($restaurantes->lastPage()) }}" class="page-link">{{ $restaurantes->lastPage() }}</a>
                @endif

                {{-- Botón Siguiente --}}
                @if($restaurantes->hasMorePages())
                    <a href="{{ $restaurantes->nextPageUrl() }}" class="page-link">»</a>
                @else
                    <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">»</span>
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

