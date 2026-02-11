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
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Detalles</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                    <tr>
                        <td><strong>#{{ $solicitud->id }}</strong></td>
                        <td>
                            <strong>{{ $solicitud->nombre }}</strong>
                            @if($solicitud->usuario)
                                <br><small style="color: #7f8c8d;">Por: {{ $solicitud->usuario->name }}</small>
                            @endif
                        </td>
                        <td>
                            <button class="btn-edit" onclick="verDetalles({{ $solicitud->id }})" title="Ver detalles">
                                👁️ Ver Detalles
                            </button>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-edit" onclick="aprobarSolicitud({{ $solicitud->id }})" title="Aprobar">✅</button>
                                <button type="button" class="btn-delete" onclick="rechazarSolicitud({{ $solicitud->id }})" title="Rechazar">❌</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px;">
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

    <!-- Modal de Detalles -->
    <div id="detallesModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2>Detalles de la Solicitud</h2>
            
            <div class="modal-body">
                <div class="modal-section">
                    <div class="modal-image">
                        <img id="modalImagen" src="" alt="Imagen del restaurante">
                    </div>
                </div>

                <div class="modal-section">
                    <h3>Información Básica</h3>
                    <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                    <p><strong>Categoría:</strong> <span id="modalCategoria"></span></p>
                    <p><strong>Descripción:</strong></p>
                    <p id="modalDescripcion" style="text-align: justify;"></p>
                </div>

                <div class="modal-section">
                    <h3>Ubicación</h3>
                    <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
                    <p><strong>Ciudad:</strong> <span id="modalCiudad"></span></p>
                    <p><strong>Provincia:</strong> <span id="modalProvincia"></span></p>
                    <p><strong>Código Postal:</strong> <span id="modalCodigoPostal"></span></p>
                    <p><strong>Comunidad Autónoma:</strong> <span id="modalComunidad"></span></p>
                </div>

                <div class="modal-section">
                    <h3>Contacto</h3>
                    <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                    <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                    <p><strong>Web:</strong> <span id="modalWeb"></span></p>
                </div>

                <div class="modal-section">
                    <h3>Información Adicional</h3>
                    <p><strong>Precio Promedio:</strong> <span id="modalPrecio"></span> €</p>
                    <p><strong>Tipos de Cocina:</strong> <span id="modalTiposComida"></span></p>
                    <p><strong>Solicitado por:</strong> <span id="modalUsuario"></span></p>
                    <p><strong>Fecha de Solicitud:</strong> <span id="modalFecha"></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Datos de las solicitudes para JavaScript -->
    <script>
        window.solicitudesData = {
            @foreach($solicitudes as $solicitud)
            {{ $solicitud->id }}: {
                imagen: "{{ $solicitud->imagenes->first() ? asset('storage/' . $solicitud->imagenes->first()->url) : asset('images/placeholder.jpg') }}",
                nombre: "{{ $solicitud->nombre }}",
                categoria: "{{ $solicitud->categoria->nombre ?? '-' }}",
                descripcion: "{{ $solicitud->descripcion ?? 'Sin descripción' }}",
                direccion: "{{ $solicitud->direccion }}",
                ciudad: "{{ $solicitud->ubicacionPendiente->ciudad ?? '' }}",
                provincia: "{{ $solicitud->ubicacionPendiente->provincia ?? '' }}",
                codigo_postal: "{{ $solicitud->ubicacionPendiente->codigo_postal ?? '' }}",
                comunidad: "{{ $solicitud->ubicacionPendiente->comunidad_autonoma ?? '' }}",
                telefono: "{{ $solicitud->telefono ?? '-' }}",
                email: "{{ $solicitud->email }}",
                web: "{{ $solicitud->web ?? '-' }}",
                precio: "{{ number_format($solicitud->precio, 2) }}",
                tipos_comida: "{{ $solicitud->tiposComida->count() > 0 ? $solicitud->tiposComida->pluck('nombre')->join(', ') : '-' }}",
                usuario: "{{ $solicitud->usuario->name ?? 'Desconocido' }}",
                fecha: "{{ $solicitud->created_at->format('d/m/Y H:i') }}"
            }{{ !$loop->last ? ',' : '' }}
            @endforeach
        };
    </script>

    <script src="{{ asset('js/solicitudes.js') }}"></script>
</body>
</html>
