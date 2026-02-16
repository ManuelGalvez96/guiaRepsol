<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/restaurantes.css') }}">
    <title>Guía Repsol - Restaurantes Guardados</title>
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
    <!-- Header Principal -->
    <header class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn-menu-detalle" id="btnToggleMenu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-img">
                </div>
                <div class="col">
                    <!--
                    <div class="search-bar">
                        <button class="btn-close-search" id="restaurant-search-clear">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <input type="text" class="search-input" id="restaurant-search-input" placeholder="Buscar">
                        <button class="btn-search-submit" id="restaurant-search-button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    -->
                </div>
                <div class="col-auto">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-acceso-detalle">
                            <i class="bi bi-person"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav">
            <li><a href="{{ route('home') }}"><i class="bi bi-house"></i> Inicio</a></li>
            <li><a href="{{ route('restaurantes') }}"><i class="bi bi-list-ul"></i> Listado</a></li>
            <li><a href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a></li>
            <li><a href="{{ route('restaurantes.guardados') }}" class="active"><i class="bi bi-bookmark-fill"></i> Guardados</a></li>
        </ul>
    </div>

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
                    <a class="nav-link" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i> Guardados</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <!-- Restaurantes Guardados -->
            <div class="content-section">
                <div class="section-header">
                    <div>
                        <h2>Tus Restaurantes Guardados</h2>
                        <span class="result-count">{{ $restaurantes->total() }} {{ $restaurantes->total() == 1 ? 'restaurante' : 'restaurantes' }}</span>
                    </div>
                    <div>
                        <form method="GET" action="{{ route('restaurantes.guardados') }}" id="formOrdenar">
                            <select name="ordenar" class="btn btn-sm btn-outline-secondary" onchange="document.getElementById('formOrdenar').submit()">
                                <option value="nombre" {{ request('ordenar') == 'nombre' ? 'selected' : '' }}>Nombre A-Z</option>
                                <option value="valoracion" {{ request('ordenar') == 'valoracion' ? 'selected' : '' }}>Mejor valorados</option>
                                <option value="soles" {{ request('ordenar') == 'soles' ? 'selected' : '' }}>Más Soles Repsol</option>
                                <option value="precio_asc" {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
                                <option value="precio_desc" {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
                            </select>
                        </form>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    @forelse($restaurantes as $restaurante)
                    <div class="col-md-3">
                        <a href="{{ route('restaurante.detalle', $restaurante->id) }}" class="text-decoration-none">
                            <div class="card restaurant-card">
                                <img src="{{ $restaurante->imagenes->isNotEmpty() ? asset($restaurante->imagenes->first()->url) : asset($resolveRestauranteImage($restaurante->nombre)) }}" class="card-img-top" alt="{{ $restaurante->imagenes->isNotEmpty() ? $restaurante->imagenes->first()->alt : $restaurante->nombre }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $restaurante->nombre }}</h5>
                                    <p class="card-text">
                                        <i class="bi bi-geo-alt"></i> {{ $restaurante->categoria->nombre }} · {{ $restaurante->ubicacion->ciudad }}, {{ $restaurante->ubicacion->provincia }}
                                    </p>
                                    <div class="rating">
                                        @if($restaurante->soles > 0)
                                            @for($i = 0; $i < $restaurante->soles; $i++)
                                                <i class="bi bi-sun-fill sun-icon"></i>
                                            @endfor
                                            <span>{{ $restaurante->soles }} {{ $restaurante->soles == 1 ? 'Sol' : 'Soles' }}</span>
                                        @else
                                            <i class="bi bi-star-fill"></i>
                                            <span>{{ number_format($restaurante->valoracion_promedio, 1) }}</span>
                                        @endif
                                        <span class="badge-stars">
                                        @if($restaurante->precio < 30)
                                            €
                                        @elseif($restaurante->precio < 60)
                                            €€
                                        @elseif($restaurante->precio < 100)
                                            €€€
                                        @else
                                            €€€€
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="bi bi-bookmark" style="font-size: 48px;"></i>
                            <p class="mt-3 mb-0">Aún no has guardado ningún restaurante. Explora nuestro <a href="{{ route('restaurantes') }}">listado</a> y guarda tus favoritos.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Paginación -->
                @if($restaurantes->hasPages())
                <div class="pagination-section mt-5">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                        <!-- Flecha Anterior -->
                        @if($restaurantes->onFirstPage())
                            <span class="pagination-arrow disabled">
                                <i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
                            </span>
                        @else
                            <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->previousPageUrl() }}" class="pagination-arrow">
                                <i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
                            </a>
                        @endif

                        <!-- Números de página -->
                        <div class="d-flex gap-2">
                            @foreach ($restaurantes->getUrlRange(1, $restaurantes->lastPage()) as $page => $url)
                                @if($page == $restaurantes->currentPage())
                                    <span class="page-number active">{{ $page }}</span>
                                @else
                                    <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->url($page) }}" class="page-number">{{ $page }}</a>
                                @endif
                            @endforeach
                        </div>

                        <!-- Flecha Siguiente -->
                        @if($restaurantes->hasMorePages())
                            <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->nextPageUrl() }}" class="pagination-arrow">
                                <i class="bi bi-chevron-right" style="font-size: 60px; color: #00a3e0;"></i>
                            </a>
                        @else
                            <span class="pagination-arrow disabled">
                                <i class="bi bi-chevron-right" style="font-size: 60px; color: #ccc;"></i>
                            </span>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/restaurantes-guardados.js') }}"></script>

    <script>
        // Toggle Mobile Menu
        const btnToggleMenu = document.getElementById('btnToggleMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        btnToggleMenu.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });

        // Cerrar menú cuando se hace click en un link
        const menuLinks = mobileMenu.querySelectorAll('a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
            });
        });
    </script>
</body>

</html>
