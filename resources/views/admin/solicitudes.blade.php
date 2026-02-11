<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitudes de Negocio - Guía Repsol</title>
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
            <h1>Solicitudes de Negocio Pendientes</h1>
            <a href="{{ route('admin.index') }}" class="create-btn" style="background-color: #3498db;">Volver a Gestión</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Tipo de Comida</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Fecha Solicitud</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                    <tr>
                        <td>
                            @if($solicitud->imagenes->first())
                                <img src="{{ asset('storage/' . $solicitud->imagenes->first()->url) }}" alt="{{ $solicitud->nombre }}" class="restaurant-img">
                            @else
                                <div class="restaurant-img"></div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $solicitud->nombre }}</strong>
                            @if($solicitud->user)
                                <br><small style="color: #7f8c8d;">Por: {{ $solicitud->user->name }}</small>
                            @endif
                        </td>
                        <td>{{ $solicitud->direccion }}, {{ $solicitud->ubicacion->ciudad ?? '' }}</td>
                        <td>
                            @if($solicitud->tiposComida->count() > 0)
                                {{ $solicitud->tiposComida->pluck('nombre')->join(', ') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $solicitud->telefono ?? '-' }}</td>
                        <td>{{ $solicitud->email }}</td>
                        <td>{{ $solicitud->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" onclick="aprobarSolicitud({{ $solicitud->id }})" title="Aprobar">✅</button>
                                <a href="{{ route('admin.edit', $solicitud) }}">
                                    <button class="btn-edit" title="Editar">✏️</button>
                                </a>
                                <button type="button" class="btn-delete" onclick="rechazarSolicitud({{ $solicitud->id }})" title="Rechazar">❌</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            No hay solicitudes pendientes
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination">
                {{-- Botón Anterior --}}
                @if($solicitudes->onFirstPage())
                    <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">«</span>
                @else
                    <a href="{{ $solicitudes->previousPageUrl() }}" class="page-link">«</a>
                @endif

                {{-- Primera página --}}
                @if($solicitudes->currentPage() > 3)
                    <a href="{{ $solicitudes->url(1) }}" class="page-link">1</a>
                    @if($solicitudes->currentPage() > 4)
                        <span class="page-dots">...</span>
                    @endif
                @endif

                {{-- Páginas alrededor de la actual --}}
                @for($i = max(1, $solicitudes->currentPage() - 2); $i <= min($solicitudes->lastPage(), $solicitudes->currentPage() + 2); $i++)
                    @if($i == $solicitudes->currentPage())
                        <span class="page-link active">{{ $i }}</span>
                    @else
                        <a href="{{ $solicitudes->url($i) }}" class="page-link">{{ $i }}</a>
                    @endif
                @endfor

                {{-- Última página --}}
                @if($solicitudes->currentPage() < $solicitudes->lastPage() - 2)
                    @if($solicitudes->currentPage() < $solicitudes->lastPage() - 3)
                        <span class="page-dots">...</span>
                    @endif
                    <a href="{{ $solicitudes->url($solicitudes->lastPage()) }}" class="page-link">{{ $solicitudes->lastPage() }}</a>
                @endif

                {{-- Botón Siguiente --}}
                @if($solicitudes->hasMorePages())
                    <a href="{{ $solicitudes->nextPageUrl() }}" class="page-link">»</a>
                @else
                    <span class="page-link" style="opacity: 0.5; cursor: not-allowed;">»</span>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Configurar CSRF token para todas las peticiones AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Función para aprobar solicitud
        function aprobarSolicitud(id) {
            Swal.fire({
                title: '¿Aprobar esta solicitud?',
                text: "El restaurante será visible para todos los usuarios",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#27ae60',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, aprobar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Aprobando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/admin/${id}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            activo: true
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Aprobado!',
                                text: 'La solicitud ha sido aprobada',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo aprobar la solicitud'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al aprobar la solicitud'
                        });
                    });
                }
            });
        }

        // Función para rechazar solicitud
        function rechazarSolicitud(id) {
            Swal.fire({
                title: '¿Rechazar esta solicitud?',
                text: "El restaurante será eliminado de la base de datos",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, rechazar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Rechazando...',
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
                                title: '¡Rechazado!',
                                text: 'La solicitud ha sido rechazada',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo rechazar la solicitud'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al rechazar la solicitud'
                        });
                    });
                }
            });
        }
    </script>
</body>
</html>
