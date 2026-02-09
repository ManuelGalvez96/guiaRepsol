<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/js/app.js'])
    <title>Guía Repsol - Restaurantes</title>
</head>

<body>
    <!-- Header Principal -->
    <header class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn-menu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-img">
                </div>
                <div class="col">
                    <div class="search-bar">
                        <button class="btn-close-search">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <input type="text" class="search-input" placeholder="Buscar">
                        <button class="btn-search-submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-auto">
                    <button class="btn-acceso">
                        <i class="bi bi-person"></i> Acceso
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <div class="container">
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="bi bi-list-ul"></i> Listado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-map"></i> Mapa</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <!-- Columna Izquierda - Contenido Relacionado -->
                <div class="col-lg-4">
                    <div class="content-section">
                        <div class="section-header">
                            <h2>Contenido relacionado</h2>
                            <span class="result-count">75 resultados cerca de tú</span>
                        </div>

                        <div class="filters mb-3">
                            <button class="btn btn-sm btn-outline-secondary me-2">
                                Todos los reportajes <i class="bi bi-chevron-down"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-funnel"></i> Recetas
                            </button>
                        </div>

                        <!-- Lista de Artículos -->
                        <div class="articles-list">
                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=1" alt="Artículo">
                                <div class="article-content">
                                    <h3>Guía práctica para distinguir el verdadero pinxo donostiarra</h3>
                                    <p class="article-meta">Reportajes gastronómicas</p>
                                    <p class="article-excerpt">De Bilbao a Donosti, la cultura del pintxo, muy presente en la gastronomía vasca, se hace especialmente fuerte en San Sebastián y no ha dejado de ir a más desde que a finales de los...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=2" alt="Artículo">
                                <div class="article-content">
                                    <h3>20 rutas pintxo-pote para maridar con Jazz</h3>
                                    <p class="article-meta">Reportajes gastronómicas</p>
                                    <p class="article-excerpt">El Heineken Jazzaldia es, casi cuarenta años después de su nacimiento, mucho más que música...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=3" alt="Artículo">
                                <div class="article-content">
                                    <h3>Tras la huella del pintor de la luz</h3>
                                    <p class="article-meta">Reportajes región</p>
                                    <p class="article-excerpt">Por caminos mediterráneos sin asfaltar, vibrante y pasear temporadas por una localidad...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=4" alt="Artículo">
                                <div class="article-content">
                                    <h3>El magisterismo del Pindo y la polenta de Ézaro en la Costa da Morte</h3>
                                    <p class="article-meta">Reportajes gastronómicas</p>
                                    <p class="article-excerpt">Repasamos esa sabiduría y saberes, con el generoso monte Pindo custodiando...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=5" alt="Artículo">
                                <div class="article-content">
                                    <h3>La reina de las olas, las bixkotxorras y el 'pintxo-pote'</h3>
                                    <p class="article-meta">Reportajes región</p>
                                    <p class="article-excerpt">Zarauz se haya que las características bahías del Cantábrico atraen en verano...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=6" alt="Artículo">
                                <div class="article-content">
                                    <h3>El bancalillo 'de toma' en marisco que vale merece un monumento</h3>
                                    <p class="article-meta">Reportajes gastronómicas</p>
                                    <p class="article-excerpt">El caso se puede ver de tan rico: un manojo de cañas y la moneda a las 14h...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=7" alt="Artículo">
                                <div class="article-content">
                                    <h3>El kiosco refrito de un pintor</h3>
                                    <p class="article-meta">Reportajes región</p>
                                    <p class="article-excerpt">La vieja taberna de Joaquín Sorolla, nacida en 1922 en una caseta...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=8" alt="Artículo">
                                <div class="article-content">
                                    <h3>'El biaro en mariscos de 'Venita Pinky', en Barca de Vejer, es brutal'</h3>
                                    <p class="article-meta">Reportajes gastronómicas</p>
                                    <p class="article-excerpt">Como toma de contacto con el chef, dice, Juan Valdés confirma ser un fijo...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=9" alt="Artículo">
                                <div class="article-content">
                                    <h3>Sevilla se postra ante Murillo</h3>
                                    <p class="article-meta">Reportajes región</p>
                                    <p class="article-excerpt">Los tesoros de biblioteca Estaban Murillo, el que escribía de los pintores...</p>
                                </div>
                            </article>

                            <article class="article-item">
                                <img src="https://picsum.photos/100/80?random=10" alt="Artículo">
                                <div class="article-content">
                                    <h3>Subirse a las carretas de Colón</h3>
                                    <p class="article-meta">Reportajes región</p>
                                    <p class="article-excerpt">La figura de Cristóbal Colón y el Descubrimiento de América a través de...</p>
                                </div>
                            </article>
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
                                <span class="result-count">{{ $restaurantes->count() }} resultados para *</span>
                            </div>
                            <div>
                                <form method="GET" action="{{ route('restaurantes') }}" id="formOrdenar">
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
                            <div class="col-md-4">
                                <div class="card restaurant-card">
                                    <img src="https://picsum.photos/400/300?random={{ $restaurante->id }}" class="card-img-top" alt="{{ $restaurante->nombre }}">
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
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-center text-muted">No se encontraron restaurantes.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Lugares de Interés -->
                    <div class="content-section">
                        <div class="section-header">
                            <div>
                                <h2>Lugares de interés</h2>
                                <span class="result-count">2981 resultados para *</span>
                            </div>
                            <div>
                                <a href="#" class="link-mapa">Ver más en mapa</a>
                            </div>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="card place-card">
                                    <img src="https://picsum.photos/300/200?random=14" class="card-img-top" alt="Domingo Pérez">
                                    <div class="card-body">
                                        <h6 class="card-title">Domingo Pérez</h6>
                                        <p class="card-text small">Localidad</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card place-card">
                                    <img src="https://picsum.photos/300/200?random=15" class="card-img-top" alt="Ervidrs">
                                    <div class="card-body">
                                        <h6 class="card-title">Ervidrs</h6>
                                        <p class="card-text small">Localidad</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card place-card">
                                    <img src="https://picsum.photos/300/200?random=16" class="card-img-top" alt="Mesegar de Tajo">
                                    <div class="card-body">
                                        <h6 class="card-title">Mesegar de Tajo</h6>
                                        <p class="card-text small">Localidad</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card place-card">
                                    <img src="https://picsum.photos/300/200?random=17" class="card-img-top" alt="La Mata">
                                    <div class="card-body">
                                        <h6 class="card-title">La Mata</h6>
                                        <p class="card-text small">Localidad</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="pagination-dots text-center mt-4">
                            <span class="dot active"></span>
                            <span class="dot"></span>
                            <span class="dot"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
