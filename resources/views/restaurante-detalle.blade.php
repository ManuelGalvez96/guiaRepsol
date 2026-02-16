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
    @php
        use Illuminate\Support\Facades\File;
        use Illuminate\Support\Str;

        $stopwords = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'the', 'restaurante', 'restaurant', 'l'];

        $normalizeRestauranteName = function (string $value) use ($stopwords): string {
            $asciiValue = Str::ascii($value);
            $cleanValue = preg_replace('/[^a-zA-Z0-9]+/', ' ', $asciiValue) ?? '';
            $tokens = array_filter(explode(' ', strtolower($cleanValue)));
            $tokens = array_values(array_filter($tokens, fn ($token) => !in_array($token, $stopwords, true)));

            return implode('', $tokens);
        };

        $restauranteImageMap = [];
        foreach (File::files(public_path('img/restaurantes')) as $file) {
            $baseName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $key = $normalizeRestauranteName($baseName);
            if ($key !== '') {
                $restauranteImageMap[$key] = 'img/restaurantes/' . $file->getFilename();
            }
        }

        $resolveRestauranteImage = function (string $nombre) use ($normalizeRestauranteName, $restauranteImageMap): string {
            $key = $normalizeRestauranteName($nombre);

            return $restauranteImageMap[$key] ?? 'img/restaurantes/emigrante.webp';
        };
    @endphp
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

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <div class="container">
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes') }}"><i class="bi bi-list-ul"></i> Listado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="bi bi-info-circle"></i> Información</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i> Guardados</a>
                </li>
            </ul>
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
                            <button class="btn-guardar {{ $userHasSaved ? 'active' : '' }}" 
                                    id="btn-guardar" 
                                    data-restaurante-id="{{ $restaurante->id }}">
                                <i class="bi bi-bookmark{{ $userHasSaved ? '-fill' : '' }}"></i> Guardar
                            </button>
                            <button class="btn-favorito {{ $userHasLiked ? 'active' : '' }}" 
                                    id="btn-favorito" 
                                    data-restaurante-id="{{ $restaurante->id }}">
                                <i class="bi bi-heart{{ $userHasLiked ? '-fill' : '' }}"></i>
                                <span id="like-count">{{ $totalLikes }}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Descripción -->
                    @if($restaurante->descripcion)
                    <div class="section-box">
                        <p>{{ $restaurante->descripcion }}</p>
                    </div>
                    @endif

                    <!-- Opciones de menú, Servicios e Información de contacto (Acordeón) -->
                    <div class="section-box">
                        <div class="accordion" id="accordionOpcionesServicios">
                            <!-- Opciones de menú -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOpciones">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOpciones" aria-expanded="true" aria-controls="collapseOpciones">
                                        <i class="bi bi-cup-straw me-2"></i> Opciones de menú
                                    </button>
                                </h2>
                                <div id="collapseOpciones" class="accordion-collapse collapse show" aria-labelledby="headingOpciones" data-bs-parent="#accordionOpcionesServicios">
                                    <div class="accordion-body">
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
                                </div>
                            </div>
                            <!-- Servicios -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingServicios">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServicios" aria-expanded="false" aria-controls="collapseServicios">
                                        <i class="bi bi-gear me-2"></i> Servicios del restaurante
                                    </button>
                                </h2>
                                <div id="collapseServicios" class="accordion-collapse collapse" aria-labelledby="headingServicios" data-bs-parent="#accordionOpcionesServicios">
                                    <div class="accordion-body">
                                        <div class="servicio-item">
                                            <i class="bi bi-clock servicio-icon"></i>
                                            <span>Comida para llevar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Información de contacto -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingContacto">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto">
                                        <i class="bi bi-telephone me-2"></i> Información de contacto
                                    </button>
                                </h2>
                                <div id="collapseContacto" class="accordion-collapse collapse" aria-labelledby="headingContacto" data-bs-parent="#accordionOpcionesServicios">
                                    <div class="accordion-body">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Call to Action - Da a conocer tu negocio -->
                    <div class="section-box cta-box">
                        <div class="cta-content">
                            <div class="cta-icon">
                                <i class="bi bi-shop" style="font-size: 64px; color: #00a3e0;"></i>
                            </div>
                            <h3 class="cta-title">Da a conocer tu negocio</h3>
                            <p class="cta-description">
                                ¿Eres dueño de un restaurante? Regístralo en la Guía Repsol y llega a miles de clientes que buscan experiencias gastronómicas únicas.
                            </p>
                            <a href="{{ route('formulario') }}" class="btn-cta">
                                Registrar mi restaurante
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Imágenes y Reservas -->
                <div class="col-lg-7">
                    <!-- Carousel de Imágenes -->
                    <div id="carouselRestaurante" class="carousel slide mb-4" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @if($restaurante->imagenes->isNotEmpty())
                                @foreach($restaurante->imagenes as $index => $imagen)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($imagen->url) }}" class="d-block w-100" alt="{{ $imagen->alt ?? $restaurante->nombre }}" style="height: 400px; object-fit: cover; border-radius: 8px;">
                                </div>
                                @endforeach
                            @else
                                <div class="carousel-item active">
                                    <img src="{{ asset($resolveRestauranteImage($restaurante->nombre)) }}" class="d-block w-100" alt="{{ $restaurante->nombre }}" style="height: 400px; object-fit: cover; border-radius: 8px;">
                                </div>
                            @endif
                        </div>
                        @if($restaurante->imagenes->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRestaurante" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselRestaurante" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                        <div class="carousel-indicators">
                            @foreach($restaurante->imagenes as $index => $imagen)
                            <button type="button" data-bs-target="#carouselRestaurante" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        @endif
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

    <!-- Modal Galería de Imágenes -->
    <div class="modal fade" id="modalGaleria" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Galería de {{ $restaurante->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="carouselGaleria" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach($restaurante->imagenes as $index => $imagen)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset($imagen->url) }}" 
                                         class="d-block w-100" 
                                         alt="{{ $restaurante->nombre }} - Imagen {{ $index + 1 }}"
                                         style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if($restaurante->imagenes->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleria" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleria" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                        <div class="carousel-indicators">
                            @foreach($restaurante->imagenes as $index => $imagen)
                                <button type="button" data-bs-target="#carouselGaleria" data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}"></button>
                            @endforeach
                        </div>
                    </div>
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

