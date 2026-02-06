<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soletes - Guía Repsol</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/soletes.css') }}">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo">Guía Repsol</div>
            <nav class="nav">
                <ul>
                    <li><a href="#">Comer</a></li>
                    <li><a href="#">Viajar</a></li>
                    <li><a href="#">Soles</a></li>
                    <li><a href="#">Soletes</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Soletes</h1>
            <p>Un placer asequible, donde prima la calidad y el buen hacer. Mesones, asadores, casas de comida con un menú del día estupendo o restaurantes con vocación viajera y propuestas modernas con ganas de innovar. Para repetir por su ambiente informal y acogedor</p>
        </div>
    </section>

    <!-- Un Solete para cada momento del día -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Un Solete para cada momento del día</h2>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-image">🥐</div>
                    <div class="card-content">
                        <h3 class="card-title">13 Soletes para mojar churros</h3>
                        <p class="card-text">Donde comprar churros</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🍷</div>
                    <div class="card-content">
                        <h3 class="card-title">Soletes para celebrar con los amigos</h3>
                        <p class="card-text">15 sitios con Solete donde tomar el aperitivo en Madrid</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🍜</div>
                    <div class="card-content">
                        <h3 class="card-title">La sopa asiática que llegó para quedarse</h3>
                        <p class="card-text">Dónde comer ramen</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ¿Qué son los Soletes? -->
    <section class="section categories">
        <div class="container">
            <h2 class="section-title">¿Qué son los Soletes?</h2>
            <div class="info-box">
                <h3>Un placer asequible</h3>
                <p>Mesones, asadores, casas de comida con un menú del día estupendo o restaurantes con vocación viajera y propuestas modernas con ganas de innovar.</p>
            </div>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-icon">☕</div>
                    <h3 class="category-title">Cafeterías</h3>
                    <p class="category-description">Establecimientos con encanto, donde disfrutar de un café en un ambiente único y agradable.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🍽️</div>
                    <h3 class="category-title">Restaurantes</h3>
                    <p class="category-description">Rincones gastronómicos donde disfrutar de sabores auténticos y precios accesibles.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🏖️</div>
                    <h3 class="category-title">Terrazas y chiringuitos</h3>
                    <p class="category-description">Lugares perfectos para disfrutar al aire libre y pasar momentos inolvidables bajo el sol.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🍷</div>
                    <h3 class="category-title">Vinotecas</h3>
                    <p class="category-description">Aquí los vinos, sidras o cervezas son protagonistas, acompañados de platos apetecibles.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🍦</div>
                    <h3 class="category-title">Heladerías</h3>
                    <p class="category-description">Ese pequeño kiosko en el parque donde hacen el mejor granizado, helado u horchata que has probado.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🍺</div>
                    <h3 class="category-title">Bares</h3>
                    <p class="category-description">Tabernas, cantinas y barras de mercado ya sean clásicas o innovadoras a los que vas a volver.</p>
                </div>
                <div class="category-card">
                    <div class="category-icon">🌮</div>
                    <h3 class="category-title">Fast Good</h3>
                    <p class="category-description">A donde vas cuando quieres cenar tacos, arepas o un sandwich de toda que sabes que no te van a defraudar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tus Soletes cercanos -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Tus Soletes cercanos</h2>
            <div class="filters">
                <button class="filter-btn active">Todos</button>
                <button class="filter-btn">Soletes de cocineros</button>
                <button class="filter-btn">Tipo de local</button>
                <button class="filter-btn">Precio</button>
                <button class="filter-btn">Comida</button>
            </div>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-image">🍔</div>
                    <div class="card-content">
                        <h3 class="card-title">Miga Cana</h3>
                        <p class="card-text">Bar · Madrid, España</p>
                        <span class="card-tag">1 Solete · €</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🍽️</div>
                    <div class="card-content">
                        <h3 class="card-title">Kitchen 154</h3>
                        <p class="card-text">Restaurante · Madrid, España</p>
                        <span class="card-tag">1 Solete · €</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">☕</div>
                    <div class="card-content">
                        <h3 class="card-title">Chocolatería 1902</h3>
                        <p class="card-text">Cafetería · Madrid, España</p>
                        <span class="card-tag">1 Solete · €</span>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="#" class="btn-primary">Ver más</a>
            </div>
        </div>
    </section>

    <!-- Lo último sobre Soletes -->
    <section class="section" style="background: #FAFAFA;">
        <div class="container">
            <h2 class="section-title">Lo último sobre Soletes</h2>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-image">☕</div>
                    <div class="card-content">
                        <h3 class="card-title">El café de especialidad aterriza en el sur de Madrid</h3>
                        <p class="card-text">Cafetería 'Linda' (Valdemoro, Madrid)</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🍷</div>
                    <div class="card-content">
                        <h3 class="card-title">El bar donde los actores toman el vermú con la gente del barrio</h3>
                        <p class="card-text">'Merinas', el bar de tres conocidas actrices en Carabanchel</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">📚</div>
                    <div class="card-content">
                        <h3 class="card-title">Soletes para celebrar la Feria del libro</h3>
                        <p class="card-text">Dónde comer barato cerca del Parque del Retiro (Madrid)</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="#" class="btn-primary">Ver todos los reportajes</a>
            </div>
        </div>
    </section>

    <!-- Soletes para combatir el frío -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Soletes para combatir el frío</h2>
            <p class="section-subtitle">Este invierno, platos reconfortantes y salas acogedoras</p>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-image">🍜</div>
                    <div class="card-content">
                        <h3 class="card-title">Pho vietnamita, caldo gallego y otras formas de entrar en calor</h3>
                        <p class="card-text">Restaurantes donde tomar sopa</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🍫</div>
                    <div class="card-content">
                        <h3 class="card-title">Días de Solete y chocolate a la taza</h3>
                        <p class="card-text">Soletes donde tomar chocolate caliente</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
                <div class="card">
                    <div class="card-image">🏔️</div>
                    <div class="card-content">
                        <h3 class="card-title">Broche culinario a las excursiones madrileñas</h3>
                        <p class="card-text">Dónde comer y merendar en los pueblos de Madrid</p>
                        <span class="card-tag">Reportaje gastronómico</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Encuentra Soletes en tu comunidad -->
    <section class="section" style="background: #FAFAFA;">
        <div class="container">
            <h2 class="section-title">Encuentra Soletes en tu comunidad</h2>
            <div class="destinations-grid">
                <div class="destination-card">
                    <div class="destination-name">Madrid</div>
                </div>
                <div class="destination-card">
                    <div class="destination-name">Catalunya</div>
                </div>
                <div class="destination-card">
                    <div class="destination-name">Comunitat Valenciana</div>
                </div>
                <div class="destination-card">
                    <div class="destination-name">Extremadura</div>
                </div>
                <div class="destination-card">
                    <div class="destination-name">Euskadi</div>
                </div>
                <div class="destination-card">
                    <div class="destination-name">Andalucía</div>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <a href="#" class="btn-primary">Ver todos los destinos</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h3>Guía Repsol</h3>
                    <ul>
                        <li><a href="#">Comer</a></li>
                        <li><a href="#">Viajar</a></li>
                        <li><a href="#">Dormir</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Enlaces</h3>
                    <ul>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">Sala de prensa</a></li>
                        <li><a href="#">Canal de ética</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Síguenos</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">TikTok</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Política de privacidad</a></li>
                        <li><a href="#">Política de cookies</a></li>
                        <li><a href="#">Nota legal</a></li>
                        <li><a href="#">Condiciones del servicio</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© Repsol S.A. 2000 - 2026</p>
            </div>
        </div>
    </footer>

    <script>
        // Filtros interactivos
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
