<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
                    <a href="{{ route('login') }}" class="btn-acceso-detalle">
                        <i class="bi bi-person"></i> Acceso
                    </a>
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
                    @if($restaurante->resenas->count() > 0)
                    <div class="section-box">
                        @foreach($restaurante->resenas->take(2) as $resena)
                        <div class="resena-item">
                            <div class="resena-icon">"</div>
                            <p class="resena-text">{{ $resena->comentario }}</p>
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
                            <div class="contacto-label">Horario:</div>
                            <div class="contacto-valor">Abierto · Cierra a las 16:00h</div>
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
                        <h3 class="section-title">Reportajes relacionados</h3>
                        
                        <div class="reportaje-item">
                            <img src="https://picsum.photos/120/90?random=101" alt="Reportaje" class="reportaje-image">
                            <div class="reportaje-content">
                                <p class="reportaje-tipo">📰 Reportaje gastronómico</p>
                                <h4 class="reportaje-titulo">Sabores para celebrar con los amigos</h4>
                                <p class="reportaje-subtitulo">10 destinos, 100 sabores - {{ $restaurante->ubicacion->ciudad }}</p>
                            </div>
                        </div>

                        <div class="reportaje-item">
                            <img src="https://picsum.photos/120/90?random=102" alt="Reportaje" class="reportaje-image">
                            <div class="reportaje-content">
                                <p class="reportaje-tipo">📰 Reportaje gastronómico</p>
                                <h4 class="reportaje-titulo">Buscando Solex: Guía de {{ $restaurante->ubicacion->ciudad }} para el invierno</h4>
                                <p class="reportaje-subtitulo">{{ ucfirst($restaurante->categoria->nombre) }}, Guía de Solex en {{ $restaurante->ubicacion->ciudad }}</p>
                            </div>
                        </div>

                        <div class="reportaje-item">
                            <img src="https://picsum.photos/120/90?random=103" alt="Reportaje" class="reportaje-image">
                            <div class="reportaje-content">
                                <p class="reportaje-tipo">📰 Reportaje gastronómico</p>
                                <h4 class="reportaje-titulo">Los tesoros de Ricardo Sanz para el invierno</h4>
                                <p class="reportaje-subtitulo">La estrella, Un Cuber Travel en {{ $restaurante->ubicacion->ciudad }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
