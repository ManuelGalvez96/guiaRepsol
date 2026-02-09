<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Soletes | Guía Repsol</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/soletes.css') }}">
</head>

<body>

<!-- TOP BAR -->
<div class="topbar">
  <div class="topbar-inner">
    <div class="top-left">
      <div class="burger">☰</div>
      <div class="logo">guía repsol</div>
      <nav class="nav">
        <a href="#">Comer</a>
        <a href="#">Viajar</a>
        <a href="#">Soles</a>
        <a href="#" class="active">Soletes</a>
      </nav>
    </div>
    <div class="top-right">🔍 Acceso</div>
  </div>
</div>

<!-- BLUE LINE -->
<div class="blue-line"></div>

<!-- SUBNAV -->
<section class="subnav">
  <div class="subnav-inner">
    <div>Soletes</div>
    <div>Todos los Soletes</div>
    <div>Pet friendly</div>
    <div>Con solera</div>
    <div>De carretera</div>
    <div>Donde comen los cocineros</div>
  </div>
</section>

<!-- HERO -->
<section class="hero">
  <div>
    <div class="hero-eyebrow">Dónde tomar cócteles sin alcohol</div>
    <h1>Mixología abstemia para curar los excesos</h1>
    <p>
      Cada vez más coctelerías se esfuerzan en ofrecer buenos y variados
      ‘mocktails’, pero hay algunas que destacan desde hace tiempo por el
      esfuerzo y conocimiento que dedican.
    </p>
    <div class="hero-author">Texto: Ana Caro</div>
    <a href="#" class="hero-btn">📖 Saber más</a>
  </div>

  <div class="hero-img">
    <img src="{{ asset('images/imagen1.png') }}">
  </div>
</section>

<section class="momentos">
  <div class="momentos-inner">

    <h2 class="momentos-title">
      Un Solete para cada momento del día
      <span></span>
    </h2>

    <div class="momentos-grid">

      <article class="momento-card">
        <div class="momento-img">
          <img src="{{ asset('images/imagen2.png') }}">
          <div class="momento-icons">♡ ⤴ 🔖</div>
          <div class="momento-overlay">
            <div class="momento-tag">Reportaje gastronómico</div>
            <h3>13 Soletes para mojar churros</h3>
            <p>Dónde comprar churros</p>
          </div>
        </div>
      </article>

      <article class="momento-card">
        <div class="momento-img">
          <img src="{{ asset('images/imagen3.png') }}">
          <div class="momento-icons">♡ ⤴ 🔖</div>
          <div class="momento-overlay">
            <div class="momento-tag">Reportaje gastronómico</div>
            <h3>Soletes para celebrar con los amigos</h3>
            <p>15 sitios con Solete donde tomar el aperitivo en Madrid</p>
          </div>
        </div>
      </article>

      <article class="momento-card">
        <div class="momento-img">
          <img src="{{ asset('images/imagen4.png') }}">
          <div class="momento-icons">♡ ⤴ 🔖</div>
          <div class="momento-overlay">
            <div class="momento-tag">Reportaje gastronómico</div>
            <h3>La sopa asiática que llegó para quedarse</h3>
            <p>Dónde comer ramen</p>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

<section class="que-son">
  <div class="que-son-inner">

    <h2 class="que-son-title">
      ¿Qué son los Soletes?
      <span></span>
    </h2>

    <p class="que-son-text">
      Un placer asequible, donde prima la calidad y el buen hacer. Mesones,
      asadores, casas de comida con un menú del día estupendo o restaurantes
      con vocación viajera y propuestas modernas con ganas de innovar.
      Para repetir por su ambiente informal y acogedor.
    </p>

    <div class="categorias">

      <div class="categoria">
        <div class="icono">☕</div>
        <h3>Cafeterías</h3>
        <p>Establecimientos con encanto, donde disfrutar de un café en un ambiente único y agradable.</p>
      </div>

      <div class="categoria">
        <div class="icono">🍽️</div>
        <h3>Restaurantes</h3>
        <p>Rincones gastronómicos donde disfrutar de sabores auténticos y precios accesibles.</p>
      </div>

      <div class="categoria">
        <div class="icono">☀️</div>
        <h3>Terrazas y chiringuitos</h3>
        <p>Lugares perfectos para disfrutar al aire libre y pasar momentos inolvidables bajo el sol.</p>
      </div>

      <div class="categoria">
        <div class="icono">🍷</div>
        <h3>Vinotecas</h3>
        <p>Aquí los vinos, sidras o cervezas son protagonistas, acompañados de platos apetecibles.</p>
      </div>

      <div class="categoria">
        <div class="icono">🍦</div>
        <h3>Heladerías</h3>
        <p>Ese pequeño kiosko donde hacen el mejor granizado, helado u horchata que recuerdas.</p>
      </div>

      <div class="categoria">
        <div class="icono">🍢</div>
        <h3>Bares</h3>
        <p>Tabernas, cantinas y barras de mercado, clásicas o innovadoras, a las que siempre vuelves.</p>
      </div>

      <div class="categoria">
        <div class="icono">🍔</div>
        <h3>Fast Good</h3>
        <p>A donde vas cuando quieres tacos, arepas o un sándwich bien hecho y sin sorpresas.</p>
      </div>

    </div>
  </div>
</section>
<section class="cercanos">
  <div class="cercanos-box">

    <!-- CABECERA -->
    <div class="cercanos-header">
      <h2>Tus Soletes cercanos</h2>
      <button class="location-btn">📍 Activar ubicación</button>
    </div>

    <!-- FILTROS -->
    <div class="cercanos-filters">
      <button class="filter-pill">🍽 Tipo de local ▾</button>
      <button class="filter-pill">€ Precio ▾</button>
      <button class="filter-pill">🍴 Comida ▾</button>
      <button class="filter-pill active">1 Solete ▾</button>
    </div>

    <!-- CARDS -->
    <div class="cercanos-cards">

      <article class="local-card">
        <img src="{{ asset('images/imagen5.png') }}">
        <div class="local-info">
          <h3>Miga Cana</h3>
          <p>Bar · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="{{ asset('images/imagen6.png') }}">
        <div class="local-info">
          <h3>Kitchen 154</h3>
          <p>Restaurante · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="{{ asset('images/imagen7.png') }}">
        <div class="local-info">
          <h3>Batch</h3>
          <p>Bar · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="{{ asset('images/imagen8.png') }}">
        <div class="local-info">
          <h3>Tori Key</h3>
          <p>Restaurante · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

    </div>

    <!-- INDICADORES -->
    <div class="cercanos-dots">
      <span class="dot active"></span>
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
      <span class="dot"></span>
    </div>

    <!-- CTA -->
    <div class="cercanos-cta">
      <button class="ver-mas">Ver más</button>
    </div>

  </div>
</section>
<section class="ultimo">
  <div class="ultimo-inner">

    <h2 class="ultimo-title">Lo último sobre Soletes</h2>

    <!-- FEATURED -->
    <article class="ultimo-featured">
      <div class="featured-img">
        <img src="{{ asset('images/imagen9.png') }}">
      </div>

      <div class="featured-content">
        <span class="featured-tag">ψ Reportaje gastronómico</span>
        <h3>El café de especialidad aterriza en el sur de Madrid</h3>
        <p class="featured-place">Cafetería ‘Linda’ (Valdemoro, Madrid)</p>

        <div class="featured-actions">
          ♡ ⤴ 🔖
        </div>
      </div>
    </article>

    <!-- GRID -->
    <div class="ultimo-grid">

      <article class="ultimo-card">
        <img src="{{ asset('images/imagen10.png') }}">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>El bar donde los actores toman el vermú con la gente del barrio</h4>
          <p>‘Merinas’, el bar de tres conocidas actrices en Carabanchel</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="{{ asset('images/imagen11.png') }}">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>Soletes para celebrar la Feria del libro a cualquier hora del día</h4>
          <p>Dónde comer barato cerca del Parque del Retiro (Madrid)</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="{{ asset('images/imagen12.png') }}">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>Seis mesas cántabras en la mejor compañía</h4>
          <p>Dónde desayunar, comer y tomar algo en Cantabria con tu mascota</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="{{ asset('images/imagen13.png') }}">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>Soletes en Galicia para no dejar a tu perro en casa</h4>
          <p>Cafeterías y restaurantes ‘pet friendly’ en Galicia</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

    </div>

    <!-- CTA -->
    <div class="ultimo-cta">
      <button>Ver todos los reportajes</button>
    </div>

  </div>
</section>
<section class="app-section">
  <div class="app-box">

    <!-- TEXTO -->
    <div class="app-content">
      <h2>Guía Repsol en tu bolsillo</h2>
      <p>Explora, reserva y disfruta. ¡Descarga la app!</p>
      <a href="#" class="app-btn">Descargar app</a>
    </div>

    <!-- MOCKUP -->
    <div class="app-mockup">
      <div class="phone">
        <img src="https://picsum.photos/300/600?app" alt="App Guía Repsol">

        <!-- CARDS FLOTANTES -->
        <div class="float-card left">
          <span>🍳</span>
          <p>¿Unas tostadas mañaneras?</p>
        </div>

        <div class="float-card center">
          <span>📍</span>
          <p>Haz una reserva<br>en el sitio</p>
        </div>

        <div class="float-card right">
          <span>📅</span>
          <p>Próx. reserva<br>14/03/24</p>
        </div>
      </div>
    </div>

  </div>
</section>
<section class="destacado">
  <div class="destacado-inner">

    <h2 class="destacado-title">
      Descubre lo más destacado sobre...
      <span></span>
    </h2>

    <div class="destacado-grid">

      <article class="destacado-item">
        <img src="{{ asset('images/imagen14.png') }}">
        <h3>Cafeterías</h3>
      </article>

      <article class="destacado-item">
        <img src="{{ asset('images/imagen15.png') }}">
        <h3>Bares</h3>
      </article>

      <article class="destacado-item">
        <img src="{{ asset('images/imagen16.png') }}">
        <h3>Fast Good</h3>
      </article>

      <article class="destacado-item">
        <img src="{{ asset('images/imagen17.png') }}">
        <h3>Vinotecas</h3>
      </article>

    </div>

  </div>
</section>

<section class="frio">
  <div class="frio-inner">

    <h2 class="frio-title">
      Soletes para combatir el frío
      <span></span>
    </h2>

    <p class="frio-subtitle">
      Este invierno, platos reconfortantes y salas acogedoras
    </p>

    <div class="frio-grid">

      <article class="frio-card">
        <div class="frio-img">
          <img src="{{ asset('images/imagen18.png') }}">
          <div class="frio-icons">♡ ⤴ 🔖</div>
          <div class="frio-overlay">
            <span class="frio-tag">ψ Reportaje gastronómico</span>
            <h3>Pho vietnamita, caldo gallego y otras ocho formas de entrar en calor</h3>
            <p>Restaurantes donde tomar sopa</p>
          </div>
        </div>
      </article>

      <article class="frio-card">
        <div class="frio-img">
          <img src="{{ asset('images/imagen19.png') }}">
          <div class="frio-icons">♡ ⤴ 🔖</div>
          <div class="frio-overlay">
            <span class="frio-tag">ψ Reportaje gastronómico</span>
            <h3>Días de Solete y chocolate a la taza</h3>
            <p>Soletes donde tomar chocolate caliente</p>
          </div>
        </div>
      </article>

      <article class="frio-card">
        <div class="frio-img">
          <img src="{{ asset('images/imagen20.png') }}">
          <div class="frio-icons">♡ ⤴ 🔖</div>
          <div class="frio-overlay">
            <span class="frio-tag">ψ Reportaje gastronómico</span>
            <h3>Broche culinario a las excursiones madrileñas</h3>
            <p>Dónde comer y merendar en los pueblos de Madrid</p>
          </div>
        </div>
      </article>

    </div>

  </div>
</section>
<section class="comunidades">
  <div class="comunidades-inner">

    <h2 class="comunidades-title">
      Encuentra Soletes en tu comunidad
      <span></span>
    </h2>

    <div class="comunidades-grid">

      <article class="comunidad">
        <img src="{{ asset('images/imagen22.png') }}">
        <h3>Madrid</h3>
      </article>

      <article class="comunidad">
        <img src="{{ asset('images/imagen23.png') }}">
        <h3>Catalunya</h3>
      </article>

      <article class="comunidad">
        <img src="{{ asset('images/imagen24.png') }}">
        <h3>Comunitat Valenciana</h3>
      </article>

      <article class="comunidad">
        <img src="{{ asset('images/imagen25.png') }}">
        <h3>Extremadura</h3>
      </article>

      <article class="comunidad">
        <img src="{{ asset('images/imagen26.png') }}">
        <h3>Euskadi</h3>
      </article>

    </div>

    <div class="comunidades-cta">
      <a href="#" class="btn-comunidades">Ver todos los destinos</a>
    </div>

  </div>
</section>
<footer class="footer">

  <!-- NEWSLETTER -->
  <div class="footer-newsletter">
    <div class="footer-newsletter-inner">

      <div class="newsletter-text">
        <h3>¡Mantente al tanto!</h3>
        <p>Suscríbete a la newsletter de los amantes del viaje y de la buena comida</p>
      </div>

      <form class="newsletter-form">
        <input type="email" placeholder="Email donde recibir las recomendaciones">
        <button type="submit">Suscribirme</button>
      </form>

    </div>
  </div>

  <!-- LINKS -->
  <div class="footer-main">
    <div class="footer-main-inner">

      <div class="footer-brand">
        <span>guía repsol</span>
      </div>

      <div class="footer-cols">

        <div class="footer-col">
          <h4>Guía Repsol</h4>
          <a href="#">Comer</a>
          <a href="#">Viajar</a>
          <a href="#">Dormir</a>
        </div>

        <div class="footer-col">
          <h4>Enlaces</h4>
          <a href="#">Contacto</a>
          <a href="#">Sala de prensa</a>
          <a href="#">Canal de ética</a>
        </div>

        <div class="footer-col">
          <h4>Descubre</h4>
          <a href="#">App Guía Repsol</a>
          <a href="#">Cromos Guía Repsol</a>
          <a href="#">Mercado Vallehermoso</a>
        </div>

      </div>

    </div>
  </div>

  <!-- LEGAL -->
  <div class="footer-bottom">
    <div class="footer-bottom-inner">

      <div class="footer-legal">
        <a href="#">Política de privacidad</a>
        <span>|</span>
        <a href="#">Política de cookies</a>
        <span>|</span>
        <a href="#">Nota legal</a>
        <span>|</span>
        <a href="#">Condiciones del servicio</a>
      </div>

      <div class="footer-social">
        <span>f</span>
        <span>x</span>
        <span>◎</span>
        <span>♪</span>
      </div>

    </div>

    <div class="footer-copy">
      © Repsol S.A. 2000 - 2026
    </div>
  </div>

</footer>
</body>
</html>

