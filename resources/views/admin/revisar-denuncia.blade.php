<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Revisar Reporte - Panel de Administración</title>
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
            <h1>📋 Revisar Reporte</h1>
            <a href="{{ route('admin.denuncias.index') }}" class="create-btn">Volver a Reportes</a>
        </div>

        <!-- Información del reporte -->
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                <!-- Información del reporte -->
                <div>
                    <h3 style="margin-bottom: 20px; border-bottom: 2px solid #3498db; padding-bottom: 10px;">Información del Reporte</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: bold; color: #555;">ID del Reporte:</label>
                        <p style="margin: 5px 0;">{{ $denuncia->id }}</p>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: bold; color: #555;">Reportado por:</label>
                        <p style="margin: 5px 0;">{{ $denuncia->usuario->name }} {{ $denuncia->usuario->apellidos }}</p>
                        <small style="color: #999;">{{ $denuncia->usuario->email }}</small>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: bold; color: #555;">Razón del Reporte:</label>
                        <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin: 5px 0;">
                            {{ $denuncia->razon }}
                        </div>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: bold; color: #555;">Fecha del Reporte:</label>
                        <p style="margin: 5px 0;">{{ $denuncia->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: bold; color: #555;">Estado:</label>
                        <p style="margin: 5px 0;">
                            @if($denuncia->estado === 'pendiente')
                                <span class="badge bg-warning text-dark">Pendiente de Revisión</span>
                            @elseif($denuncia->estado === 'revisado')
                                <span class="badge bg-success">Revisado - Valoración Eliminada</span>
                            @else
                                <span class="badge bg-secondary">Rechazado</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Información de la valoración -->
                <div>
                    <h3 style="margin-bottom: 20px; border-bottom: 2px solid #f39c12; padding-bottom: 10px;">Valoración Reportada</h3>
                    
                    @if($denuncia->valoracion)
                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555;">Puntuación:</label>
                            <p style="margin: 5px 0; font-size: 24px; color: #f39c12;">⭐ {{ $denuncia->valoracion->puntuacion }}/5</p>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555;">Autor:</label>
                            <p style="margin: 5px 0;">{{ $denuncia->valoracion->usuario->name }} {{ $denuncia->valoracion->usuario->apellidos }}</p>
                            <small style="color: #999;">{{ $denuncia->valoracion->usuario->email }}</small>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555;">Restaurante:</label>
                            <p style="margin: 5px 0;">{{ $denuncia->valoracion->restaurante->nombre }}</p>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555;">Comentario:</label>
                            <div style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin: 5px 0;">
                                {{ $denuncia->valoracion->comentario }}
                            </div>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-weight: bold; color: #555;">Fecha:</label>
                            <p style="margin: 5px 0;">{{ $denuncia->valoracion->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    @else
                        <div style="padding: 20px; background: #fee; border-radius: 6px; color: #c33;">
                            ⚠️ La valoración ha sido eliminada
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones -->
            @if($denuncia->estado === 'pendiente')
                <div style="margin-top: 30px; padding-top: 30px; border-top: 1px solid #eee; display: flex; gap: 10px;">
                    <button type="button" class="create-btn" style="background-color: #27ae60; flex: 1;" onclick="resolverDenuncia('aceptar')">
                        ✓ Aceptar Reporte (Eliminar Valoración)
                    </button>
                    <button type="button" class="create-btn" style="background-color: #e74c3c; flex: 1;" onclick="resolverDenuncia('rechazar')">
                        ✗ Rechazar Reporte
                    </button>
                </div>
            @else
                <div style="margin-top: 30px; padding: 15px; background: #e8f4f8; border-radius: 6px; border-left: 4px solid #3498db;">
                    <p style="margin: 0; color: #555;">
                        <strong>Este reporte ya ha sido resuelto.</strong> 
                        Estado: {{ $denuncia->estado === 'revisado' ? 'Aceptado' : 'Rechazado' }}
                    </p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function resolverDenuncia(accion) {
            const mensaje = accion === 'aceptar' 
                ? '¿Estás seguro de que deseas aceptar este reporte? La valoración será eliminada.'
                : '¿Estás seguro de que deseas rechazar este reporte?';

            Swal.fire({
                title: '¿Confirmar acción?',
                text: mensaje,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: accion === 'aceptar' ? '#27ae60' : '#e74c3c'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch('{{ route("admin.denuncias.resolver", $denuncia->id) }}', {
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
                                window.location.href = '{{ route("admin.denuncias.index") }}';
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
