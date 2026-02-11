<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/restaurante-detalle.css') }}">
    <title>{{ $restaurante->nombre }} - Guía Repsol</title>
</head>
<body>
    <!-- Header -->
    <header class="header-detalle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn-menu-detalle">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col">
                    <a href="{{ route('restaurantes') }}">
                        <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-detalle">
                    </a>
                </div>
                <div class="col-auto">
                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-acceso-detalle">
                                <i class="bi bi-person"></i> Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-acceso-detalle">
                            <i class="bi bi-person"></i> Acceso
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Gala -->
    <div class="banner-gala-detalle">
        <div class="container">
            <div class="gala-content">
                <div class="gala-left">
                    <div class="gala-icons">
                        <span class="icon-sol red"></span>
                        <span class="icon-sol yellow"></span>
                        <span class="icon-sol green"></span>
                    </div>
                    <span class="gala-text">Vive la Gala de los Soles 2024</span>
                    <span class="gala-date">4d : 3h : 26m : 14s</span>
                </div>
                <div class="gala-right">
                    <div class="gala-links">
                        <a href="#">Todo sobre la Gala</a>
                    </div>
                    <a href="#" class="btn-calendar">
                        <i class="bi bi-calendar-plus"></i> Añadir al calendario
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes de éxito o error -->
    @if(session('success'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endif

    <!-- Contenido Principal -->
    <div class="main-detalle">
        <div class="container">
            <div class="row">
                <!-- Columna Izquierda - Información del Restaurante -->
                <div class="col-lg-5">
                    <!-- Info Principal -->
                    <div class="restaurant-info-box">
                        @if($restaurante->soles > 0)
                        <div class="mb-3">
                            @for($i = 0; $i < $restaurante->soles; $i++)
                                <i class="bi bi-sun-fill" style="color: #f7931e; font-size: 28px;"></i>
                            @endfor
                        </div>
                        @endif

                        <p class="fecha-publicacion">Sábado de Verano 2021</p>
                        <h1 class="restaurant-name-title">{{ $restaurante->nombre }}</h1>
                        
                        <p class="restaurant-ubicacion">
                            <i class="bi bi-geo-alt"></i> {{ $restaurante->direccion }}, {{ $restaurante->ubicacion->codigo_postal }} {{ $restaurante->ubicacion->ciudad }}
                        </p>

                        <div class="restaurant-tipo">
                            <span class="tipo-badge">{{ $restaurante->ubicacion->ciudad }}</span>
                            <span class="tipo-badge">{{ $restaurante->ubicacion->provincia }}</span>
                            <span class="tipo-badge">{{ $restaurante->categoria->nombre }}</span>
                            @foreach($restaurante->tiposComida as $tipo)
                                <span class="tipo-badge">{{ $tipo->nombre }}</span>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <button class="btn-guardar">
                                <i class="bi bi-bookmark"></i> Guardar
                            </button>
                            <button class="btn-compartir">
                                <i class="bi bi-share"></i>
                            </button>
                            <button class="btn-favorito">
                                <i class="bi bi-heart"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($restaurante->descripcion)
                    <div class="section-box">
                        <p>{{ $restaurante->descripcion }}</p>
                    </div>
                    @endif

                    <!-- Reseñas -->
                    @if($restaurante->valoraciones->count() > 0)
                    <div class="section-box">
                        @foreach($restaurante->valoraciones->take(2) as $valoracion)
                        <div class="resena-item">
                            <div class="resena-icon">"</div>
                            <p class="resena-text">{{ $valoracion->comentario }}</p>
                            <div class="resena-buttons">
                                <button class="btn-guardar-sm">
                                    <i class="bi bi-bookmark"></i> Guardar
                                </button>
                                <button class="btn-compartir">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="btn-favorito">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <!-- Opciones de menú -->
                    <div class="section-box">
                        <h3 class="section-title">Opciones de menú</h3>
                        
                        <div class="opciones-menu-item">
                            <div class="menu-titulo">
                                <i class="bi bi-cup-straw"></i>
                                Opciones para celíacos
                            </div>
                        </div>

                        <div class="opciones-menu-item">
                            <div class="menu-titulo">
                                <i class="bi bi-leaf"></i>
                                Opciones veganas
                            </div>
                        </div>

                        <div class="opciones-menu-item">
                            <div class="menu-titulo">
                                <i class="bi bi-star"></i>
                                Nuestra recomendación
                            </div>
                            <p class="menu-descripcion">Excelente producto local con innovación culinaria.</p>
                        </div>
                    </div>

                    <!-- Servicios -->
                    <div class="section-box">
                        <h3 class="section-title">Servicios del restaurante</h3>
                        <div class="servicio-item">
                            <i class="bi bi-clock servicio-icon"></i>
                            <span>Comida para llevar</span>
                        </div>
                    </div>

                    <!-- Información de contacto -->
                    <div class="section-box">
                        <h3 class="section-title">Información de contacto</h3>
                        
                        <div class="contacto-item">
                            <div class="contacto-label">Horario</div>
                            <div class="horario-toggle">
                                <div class="horario-status">Abierto <span class="horario-separator">·</span> Cierra a las 16:00h.</div>
                                <i class="bi bi-chevron-down horario-icon"></i>
                            </div>
                            
                            <div class="horario-detalle-list" id="horarioDetalle" style="display: none;">
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Lunes</div>
                                    <div class="horario-horas cerrado">Cerrado</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Martes</div>
                                    <div class="horario-horas">13:00 - 16:00, 20:00 - 00:00</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Miércoles</div>
                                    <div class="horario-horas">13:00 - 16:00, 20:00 - 00:00</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Jueves</div>
                                    <div class="horario-horas">13:00 - 16:00, 20:00 - 00:00</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Viernes</div>
                                    <div class="horario-horas">13:00 - 16:00, 20:00 - 00:00</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Sábado</div>
                                    <div class="horario-horas">13:00 - 16:30, 20:00 - 00:00</div>
                                </div>
                                <div class="horario-dia-item">
                                    <div class="horario-dia">Domingo</div>
                                    <div class="horario-horas">13:00 - 16:00</div>
                                </div>
                            </div>
                        </div>

                        <div class="contacto-item">
                            <div class="contacto-label">Dirección:</div>
                            <div class="contacto-valor">{{ $restaurante->direccion }}, {{ $restaurante->ubicacion->codigo_postal }} {{ $restaurante->ubicacion->ciudad }}</div>
                            <button class="btn-contacto">Cómo llegar</button>
                        </div>

                        @if($restaurante->telefono)
                        <div class="contacto-item">
                            <div class="contacto-label">Teléfono:</div>
                            <div class="contacto-valor">{{ $restaurante->telefono }}</div>
                            <button class="btn-contacto">Llamar</button>
                        </div>
                        @endif

                        @if($restaurante->web)
                        <div class="contacto-item">
                            <div class="contacto-label">Web:</div>
                            <div class="contacto-valor">{{ $restaurante->web }}</div>
                            <button class="btn-contacto">Ver web</button>
                        </div>
                        @endif

                        <div class="contacto-item">
                            <div class="contacto-label">Instagram:</div>
                            <div class="contacto-valor">{{ '@' . strtolower(str_replace(' ', '', $restaurante->nombre)) }}</div>
                            <button class="btn-contacto">Ver Instagram</button>
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="section-box">
                        <h3 class="section-title">Ubicación</h3>
                        <div class="mapa-container">
                            <div class="mapa-placeholder">
                                <i class="bi bi-geo-alt" style="font-size: 48px;"></i>
                            </div>
                        </div>
                        <button class="btn-contacto mt-3">Explorar sitios cerca</button>
                    </div>

                    <!-- Sitios de interés cercanos -->
                    <div class="section-box">
                        <h3 class="section-title">Sitios de interés cercanos</h3>
                        <div class="sitios-grid">
                            <div class="sitio-item">
                                <div class="sitio-icon">🏛️</div>
                                <div class="sitio-info">
                                    <h4>Faro de Moncloa</h4>
                                    <p>Madrid, Madrid</p>
                                </div>
                            </div>
                            <div class="sitio-item">
                                <div class="sitio-icon">🏰</div>
                                <div class="sitio-info">
                                    <h4>Plaza de España</h4>
                                    <p>Madrid, Madrid</p>
                                </div>
                            </div>
                            <div class="sitio-item">
                                <div class="sitio-icon">☀️</div>
                                <div class="sitio-info">
                                    <h4>Calle Preciados</h4>
                                    <p>Madrid, Madrid</p>
                                </div>
                            </div>
                            <div class="sitio-item">
                                <div class="sitio-icon">🌊</div>
                                <div class="sitio-info">
                                    <h4>Plaza de Oriente</h4>
                                    <p>Madrid, Madrid</p>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="d-block mt-3" style="color: #00a3e0;">Ver más en el mapa →</a>
                    </div>
                </div>

                <!-- Columna Derecha - Imágenes y Reservas -->
                <div class="col-lg-7">
                    <!-- Imagen Principal -->
                    <div class="image-container">
                        <img src="https://picsum.photos/800/600?random={{ $restaurante->id }}" 
                             alt="{{ $restaurante->nombre }}" 
                             class="restaurant-image-main">
                        <button class="btn-ver-fotos">
                            <i class="bi bi-images"></i> Mostrar todas las fotos
                        </button>
                    </div>

                    <!-- Reserva -->
                    <div class="reserva-box">
                        <h3 class="reserva-title">Reserva una mesa</h3>
                        <button class="btn-reserva">
                            <i class="bi bi-clipboard-check"></i> Mostrar todas las fotos
                        </button>
                        <button class="btn-reserva">
                            <i class="bi bi-calendar-check"></i> Reservar
                        </button>
                        <p class="reserva-info">
                            La reserva se realizará en otro sitio web distinto a Guía Repsol
                        </p>
                    </div>

                    <!-- Reportajes Relacionados -->
                    <div class="section-box">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title mb-0">Valoraciones de usuarios</h3>
                            @auth
                                @php
                                    $miValoracion = $restaurante->valoraciones->where('usuario_id', Auth::id())->first();
                                @endphp
                                @if(!$miValoracion)
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAgregarValoracion">
                                        <i class="bi bi-plus-circle"></i> Añadir reseña
                                    </button>
                                @endif
                            @endauth
                        </div>
                        
                        @forelse($restaurante->valoraciones as $valoracion)
                        <div class="reportaje-item">
                            <div class="reportaje-content" style="width: 100%;">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-person-circle" style="font-size: 40px; color: #00a3e0; margin-right: 15px;"></i>
                                    <div style="flex-grow: 1;">
                                        <h4 class="reportaje-titulo mb-0">{{ $valoracion->usuario->name }}</h4>
                                        <div class="mt-1">
                                            @for($i = 0; $i < $valoracion->puntuacion; $i++)
                                                <i class="bi bi-star-fill" style="color: #ffc107; font-size: 14px;"></i>
                                            @endfor
                                            @for($i = $valoracion->puntuacion; $i < 5; $i++)
                                                <i class="bi bi-star" style="color: #ffc107; font-size: 14px;"></i>
                                            @endfor
                                            <span style="font-size: 12px; color: #666; margin-left: 5px;">{{ $valoracion->puntuacion }}/5</span>
                                        </div>
                                    </div>
                                    @auth
                                        @if($valoracion->usuario_id === Auth::id())
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarValoracion{{ $valoracion->id }}">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                        @elseif($restaurante->user_id === Auth::id())
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalResponderValoracion{{ $valoracion->id }}">
                                                <i class="bi bi-reply"></i> Responder
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                                <p class="reportaje-subtitulo mb-0">{{ $valoracion->comentario }}</p>
                                <p style="font-size: 11px; color: #999; margin-top: 8px;">{{ $valoracion->created_at->format('d/m/Y') }}</p>
                                
                                @if($valoracion->respuesta_gerente)
                                    <div class="mt-3 p-3" style="background-color: #f8f9fa; border-left: 3px solid #00a3e0; border-radius: 4px;">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-building" style="font-size: 24px; color: #00a3e0; margin-right: 10px;"></i>
                                                <div>
                                                    <strong style="color: #00a3e0;">{{ $restaurante->gerente->name }}</strong>
                                                    <p class="mb-0" style="font-size: 12px; color: #666;">Gerente de {{ $restaurante->nombre }}</p>
                                                </div>
                                            </div>
                                            @auth
                                                @if($restaurante->user_id === Auth::id())
                                                    <div>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarRespuesta{{ $valoracion->id }}">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarRespuesta{{ $valoracion->id }}">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endauth
                                        </div>
                                        <p class="mb-0" style="font-size: 14px;">{{ $valoracion->respuesta_gerente }}</p>
                                        <p style="font-size: 11px; color: #999; margin-top: 5px;">{{ $valoracion->fecha_respuesta ? $valoracion->fecha_respuesta->format('d/m/Y') : '' }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Modal Editar Reseña -->
                        @auth
                        @if($valoracion->usuario_id === Auth::id())
                        <div class="modal fade" id="modalEditarValoracion{{ $valoracion->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar mi reseña</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form id="form-editar-valoracion-{{ $valoracion->id }}">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">¿Cómo valoras tu experiencia?</label>
                                                <input type="hidden" name="puntuacion" id="puntuacion-edit-{{ $valoracion->id }}" value="{{ $valoracion->puntuacion }}" required>
                                                <div class="rating-stars" data-modal-id="{{ $valoracion->id }}" data-current-rating="{{ $valoracion->puntuacion }}">
                                                    @for($i = 1; $i <= 5; $i++)
                                                    <div class="star {{ $i <= $valoracion->puntuacion ? 'active' : '' }}" data-value="{{ $i }}">
                                                        <i class="bi bi-star-fill"></i>
                                                    </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Comentario</label>
                                                <textarea name="comentario" class="form-control" rows="4" required>{{ $valoracion->comentario }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-danger btn-eliminar-valoracion" data-valoracion-id="{{ $valoracion->id }}">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                            <div>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-primary btn-guardar-valoracion" data-valoracion-id="{{ $valoracion->id }}" data-restaurante-id="{{ $restaurante->id }}">Guardar cambios</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endauth

                        <!-- Modal Responder Reseña (Solo Gerente) -->
                        @auth
                        @if($restaurante->user_id === Auth::id())
                        <div class="modal fade" id="modalResponderValoracion{{ $valoracion->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Responder a {{ $valoracion->usuario->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('valoracion.responder', $valoracion->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tu respuesta</label>
                                                <textarea name="respuesta_gerente" class="form-control" rows="4" required placeholder="Escribe tu respuesta...">{{ $valoracion->respuesta_gerente }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Enviar respuesta</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Editar Respuesta -->
                        <div class="modal fade" id="modalEditarRespuesta{{ $valoracion->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Respuesta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('valoracion.responder', $valoracion->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Tu respuesta</label>
                                                <textarea name="respuesta_gerente" class="form-control" rows="4" required>{{ $valoracion->respuesta_gerente }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Actualizar respuesta</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Eliminar Respuesta -->
                        <div class="modal fade" id="modalEliminarRespuesta{{ $valoracion->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Eliminar Respuesta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas eliminar tu respuesta?</p>
                                        <div class="alert alert-warning">
                                            <i class="bi bi-exclamation-triangle"></i> Esta acción no se puede deshacer.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('valoracion.eliminarRespuesta', $valoracion->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar respuesta</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endauth

                        @empty
                        <p class="text-muted text-center">No hay valoraciones aún.</p>
                        @endforelse
                    </div>

                    <!-- Modal Agregar Nueva Reseña -->
                    @auth
                    @php
                        $miValoracion = $restaurante->valoraciones->where('usuario_id', Auth::id())->first();
                    @endphp
                    @if(!$miValoracion)
                    <div class="modal fade" id="modalAgregarValoracion" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Añadir reseña</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('valoracion.store', $restaurante->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">¿Cómo valoras tu experiencia?</label>
                                            <input type="hidden" name="puntuacion" id="puntuacion" required>
                                            <div class="rating-stars">
                                                <div class="star" data-value="1">
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="star" data-value="2">
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="star" data-value="3">
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="star" data-value="4">
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                                <div class="star" data-value="5">
                                                    <i class="bi bi-star-fill"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Comentario</label>
                                            <textarea name="comentario" class="form-control" rows="4" required placeholder="Comparte tu experiencia..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Publicar reseña</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Script personalizado -->
    <script src="{{ asset('js/restaurante-detalle.js') }}"></script>
</body>
</html>

