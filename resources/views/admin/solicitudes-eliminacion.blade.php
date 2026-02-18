<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Solicitudes de Eliminación - Panel de Administración</title>
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
            <h1>🗑️ Solicitudes de Eliminación de Restaurantes</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.dashboard') }}" class="create-btn">Volver al Dashboard</a>
                <a href="{{ route('admin.denuncias.index') }}" class="create-btn">Ver Reportes de Valoraciones</a>
            </div>
        </div>

        <!-- Filtros -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <form method="GET" style="display: flex; gap: 10px; flex-wrap: wrap;">
                <select name="estado" class="form-select" style="max-width: 200px;">
                    <option value="">Todos los estados</option>
                    <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendientes</option>
                    <option value="aceptada" {{ request('estado') === 'aceptada' ? 'selected' : '' }}>Aceptadas</option>
                    <option value="rechazada" {{ request('estado') === 'rechazada' ? 'selected' : '' }}>Rechazadas</option>
                </select>
                <button type="submit" class="create-btn" style="background-color: #3498db;">Filtrar</button>
                <a href="{{ route('admin.solicitudes-eliminacion.index') }}" class="create-btn" style="background-color: #95a5a6;">Limpiar</a>
            </form>
        </div>

        <!-- Lista de solicitudes -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @if($solicitudes->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Restaurante</th>
                            <th>Gerente</th>
                            <th>Razón</th>
                            <th>Estado</th>
                            <th>Responsable Admin</th>
                            <th>Fecha Solicitud</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes as $solicitud)
                            <tr>
                                <td><strong>#{{ $solicitud->id }}</strong></td>
                                <td>
                                    <div style="font-size: 14px;">
                                        {{ $solicitud->restaurante->nombre ?? 'Eliminado' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 14px;">
                                        {{ $solicitud->gerente->name }} {{ $solicitud->gerente->apellidos }}
                                    </div>
                                    <small style="color: #999;">{{ $solicitud->gerente->email }}</small>
                                </td>
                                <td>
                                    <div style="font-size: 13px; max-width: 150px;">
                                        {{ $solicitud->razon ? Str::limit($solicitud->razon, 50) : 'Sin especificar' }}
                                    </div>
                                </td>
                                <td>
                                    @if($solicitud->estado === 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($solicitud->estado === 'aceptada')
                                        <span class="badge bg-success">Aceptada</span>
                                    @else
                                        <span class="badge bg-danger">Rechazada</span>
                                    @endif
                                </td>
                                <td>
                                    @if($solicitud->admin)
                                        <small>{{ $solicitud->admin->name }}</small>
                                    @else
                                        <small style="color: #999;">-</small>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $solicitud->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td>
                                    @if($solicitud->estado === 'pendiente')
                                        <button type="button" class="btn btn-sm btn-success" onclick="responderSolicitud({{ $solicitud->id }}, 'aceptar')">
                                            Aceptar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="responderSolicitud({{ $solicitud->id }}, 'rechazar')">
                                            Rechazar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-secondary" disabled>
                                            Resuelta
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Paginación -->
                <div style="margin-top: 20px;">
                    {{ $solicitudes->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #999;">
                    <p style="font-size: 18px;">No hay solicitudes de eliminación</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function responderSolicitud(solicitudId, accion) {
            const mensaje = accion === 'aceptar' 
                ? '¿Estás seguro de que deseas aceptar esta solicitud? El restaurante será eliminado.'
                : '¿Estás seguro de que deseas rechazar esta solicitud?';

            Swal.fire({
                title: '¿Confirmar acción?',
                text: mensaje,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, confirmar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: accion === 'aceptar' ? '#27ae60' : '#e74c3c'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.solicitudes-eliminacion.responder", "") }}/' + solicitudId + '/responder', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ accion: accion })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('¡Éxito!', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.error || 'Ocurrió un error', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Error al procesar la solicitud', 'error');
                    });
                }
            });
        }
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
