<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitudes de Negocio - Guía Repsol</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-route-logout="{{ route('logout') }}">
    <!-- Header -->
    <div class="header">
        <div class="logo">guia repsol</div>
        <button class="logout-btn" id="logoutBtn">Cerrar sesión</button>
    </div>

    <!-- Container -->
    <div class="container">
        <div class="top-section">
            <h1>Solicitudes de Negocio Pendientes</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.dashboard') }}" class="create-btn"
                    style="background-color: #9b59b6;">Dashboard</a>
                <a href="{{ route('admin.index') }}" class="create-btn" style="background-color: #3498db;">Gestión de
                    Restaurantes</a>
                <a href="{{ route('admin.usuarios.index') }}" class="create-btn" style="background-color: #27ae60;">👥 Gestión de Usuarios</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filtro de elementos por página -->
        <form method="GET" action="{{ route('admin.solicitudes') }}" style="margin-bottom: 20px;">
            <div style="display: flex; justify-content: flex-end;">
                <select name="per_page" class="filter-select" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 por página</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 por página</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 por página</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 por página</option>
                </select>
            </div>
        </form>

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
                                @if ($solicitud->usuario)
                                    <br><small style="color: #7f8c8d;">Por: {{ $solicitud->usuario->name }}</small>
                                @endif
                            </td>
                            <td>
                                <button class="btn-edit action-ver-detalles-btn"
                                    data-solicitud-id="{{ $solicitud->id }}" title="Ver detalles">
                                    👁️ Ver Detalles
                                </button>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-edit action-aprobar-btn"
                                        data-solicitud-id="{{ $solicitud->id }}" title="Aprobar">✅</button>
                                    <button type="button" class="btn-delete action-rechazar-btn"
                                        data-solicitud-id="{{ $solicitud->id }}" title="Rechazar">❌</button>
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
        </div>
        <!-- Pagination -->
        <div class="pagination">
            {{-- Botón Anterior --}}
            @if ($solicitudes->onFirstPage())
                <span class="page-link page-disabled">«</span>
            @else
                <a href="{{ $solicitudes->previousPageUrl() }}" class="page-link">«</a>
            @endif

            {{-- Primera página --}}
            @if ($solicitudes->currentPage() > 3)
                <a href="{{ $solicitudes->url(1) }}" class="page-link">1</a>
                @if ($solicitudes->currentPage() > 4)
                    <span class="page-dots">...</span>
                @endif
            @endif

            {{-- Páginas alrededor de la actual --}}
            @for ($i = max(1, $solicitudes->currentPage() - 2); $i <= min($solicitudes->lastPage(), $solicitudes->currentPage() + 2); $i++)
                @if ($i == $solicitudes->currentPage())
                    <span class="page-link active">{{ $i }}</span>
                @else
                    <a href="{{ $solicitudes->url($i) }}" class="page-link">{{ $i }}</a>
                @endif
            @endfor

            {{-- Última página --}}
            @if ($solicitudes->currentPage() < $solicitudes->lastPage() - 2)
                @if ($solicitudes->currentPage() < $solicitudes->lastPage() - 3)
                    <span class="page-dots">...</span>
                @endif
                <a href="{{ $solicitudes->url($solicitudes->lastPage()) }}"
                    class="page-link">{{ $solicitudes->lastPage() }}</a>
            @endif

            {{-- Botón Siguiente --}}
            @if ($solicitudes->hasMorePages())
                <a href="{{ $solicitudes->nextPageUrl() }}" class="page-link">»</a>
            @else
                <span class="page-link page-disabled">»</span>
            @endif
        </div>
    </div>

    <!-- Modal de Detalles Bootstrap -->
    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles de la Solicitud</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <h6 class="fw-bold">Imagen Principal</h6>
                        <div class="text-center">
                            <img id="modalImagen" src="" alt="Imagen del restaurante" class="img-fluid rounded"
                                style="max-height: 300px;">
                        </div>
                        <div id="imagenesAdicionalesContainer" style="display: none;" class="mt-3">
                            <h6 class="fw-bold">Imágenes Adicionales</h6>
                            <div id="imagenesAdicionales" class="d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Información Básica</h6>
                        <p><strong>Nombre:</strong> <span id="modalNombre"></span></p>
                        <p><strong>Categoría:</strong> <span id="modalCategoria"></span></p>
                        <p><strong>Descripción:</strong></p>
                        <p id="modalDescripcion" class="text-justify"></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Ubicación</h6>
                        <p><strong>Dirección:</strong> <span id="modalDireccion"></span></p>
                        <p><strong>Ciudad:</strong> <span id="modalCiudad"></span></p>
                        <p><strong>Provincia:</strong> <span id="modalProvincia"></span></p>
                        <p><strong>Código Postal:</strong> <span id="modalCodigoPostal"></span></p>
                        <p><strong>Comunidad Autónoma:</strong> <span id="modalComunidad"></span></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Contacto</h6>
                        <p><strong>Teléfono:</strong> <span id="modalTelefono"></span></p>
                        <p><strong>Email:</strong> <span id="modalEmail"></span></p>
                        <p><strong>Web:</strong> <span id="modalWeb"></span></p>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-bold">Información Adicional</h6>
                        <p><strong>Precio Promedio:</strong> <span id="modalPrecio"></span> €</p>
                        <p><strong>Tipos de Cocina:</strong> <span id="modalTiposComida"></span></p>
                        <p><strong>Solicitado por:</strong> <span id="modalUsuario"></span></p>
                        <p><strong>Fecha de Solicitud:</strong> <span id="modalFecha"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        window.solicitudesData = {
            @foreach ($solicitudes as $solicitud)
                {{ $solicitud->id }}: {
                    imagen: "{{ $solicitud->imagenes->first() ? asset($solicitud->imagenes->first()->url) : asset('images/placeholder.jpg') }}",
                    imagenes_adicionales: [
                        @foreach ($solicitud->imagenes->skip(1) as $imagen)
                            "{{ asset($imagen->url) }}"
                            {{ !$loop->last ? ',' : '' }}
                        @endforeach
                    ],
                    nombre: "{{ $solicitud->nombre }}",
                    categoria: "{{ $solicitud->categoria->nombre ?? '-' }}",
                    descripcion: "{{ $solicitud->descripcion ?? 'Sin descripción' }}",
                    direccion: "{{ $solicitud->direccion }}",
                    ciudad: "{{ $solicitud->ubicacion->ciudad ?? '' }}",
                    provincia: "{{ $solicitud->ubicacion->provincia ?? '' }}",
                    codigo_postal: "{{ $solicitud->ubicacion->codigo_postal ?? '' }}",
                    comunidad: "{{ $solicitud->ubicacion->comunidad_autonoma ?? '' }}",
                    telefono: "{{ $solicitud->telefono ?? '-' }}",
                    email: "{{ $solicitud->email }}",
                    web: "{{ $solicitud->web ?? '-' }}",
                    precio: "{{ number_format($solicitud->precio, 2) }}",
                    tipos_comida: "{{ $solicitud->tiposComida->count() > 0 ? $solicitud->tiposComida->pluck('nombre')->join(', ') : '-' }}",
                    usuario: "{{ $solicitud->usuario->name ?? 'Desconocido' }}",
                    fecha: "{{ $solicitud->created_at->format('d/m/Y H:i') }}"
                }
                {{ !$loop->last ? ',' : '' }}
            @endforeach
        };
    </script>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- Verificar que Bootstrap esté cargado -->
    <script>
        if (typeof bootstrap === 'undefined') {
            console.error('ERROR: Bootstrap no se ha cargado correctamente');
        } else {
            console.log('Bootstrap cargado correctamente:', bootstrap);
        }
    </script>

    <script src="{{ asset('js/solicitudes.js') }}"></script>
</body>

</html>
