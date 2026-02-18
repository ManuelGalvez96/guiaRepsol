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
        <div class="top-section" style="flex-direction: column; align-items: center; gap: 15px;">
            <h1>Dashboard de Administración</h1>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <a href="{{ route('admin.index') }}" class="create-btn">Gestión de Restaurantes</a>
                <a href="{{ route('admin.solicitudes') }}" class="create-btn">Solicitudes de Negocio</a>
                <a href="{{ route('admin.usuarios.index') }}" class="create-btn">Gestión de Usuarios</a>
                <a href="{{ route('admin.denuncias.index') }}" class="create-btn">Reportes de Valoraciones</a>
                <a href="{{ route('admin.solicitudes-eliminacion.index') }}" class="create-btn">Solicitudes Eliminación</a>
            </div>
        </div>

        <!-- Estadísticas generales -->
        <div class="table-container" style="margin-bottom: 20px;">
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center;">Restaurantes Activos</th>
                        <th style="text-align: center;">Solicitudes Pendientes</th>
                        <th style="text-align: center;">Total Valoraciones</th>
                        <th style="text-align: center;">Usuarios Registrados</th>
                        <th style="text-align: center;">Restaurantes Rechazados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center;"><strong style="font-size: 28px;">{{ $totalRestaurantes }}</strong></td>
                        <td style="text-align: center;"><strong style="font-size: 28px;">{{ $restaurantesPendientes }}</strong></td>
                        <td style="text-align: center;"><strong style="font-size: 28px;">{{ $totalValoraciones }}</strong></td>
                        <td style="text-align: center;"><strong style="font-size: 28px;">{{ $totalUsuarios }}</strong></td>
                        <td style="text-align: center;"><strong style="font-size: 28px;">{{ $restaurantesRechazados }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Top 5 Restaurantes Mejor Valorados -->
        <h2 style="font-size: 18px; margin-bottom: 15px;">Top 5 Restaurantes Mejor Valorados</h2>
        <div class="table-container" style="margin-bottom: 30px;">
            @if($mejoresRestaurantes->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Ciudad</th>
                            <th>Valoración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mejoresRestaurantes as $restaurante)
                            <tr>
                                <td>
                                    @if($restaurante->imagenes->first())
                                        <img src="{{ asset($restaurante->imagenes->first()->url) }}" alt="{{ $restaurante->nombre }}" class="restaurant-img">
                                    @else
                                        <div class="restaurant-img"></div>
                                    @endif
                                </td>
                                <td><strong>{{ $restaurante->nombre }}</strong></td>
                                <td>{{ $restaurante->ubicacion->ciudad ?? '-' }}</td>
                                <td><strong style="color: #f39c12;">{{ number_format($restaurante->valoracion_promedio, 1) }} ★</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 30px;">No hay restaurantes disponibles</p>
            @endif
        </div>

        <!-- Últimas Valoraciones -->
        <h2 style="font-size: 18px; margin-bottom: 15px;">Últimas Valoraciones</h2>
        <div class="table-container">
            @if($ultimasValoraciones->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Restaurante</th>
                            <th>Puntuación</th>
                            <th>Comentario</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ultimasValoraciones as $valoracion)
                            <tr>
                                <td><strong>{{ $valoracion->usuario_nombre }}</strong></td>
                                <td>{{ $valoracion->restaurante_nombre }}</td>
                                <td>
                                    @for($i = 1; $i <= 5; $i++)
                                        <span style="color: {{ $i <= $valoracion->puntuacion ? '#f39c12' : '#ddd' }};">★</span>
                                    @endfor
                                </td>
                                <td>{{ $valoracion->comentario ? Str::limit($valoracion->comentario, 100) : '-' }}</td>
                                <td><small style="color: #999;">{{ \Carbon\Carbon::parse($valoracion->created_at)->diffForHumans() }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: #999; padding: 30px;">No hay valoraciones disponibles</p>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/admin_js/admin_dashboard.js') }}"></script>
</body>

</html>
