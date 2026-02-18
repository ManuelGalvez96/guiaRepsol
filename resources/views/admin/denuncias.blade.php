<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reportes de Valoraciones - Panel de Administración</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body data-csrf="{{ csrf_token() }}" data-route-logout="{{ route('logout') }}">
    <!-- Header -->
    <div class="header">
        <div class="servicios-iconos">
            <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        </div>
        <button type="button" class="logout-btn">Cerrar sesión</button>
    </div>

    <!-- Contenedor principal -->
    <div class="container">
        <div class="top-section">
            <h1>📋 Reportes de Valoraciones</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.dashboard') }}" class="create-btn">Volver al Dashboard</a>
                <a href="{{ route('admin.solicitudes-eliminacion.index') }}" class="create-btn">Ver Solicitudes de Eliminación</a>
            </div>
        </div>

        <!-- Filtros -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <select name="estado" class="form-select" style="max-width: 200px;">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                    <option value="revisado" {{ request('estado') === 'revisado' ? 'selected' : '' }}>Revisados</option>
                    <option value="rechazado" {{ request('estado') === 'rechazado' ? 'selected' : '' }}>Rechazados</option>
                </select>
                <button type="submit" class="create-btn" style="background-color: #3498db;">Filtrar</button>
                <a href="{{ route('admin.denuncias.index') }}" class="create-btn" style="background-color: #95a5a6;">Limpiar</a>
            </form>
        </div>

        <!-- Lista de denuncias -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @if($denuncias->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reportado por</th>
                            <th>Valoración</th>
                            <th>Autor Original</th>
                            <th>Restaurante</th>
                            <th>Razón</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denuncias as $denuncia)
                            <tr>
                                <td><strong>#{{ $denuncia->id }}</strong></td>
                                <td>
                                    <div style="font-size: 14px;">
                                        {{ $denuncia->usuario->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <strong>{{ $denuncia->valoracion->puntuacion ?? 0 }}/5</strong>
                                        @if($denuncia->valoracion)
                                            - {{ Str::limit($denuncia->valoracion->comentario, 30) }}
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 14px;">
                                        {{ $denuncia->valoracion->usuario->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 14px;">
                                        {{ $denuncia->valoracion->restaurante->nombre ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 13px; max-width: 150px;">
                                        {{ Str::limit($denuncia->razon, 50) }}
                                    </div>
                                </td>
                                <td>
                                    @if($denuncia->estado === 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($denuncia->estado === 'revisado')
                                        <span class="badge bg-success">Revisado</span>
                                    @else
                                        <span class="badge bg-secondary">Rechazado</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $denuncia->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.denuncias.revisar', $denuncia->id) }}" class="btn btn-sm btn-primary">
                                        Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div style="margin-top: 20px;">
                    {{ $denuncias->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #999;">
                    <p style="font-size: 18px;">No hay reportes de valoraciones</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
