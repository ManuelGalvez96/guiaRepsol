<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/restaurantes.css') }}">
    <title>Guía Repsol - Restaurantes</title>
</head>

<body data-search-url="{{ route('restaurantes') }}">
    @php
        use Illuminate\Support\Facades\File;
        use Illuminate\Support\Str;

        $stopwords = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'the', 'restaurante', 'restaurant', 'l'];

        $normalizeRestauranteName = function (string $value) use ($stopwords): string {
            $asciiValue = Str::ascii($value);
            $cleanValue = preg_replace('/[^a-zA-Z0-9]+/', ' ', $asciiValue) ?? '';
            $tokens = array_filter(explode(' ', strtolower($cleanValue)));
            $tokens = array_values(array_filter($tokens, fn($token) => !in_array($token, $stopwords, true)));

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

        $resolveRestauranteImage = function (string $nombre) use (
            $normalizeRestauranteName,
            $restauranteImageMap,
        ): string {
            $key = $normalizeRestauranteName($nombre);

            return $restauranteImageMap[$key] ?? 'img/restaurantes/emigrante.webp';
        };
    @endphp
    <!-- Header Principal -->
    <header class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn-menu-detalle" id="btnToggleMenu" onclick="toggleMobileMenu()">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-img">
                </div>
                <div class="col">
                    <div class="search-bar">
                        <button class="btn-close-search" id="restaurant-search-clear">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <input type="text" class="search-input" id="restaurant-search-input" placeholder="Buscar">
                        <button class="btn-search-submit" id="restaurant-search-button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
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
            <li><a href="{{ route('restaurantes') }}" class="active"><i class="bi bi-list-ul"></i> Listado</a></li>
            <li><a href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a></li>
            <li><a href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i> Guardados</a></li>
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
                    <a class="nav-link active" href="#"><i class="bi bi-list-ul"></i> Listado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i>
                        Guardados</a>
                </li>
            </ul>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger text-center m-0">
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <!-- Columna Izquierda - Contenido Relacionado -->
                <div class="col-lg-4">
                    <div class="content-section">
                        <div class="section-header">
                            <div>
                                <h2>Contenido relacionado
                                    <button class="btn-toggle-sidebar active" id="btnToggleSidebar">
                                        <i class="bi bi-chevron-down"></i>
                                    </button>
                                </h2>
                                <span class="result-count">{{ $totalPatrocinados }} restaurantes patrocinados</span>
                            </div>
                            <div class="sidebar-ordenar">
                                <form method="GET" action="{{ route('restaurantes') }}" id="formOrdenarPatrocinados">
                                    <select name="ordenar_patrocinados" class="btn btn-sm btn-outline-secondary"
                                        onchange="document.getElementById('formOrdenarPatrocinados').submit()">
                                        <option value="nombre"
                                            {{ request('ordenar_patrocinados') == 'nombre' ? 'selected' : '' }}>Nombre
                                            A-Z</option>
                                        <option value="soles"
                                            {{ request('ordenar_patrocinados') == 'soles' ? 'selected' : '' }}>Más
                                            Soles Repsol</option>
                                        <option value="precio_asc"
                                            {{ request('ordenar_patrocinados') == 'precio_asc' ? 'selected' : '' }}>
                                            Precio: Menor a Mayor</option>
                                        <option value="precio_desc"
                                            {{ request('ordenar_patrocinados') == 'precio_desc' ? 'selected' : '' }}>
                                            Precio: Mayor a Menor</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- Lista de Restaurantes Patrocinados -->
                        <div class="articles-list sidebar-content show" id="sidebarContent">
                            @forelse($restaurantesPatrocinados as $patrocinado)
                                <a href="{{ route('restaurante.detalle', $patrocinado->id) }}"
                                    style="text-decoration: none; color: inherit;">
                                    <article class="article-item">
                                        <img src="{{ $patrocinado->imagenes->isNotEmpty() ? asset($patrocinado->imagenes->first()->url) : asset($resolveRestauranteImage($patrocinado->nombre)) }}"
                                            alt="{{ $patrocinado->imagenes->isNotEmpty() ? $patrocinado->imagenes->first()->alt : $patrocinado->nombre }}">
                                        <div class="article-content">
                                            <h3>{{ $patrocinado->nombre }}</h3>
                                            <p class="article-meta">
                                                <i class="bi bi-geo-alt"></i> {{ $patrocinado->ubicacion->ciudad }},
                                                {{ $patrocinado->ubicacion->provincia }}
                                                @if ($patrocinado->soles > 0)
                                                    |
                                                    @for ($i = 0; $i < $patrocinado->soles; $i++)
                                                        <i class="bi bi-sun-fill" style="color: #f7931e;"></i>
                                                    @endfor
                                                @endif
                                            </p>
                                            <p class="article-excerpt">{{ Str::limit($patrocinado->descripcion, 150) }}
                                            </p>
                                            <div class="mt-2">
                                                <span
                                                    class="badge bg-primary">{{ $patrocinado->categoria->nombre }}</span>
                                                <span class="badge bg-info text-dark">Precio medio:
                                                    {{ number_format($patrocinado->precio, 0) }}€</span>
                                            </div>
                                        </div>
                                    </article>
                                </a>
                            @empty
                                <p class="text-muted">No hay restaurantes patrocinados en este momento.</p>
                            @endforelse

                            <!-- Paginación Patrocinados -->
                            @if ($restaurantesPatrocinados->hasPages())
                                <div class="pagination-section mt-4">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <!-- Flecha Anterior -->
                                        @if ($restaurantesPatrocinados->onFirstPage())
                                            <span class="pagination-arrow-small disabled">
                                                <i class="bi bi-chevron-left"
                                                    style="font-size: 30px; color: #ccc;"></i>
                                            </span>
                                        @else
                                            <a href="{{ $restaurantesPatrocinados->appends(['ordenar_patrocinados' => request('ordenar_patrocinados')])->previousPageUrl('patrocinados_page') }}"
                                                class="pagination-arrow-small">
                                                <i class="bi bi-chevron-left"
                                                    style="font-size: 30px; color: #333;"></i>
                                            </a>
                                        @endif

                                        <!-- Números de página -->
                                        <div class="d-flex gap-1">
                                            @foreach ($restaurantesPatrocinados->getUrlRange(1, $restaurantesPatrocinados->lastPage()) as $page => $url)
                                                @if ($page == $restaurantesPatrocinados->currentPage())
                                                    <span class="page-number-small active">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $restaurantesPatrocinados->appends(['ordenar_patrocinados' => request('ordenar_patrocinados')])->url($page) }}"
                                                        class="page-number-small">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- Flecha Siguiente -->
                                        @if ($restaurantesPatrocinados->hasMorePages())
                                            <a href="{{ $restaurantesPatrocinados->appends(['ordenar_patrocinados' => request('ordenar_patrocinados')])->nextPageUrl('patrocinados_page') }}"
                                                class="pagination-arrow-small">
                                                <i class="bi bi-chevron-right"
                                                    style="font-size: 30px; color: #00a3e0;"></i>
                                            </a>
                                        @else
                                            <span class="pagination-arrow-small disabled">
                                                <i class="bi bi-chevron-right"
                                                    style="font-size: 30px; color: #ccc;"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha - Establecimientos -->
                <div class="col-lg-8">
                    <!-- Establecimientos Gastronómicos -->
                    <div class="content-section">
                        <div class="section-header">
                            <div>
                                <h2>Establecimientos gastronómicos</h2>
                                <span class="result-count" id="restaurantes-count">{{ $restaurantes->total() }}
                                    resultados para *</span>
                            </div>
                            <div>
                                <form method="GET" action="{{ route('restaurantes') }}" id="formOrdenar">
                                    <select name="ordenar" class="btn btn-sm btn-outline-secondary"
                                        onchange="document.getElementById('formOrdenar').submit()">
                                        <option value="nombre" {{ request('ordenar') == 'nombre' ? 'selected' : '' }}>
                                            Nombre A-Z</option>
                                        <option value="valoracion"
                                            {{ request('ordenar') == 'valoracion' ? 'selected' : '' }}>Mejor valorados
                                        </option>
                                        <option value="soles" {{ request('ordenar') == 'soles' ? 'selected' : '' }}>
                                            Más Soles Repsol</option>
                                        <option value="precio_asc"
                                            {{ request('ordenar') == 'precio_asc' ? 'selected' : '' }}>Precio: Menor a
                                            Mayor</option>
                                        <option value="precio_desc"
                                            {{ request('ordenar') == 'precio_desc' ? 'selected' : '' }}>Precio: Mayor a
                                            Menor</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <div class="row g-4 mb-5" id="restaurants-grid">
                            @forelse($restaurantes as $restaurante)
                                <div class="col-md-4">
                                    <a href="{{ route('restaurante.detalle', $restaurante->id) }}"
                                        class="text-decoration-none">
                                        <div class="card restaurant-card">
                                            <img src="{{ $restaurante->imagenes->isNotEmpty() ? asset($restaurante->imagenes->first()->url) : asset($resolveRestauranteImage($restaurante->nombre)) }}"
                                                class="card-img-top"
                                                alt="{{ $restaurante->imagenes->isNotEmpty() ? $restaurante->imagenes->first()->alt : $restaurante->nombre }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $restaurante->nombre }}</h5>
                                                <p class="card-text">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $restaurante->categoria->nombre }} ·
                                                    {{ $restaurante->ubicacion->ciudad }},
                                                    {{ $restaurante->ubicacion->provincia }}
                                                </p>
                                                <div class="rating">
                                                    @if ($restaurante->soles > 0)
                                                        @for ($i = 0; $i < $restaurante->soles; $i++)
                                                            <i class="bi bi-sun-fill sun-icon"></i>
                                                        @endfor
                                                        <span>{{ $restaurante->soles }}
                                                            {{ $restaurante->soles == 1 ? 'Sol' : 'Soles' }}</span>
                                                    @else
                                                        <i class="bi bi-star-fill"></i>
                                                        <span>{{ number_format($restaurante->valoracion_promedio, 1) }}</span>
                                                    @endif
                                                    <span class="badge-stars">
                                                        @if ($restaurante->precio < 30)
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
                                    <p class="text-center text-muted">No se encontraron restaurantes.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Paginación -->
                        @if ($restaurantes->hasPages())
                            <div class="pagination-section mt-5" id="restaurantes-pagination">
                                <div class="d-flex justify-content-center align-items-center gap-3">
                                    <!-- Flecha Anterior (grande) -->
                                    @if ($restaurantes->onFirstPage())
                                        <span class="pagination-arrow disabled">
                                            <i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
                                        </span>
                                    @else
                                        <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->previousPageUrl() }}"
                                            class="pagination-arrow">
                                            <i class="bi bi-chevron-left" style="font-size: 60px; color: #333;"></i>
                                        </a>
                                    @endif

                                    <!-- Números de página -->
                                    <div class="d-flex gap-2">
                                        @foreach ($restaurantes->getUrlRange(1, $restaurantes->lastPage()) as $page => $url)
                                            @if ($page == $restaurantes->currentPage())
                                                <span class="page-number active">{{ $page }}</span>
                                            @else
                                                <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->url($page) }}"
                                                    class="page-number">{{ $page }}</a>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Flecha Siguiente (grande) -->
                                    @if ($restaurantes->hasMorePages())
                                        <a href="{{ $restaurantes->appends(['ordenar' => request('ordenar')])->nextPageUrl() }}"
                                            class="pagination-arrow">
                                            <i class="bi bi-chevron-right"
                                                style="font-size: 60px; color: #00a3e0;"></i>
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

            <!-- Mis Restaurantes (Solo para Gerentes) - Ancho completo -->
            @if (Auth::check() && Auth::user()->rol === 'gerente' && $restaurantesGerente)
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="content-section">
                            <div class="section-header">
                                <div>
                                    <h2>Mis restaurantes</h2>
                                    <span class="result-count">{{ $restaurantesGerente->total() }} restaurantes</span>
                                </div>
                            </div>

                            <div class="row g-4">
                                @forelse($restaurantesGerente as $restaurante)
                                    <div class="col-md-3">
                                        <a href="{{ route('restaurante.detalle', $restaurante->id) }}"
                                            class="text-decoration-none">
                                            <div class="card place-card">
                                                <img src="{{ $restaurante->imagenes->isNotEmpty() ? asset($restaurante->imagenes->first()->url) : asset($resolveRestauranteImage($restaurante->nombre)) }}"
                                                    class="card-img-top"
                                                    alt="{{ $restaurante->imagenes->isNotEmpty() ? $restaurante->imagenes->first()->alt : $restaurante->nombre }}">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $restaurante->nombre }}</h6>
                                                    <p class="card-text small">
                                                        <i class="bi bi-geo-alt"></i>
                                                        {{ $restaurante->ubicacion->ciudad }}
                                                    </p>
                                                    <div class="mt-2">
                                                        @if ($restaurante->soles > 0)
                                                            @for ($i = 0; $i < $restaurante->soles; $i++)
                                                                <i class="bi bi-sun-fill"
                                                                    style="color: #f7931e; font-size: 14px;"></i>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <p class="text-center text-muted">No tienes restaurantes registrados.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Paginación Gerente -->
                            @if ($restaurantesGerente->hasPages())
                                <div class="pagination-section mt-4">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <!-- Flecha Anterior -->
                                        @if ($restaurantesGerente->onFirstPage())
                                            <span class="pagination-arrow-small disabled">
                                                <i class="bi bi-chevron-left"
                                                    style="font-size: 30px; color: #ccc;"></i>
                                            </span>
                                        @else
                                            <a href="{{ $restaurantesGerente->appends(request()->except('gerente_page'))->previousPageUrl('gerente_page') }}"
                                                class="pagination-arrow-small">
                                                <i class="bi bi-chevron-left"
                                                    style="font-size: 30px; color: #333;"></i>
                                            </a>
                                        @endif

                                        <!-- Números de página -->
                                        <div class="d-flex gap-1">
                                            @foreach ($restaurantesGerente->getUrlRange(1, $restaurantesGerente->lastPage()) as $page => $url)
                                                @if ($page == $restaurantesGerente->currentPage())
                                                    <span class="page-number-small active">{{ $page }}</span>
                                                @else
                                                    <a href="{{ $restaurantesGerente->appends(request()->except('gerente_page'))->url($page) }}"
                                                        class="page-number-small">{{ $page }}</a>
                                                @endif
                                            @endforeach
                                        </div>

                                        <!-- Flecha Siguiente -->
                                        @if ($restaurantesGerente->hasMorePages())
                                            <a href="{{ $restaurantesGerente->appends(request()->except('gerente_page'))->nextPageUrl('gerente_page') }}"
                                                class="pagination-arrow-small">
                                                <i class="bi bi-chevron-right"
                                                    style="font-size: 30px; color: #00a3e0;"></i>
                                            </a>
                                        @else
                                            <span class="pagination-arrow-small disabled">
                                                <i class="bi bi-chevron-right"
                                                    style="font-size: 30px; color: #ccc;"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/mobile-menu.js') }}"></script>
    <script src="{{ asset('js/restaurantes.js') }}"></script>


</body>

</html>
