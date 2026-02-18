<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Panel de Administración</title>
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
            <h1>Dashboard de Administración</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.index') }}" class="create-btn" style="background-color: #3498db;">Gestión de Restaurantes</a>
                <a href="{{ route('admin.solicitudes') }}" class="create-btn" style="background-color: #f39c12;">Solicitudes de Negocio</a>
                <a href="{{ route('admin.usuarios.index') }}" class="create-btn" style="background-color: #27ae60;">👥 Gestión de Usuarios</a>
            </div>
        </div>

        <!-- Estadísticas generales -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin: 30px 0;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; border-radius: 10px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; font-size: 16px; opacity: 0.9;">Restaurantes Activos</h3>
                <p style="font-size: 36px; font-weight: bold; margin: 0;">{{ $totalRestaurantes }}</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 25px; border-radius: 10px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; font-size: 16px; opacity: 0.9;">Solicitudes Pendientes</h3>
                <p style="font-size: 36px; font-weight: bold; margin: 0;">{{ $restaurantesPendientes }}</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 25px; border-radius: 10px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; font-size: 16px; opacity: 0.9;">Total Valoraciones</h3>
                <p style="font-size: 36px; font-weight: bold; margin: 0;">{{ $totalValoraciones }}</p>
            </div>
            
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 25px; border-radius: 10px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; font-size: 16px; opacity: 0.9;">Usuarios Registrados</h3>
                <p style="font-size: 36px; font-weight: bold; margin: 0;">{{ $totalUsuarios }}</p>
            </div>

            <div style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%); padding: 25px; border-radius: 10px; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; font-size: 16px; opacity: 0.9;">Restaurantes Rechazados</h3>
                <p style="font-size: 36px; font-weight: bold; margin: 0;">{{ $restaurantesRechazados }}</p>
            </div>
        </div>

        <!-- Mejores restaurantes -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 30px;">
            <h2 style="margin: 0 0 20px 0; padding-bottom: 15px; border-bottom: 2px solid #f39c12;">⭐ Top 5 Restaurantes Mejor Valorados</h2>
            
            @if($mejoresRestaurantes->count() > 0)
                <div style="display: grid; gap: 15px;">
                    @foreach($mejoresRestaurantes as $restaurante)
                        <div style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f8f9fa; border-radius: 6px; transition: transform 0.2s;">
                            @if($restaurante->imagenes->first())
                                <img src="{{ asset($restaurante->imagenes->first()->url) }}" alt="{{ $restaurante->nombre }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px;">
                            @else
                                <div style="width: 80px; height: 80px; background: #ddd; border-radius: 6px;"></div>
                            @endif
                            
                            <div style="flex: 1;">
                                <h3 style="margin: 0 0 5px 0; font-size: 18px;">{{ $restaurante->nombre }}</h3>
                                <p style="margin: 0; color: #666; font-size: 14px;">{{ $restaurante->ubicacion->ciudad ?? '' }}</p>
                            </div>
                            
                            <div style="text-align: center;">
                                <div style="font-size: 24px; font-weight: bold; color: #f39c12;">{{ number_format($restaurante->valoracion_promedio, 1) }}</div>
                                <div style="font-size: 12px; color: #666;">⭐ Valoración</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 30px;">No hay restaurantes disponibles</p>
            @endif
        </div>

        <!-- Últimas valoraciones -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2 style="margin: 0 0 20px 0; padding-bottom: 15px; border-bottom: 2px solid #3498db;">💬 Últimas Valoraciones</h2>
            
            @if($ultimasValoraciones->count() > 0)
                <div style="display: grid; gap: 15px;">
                    @foreach($ultimasValoraciones as $valoracion)
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 6px; border-left: 4px solid #3498db;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <div>
                                    <strong style="color: #2c3e50;">{{ $valoracion->usuario_nombre }}</strong>
                                    <span style="color: #999; font-size: 14px;"> valoró </span>
                                    <strong style="color: #f39c12;">{{ $valoracion->restaurante_nombre }}</strong>
                                </div>
                                <div style="display: flex; gap: 5px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color: {{ $i <= $valoracion->puntuacion ? '#f39c12' : '#ddd' }};">★</span>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($valoracion->comentario)
                                <p style="margin: 0; color: #555; font-size: 14px; line-height: 1.5;">{{ Str::limit($valoracion->comentario, 150) }}</p>
                            @endif
                            
                            <small style="color: #999; font-size: 12px; margin-top: 8px; display: block;">
                                {{ \Carbon\Carbon::parse($valoracion->created_at)->diffForHumans() }}
                            </small>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="text-align: center; color: #999; padding: 30px;">No hay valoraciones disponibles</p>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    
    <script>
        // Logout handler
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.querySelector('.logout-btn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: '¿Cerrar sesión?',
                        text: "¿Estás seguro de que quieres cerrar sesión?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#e74c3c',
                        cancelButtonColor: '#95a5a6',
                        confirmButtonText: 'Sí, cerrar sesión',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const logoutUrl = document.body.getAttribute('data-route-logout') || '/logout';
                            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            
                            fetch(logoutUrl, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                redirect: 'follow'
                            })
                            .then(response => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Sesión cerrada',
                                    text: 'Hasta la próxima',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '/';
                                });
                            })
                            .catch(error => {
                                console.error('Error al cerrar sesión:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Error al cerrar sesión'
                                }).then(() => {
                                    window.location.href = '/';
                                });
                            });
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>
