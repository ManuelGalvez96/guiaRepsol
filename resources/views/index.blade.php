<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Soletes | Guía Repsol</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

:root{
  --blue:#0b1c3d;
  --blue-line:#102b66;
  --yellow:#ffd200;
  --black:#1c1c1c;
  --gray:#6b6b6b;
  --teal:#007a8c;
}

body{
  font-family:'Montserrat',sans-serif;
  color:var(--black);
}

/* ===== TOP BAR ===== */
.topbar{
  background:#fff;
}

.topbar-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  height:56px;
  display:flex;
  align-items:center;
  justify-content:space-between;
}

.top-left{
  display:flex;
  align-items:center;
  gap:20px;
}

.burger{
  font-size:22px;
}

.logo{
  font-weight:700;
  font-size:22px;
}

.nav a{
  margin:0 14px;
  text-decoration:none;
  color:var(--black);
  font-weight:500;
}

.nav a.active{
  color:var(--teal);
}

.top-right{
  display:flex;
  align-items:center;
  gap:20px;
}

/* ===== BLUE SEPARATOR ===== */
.blue-line{
  height:6px;
  background:var(--blue-line);
}

/* ===== EVENT BAR ===== */
.event-bar{
  background:var(--blue);
  color:#fff;
}

.event-inner{
  max-width:1440px;
  margin:0 auto;
  padding:14px 32px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  font-size:14px;
}

.event-right{
  display:flex;
  align-items:center;
  gap:20px;
}

.event-btn{
  background:#cceef2;
  color:#003b44;
  padding:8px 14px;
  border-radius:6px;
  font-weight:600;
}

/* ===== SUBNAV ===== */
.subnav{
  background:var(--yellow);
}

.subnav-inner{
  max-width:1440px;
  margin:0 auto;
  padding:16px 32px;
  display:flex;
  gap:28px;
  font-weight:500;
}

/* ===== HERO ===== */
.hero{
  max-width:1440px;
  margin:0 auto;
  padding:64px 32px;
  display:grid;
  grid-template-columns:1.1fr 1fr;
  gap:64px;
  align-items:center;
}

.hero-eyebrow{
  font-size:14px;
  color:var(--gray);
  margin-bottom:12px;
}

.hero h1{
  font-size:44px;
  line-height:1.15;
  margin-bottom:20px;
}

.hero p{
  font-size:16px;
  color:#444;
  line-height:1.6;
  margin-bottom:16px;
}

.hero-author{
  font-size:14px;
  margin-bottom:28px;
}

.hero-btn{
  display:inline-flex;
  align-items:center;
  gap:10px;
  background:var(--teal);
  color:#fff;
  padding:12px 22px;
  border-radius:8px;
  font-weight:600;
  text-decoration:none;
}

.hero-img img{
  width:100%;
  border-radius:16px;
  object-fit:cover;
}

/* ===== MOMENTOS ===== */
.momentos{
  background:#fbf6e2;
  padding:96px 0 120px;
}

.momentos-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
}

.momentos-title{
  text-align:center;
  font-size:36px;
  font-weight:700;
  margin-bottom:64px;
  position:relative;
  display:inline-block;
  left:50%;
  transform:translateX(-50%);
}

.momentos-title span{
  position:absolute;
  bottom:-8px;
  left:20%;
  width:60%;
  height:6px;
  background:#ffd200;
  border-radius:4px;
}

.momentos-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:32px;
}

.momento-card{
  border-radius:18px;
  overflow:hidden;
}

.momento-img{
  position:relative;
  height:520px;
}

.momento-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.momento-icons{
  position:absolute;
  top:16px;
  right:16px;
  color:#fff;
  font-size:18px;
  display:flex;
  gap:12px;
}

.momento-overlay{
  position:absolute;
  bottom:0;
  left:0;
  right:0;
  padding:32px 24px;
  background:linear-gradient(
    to top,
    rgba(0,0,0,0.75),
    rgba(0,0,0,0)
  );
  color:#fff;
}

.momento-tag{
  font-size:13px;
  margin-bottom:10px;
  opacity:.9;
}

.momento-overlay h3{
  font-size:22px;
  line-height:1.25;
  margin-bottom:8px;
}

.momento-overlay p{
  font-size:14px;
  opacity:.9;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .momentos-grid{grid-template-columns:1fr}
  .momento-img{height:420px}
}

/* ===== QUÉ SON LOS SOLETES ===== */
.que-son{
  background:#fbf6e2;
  padding:120px 0;
}

.que-son-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  text-align:center;
}

.que-son-title{
  font-size:36px;
  font-weight:700;
  margin-bottom:32px;
  position:relative;
  display:inline-block;
}

.que-son-title span{
  position:absolute;
  bottom:-8px;
  left:20%;
  width:60%;
  height:6px;
  background:#ffd200;
  border-radius:4px;
}

.que-son-text{
  max-width:820px;
  margin:0 auto 96px;
  font-size:16px;
  line-height:1.7;
  color:#444;
}

/* ===== GRID CATEGORÍAS (LAYOUT REAL) ===== */
.categorias{
  display:grid;
  grid-template-columns:repeat(12, 1fr);
  gap:72px 48px;
}

/* PRIMERA FILA → 4 iconos */
.categoria:nth-child(1),
.categoria:nth-child(2),
.categoria:nth-child(3),
.categoria:nth-child(4){
  grid-column:span 3;
}

/* SEGUNDA FILA → 3 iconos CENTRADOS */
.categoria:nth-child(5){
  grid-column:3 / span 3;
}

.categoria:nth-child(6){
  grid-column:6 / span 3;
}

.categoria:nth-child(7){
  grid-column:9 / span 3;
}
.icono{
  font-size:64px;   /* prueba 64px – 68px según gusto */
}
/* ===== TUS SOLETES CERCANOS ===== */
.cercanos{
  background:#fbf6e2;
  padding:120px 0;
}

.cercanos-box{
  max-width:1440px;
  margin:0 auto;
  background:#fff;
  border-radius:24px;
  padding:48px 48px 56px;
}

/* HEADER */
.cercanos-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:32px;
}

.cercanos-header h2{
  font-size:28px;
  font-weight:700;
}

.location-btn{
  background:#f5f7f8;
  border:none;
  padding:10px 16px;
  border-radius:20px;
  font-weight:500;
  cursor:pointer;
}

/* FILTERS */
.cercanos-filters{
  display:flex;
  gap:12px;
  flex-wrap:wrap;
  margin-bottom:32px;
}

.filter-pill{
  background:#fff;
  border:1px solid #e1e1e1;
  padding:10px 16px;
  border-radius:20px;
  font-weight:500;
  cursor:pointer;
}

.filter-pill.active{
  background:#0b1c3d;
  color:#fff;
  border-color:#0b1c3d;
}

/* CARDS */
.cercanos-cards{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:24px;
}

.local-card{
  background:#fff;
  border-radius:16px;
  overflow:hidden;
  box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.local-card img{
  width:100%;
  height:200px;
  object-fit:cover;
}

.local-info{
  padding:16px;
}

.local-info h3{
  font-size:18px;
  font-weight:600;
  margin-bottom:6px;
}

.local-info p{
  font-size:14px;
  color:#555;
  margin-bottom:8px;
}

.solete{
  font-size:13px;
  color:#777;
}

/* DOTS */
.cercanos-dots{
  display:flex;
  justify-content:center;
  gap:8px;
  margin:32px 0;
}

.dot{
  width:8px;
  height:8px;
  border-radius:50%;
  background:#ddd;
}

.dot.active{
  background:#ffd200;
}

/* CTA */
.cercanos-cta{
  text-align:center;
}

.ver-mas{
  background:#007a8c;
  color:#fff;
  border:none;
  padding:14px 28px;
  border-radius:8px;
  font-size:16px;
  font-weight:600;
  cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .cercanos-cards{
    grid-template-columns:repeat(2,1fr);
  }
}

@media(max-width:600px){
  .cercanos-cards{
    grid-template-columns:1fr;
  }
}
/* ===== LO ÚLTIMO SOBRE SOLETES ===== */
.ultimo{
  background:#fff;
  padding:120px 0;
}

.ultimo-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
}

.ultimo-title{
  text-align:center;
  font-size:36px;
  font-weight:700;
  margin-bottom:64px;
}

/* FEATURED */
.ultimo-featured{
  display:grid;
  grid-template-columns:1.2fr 1fr;
  background:#fff;
  border-radius:20px;
  overflow:hidden;
  box-shadow:0 12px 32px rgba(0,0,0,.08);
  margin-bottom:72px;
}

.featured-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}

.featured-content{
  padding:48px;
  display:flex;
  flex-direction:column;
  justify-content:center;
}

.featured-tag{
  font-size:14px;
  color:#444;
  margin-bottom:16px;
}

.featured-content h3{
  font-size:34px;
  line-height:1.2;
  margin-bottom:16px;
}

.featured-place{
  font-size:15px;
  color:#666;
  margin-bottom:32px;
}

.featured-actions{
  font-size:18px;
  color:#0b1c3d;
}

/* GRID */
.ultimo-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:32px;
  margin-bottom:72px;
}

.ultimo-card{
  background:#fff;
  border-radius:16px;
  overflow:hidden;
  box-shadow:0 8px 24px rgba(0,0,0,.08);
}

.ultimo-card img{
  width:100%;
  height:220px;
  object-fit:cover;
}

.card-content{
  padding:24px;
}

.card-tag{
  font-size:13px;
  color:#444;
  display:block;
  margin-bottom:12px;
}

.card-content h4{
  font-size:18px;
  line-height:1.3;
  margin-bottom:12px;
}

.card-content p{
  font-size:14px;
  color:#666;
  margin-bottom:20px;
}

.card-actions{
  font-size:16px;
  color:#0b1c3d;
}

/* CTA */
.ultimo-cta{
  text-align:center;
}

.ultimo-cta button{
  background:#007a8c;
  color:#fff;
  border:none;
  padding:16px 36px;
  border-radius:10px;
  font-size:16px;
  font-weight:600;
  cursor:pointer;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .ultimo-featured{
    grid-template-columns:1fr;
  }

  .ultimo-grid{
    grid-template-columns:repeat(2,1fr);
  }
}

@media(max-width:600px){
  .ultimo-grid{
    grid-template-columns:1fr;
  }

  .featured-content h3{
    font-size:26px;
  }
}
/* ===== APP SECTION ===== */
.app-section{
  background:#fff;
  padding:120px 0;
}

.app-box{
  max-width:1440px;
  margin:0 auto;
  background:#0b1c3d;
  border-radius:24px;
  padding:72px 80px;
  display:grid;
  grid-template-columns:1.1fr 1fr;
  align-items:center;
  gap:64px;
}

/* TEXTO */
.app-content h2{
  font-size:36px;
  font-weight:700;
  color:#fff;
  margin-bottom:16px;
}

.app-content p{
  font-size:16px;
  color:#e0e6f0;
  margin-bottom:32px;
}

.app-btn{
  display:inline-block;
  background:#fff;
  color:#007a8c;
  padding:14px 28px;
  border-radius:10px;
  font-weight:600;
  text-decoration:none;
}

/* MOCKUP */
.app-mockup{
  position:relative;
  display:flex;
  justify-content:center;
}

.phone{
  position:relative;
  width:280px;
}

.phone img{
  width:100%;
  border-radius:28px;
  display:block;
}

/* FLOATING CARDS */
.float-card{
  position:absolute;
  background:#fff;
  padding:14px 16px;
  border-radius:12px;
  box-shadow:0 8px 24px rgba(0,0,0,.2);
  font-size:13px;
  width:150px;
}

.float-card span{
  font-size:20px;
  display:block;
  margin-bottom:6px;
}

.float-card.left{
  top:60px;
  left:-120px;
}

.float-card.center{
  top:160px;
  right:-90px;
}

.float-card.right{
  bottom:80px;
  right:-110px;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .app-box{
    grid-template-columns:1fr;
    text-align:center;
  }

  .app-mockup{
    margin-top:48px;
  }

  .float-card{
    display:none;
  }
}

@media(max-width:600px){
  .app-box{
    padding:56px 32px;
  }

  .app-content h2{
    font-size:28px;
  }
}
/* ===== DESTACADO ===== */
.destacado{
  background:#fff;
  padding:120px 0;
}

.destacado-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
}

.destacado-title{
  text-align:center;
  font-size:36px;
  font-weight:700;
  margin-bottom:72px;
  position:relative;
  display:inline-block;
  left:50%;
  transform:translateX(-50%);
}

.destacado-title span{
  position:absolute;
  bottom:-8px;
  left:25%;
  width:50%;
  height:6px;
  background:#ffd200;
  border-radius:4px;
}

/* GRID */
.destacado-grid{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:32px;
}

.destacado-item img{
  width:100%;
  height:520px;
  object-fit:cover;
  border-radius:20px;
  display:block;
}

.destacado-item h3{
  margin-top:16px;
  font-size:18px;
  font-weight:600;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .destacado-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .destacado-item img{
    height:420px;
  }
}

@media(max-width:600px){
  .destacado-grid{
    grid-template-columns:1fr;
  }

  .destacado-item img{
    height:360px;
  }
}
/* ===== SOLETES PARA COMBATIR EL FRÍO ===== */
.frio{
  background:#fff;
  padding:120px 0;
}

.frio-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  text-align:center;
}

.frio-title{
  font-size:36px;
  font-weight:700;
  margin-bottom:16px;
  position:relative;
  display:inline-block;
}

.frio-title span{
  position:absolute;
  bottom:-8px;
  left:20%;
  width:60%;
  height:6px;
  background:#ffd200;
  border-radius:4px;
}

.frio-subtitle{
  font-size:16px;
  color:#555;
  margin-bottom:64px;
}

/* GRID */
.frio-grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:32px;
}

/* CARD */
.frio-card{
  border-radius:18px;
  overflow:hidden;
}

.frio-img{
  position:relative;
  height:520px;
}

.frio-img img{
  width:100%;
  height:100%;
  object-fit:cover;
}

/* ICONOS */
.frio-icons{
  position:absolute;
  top:16px;
  right:16px;
  color:#fff;
  font-size:18px;
  display:flex;
  gap:12px;
  z-index:2;
}

/* OVERLAY */
.frio-overlay{
  position:absolute;
  bottom:0;
  left:0;
  right:0;
  padding:32px 24px;
  background:linear-gradient(
    to top,
    rgba(0,0,0,0.8),
    rgba(0,0,0,0.1)
  );
  color:#fff;
  text-align:left;
}

.frio-tag{
  font-size:13px;
  margin-bottom:12px;
  display:block;
  opacity:.9;
}

.frio-overlay h3{
  font-size:22px;
  line-height:1.25;
  margin-bottom:10px;
}

.frio-overlay p{
  font-size:14px;
  opacity:.9;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .frio-grid{
    grid-template-columns:1fr;
  }

  .frio-img{
    height:420px;
  }
}
/* ===== COMUNIDADES ===== */
.comunidades{
  background:#fff;
  padding:120px 0 140px;
}

.comunidades-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
}

.comunidades-title{
  text-align:center;
  font-size:36px;
  font-weight:700;
  margin-bottom:72px;
  position:relative;
  display:inline-block;
  left:50%;
  transform:translateX(-50%);
}

.comunidades-title span{
  position:absolute;
  bottom:-8px;
  left:25%;
  width:50%;
  height:6px;
  background:#ffd200;
  border-radius:4px;
}

/* GRID */
.comunidades-grid{
  display:grid;
  grid-template-columns:repeat(5,1fr);
  gap:28px;
}

/* CARD */
.comunidad img{
  width:100%;
  height:420px;
  object-fit:cover;
  border-radius:14px;
  display:block;
}

.comunidad h3{
  margin-top:16px;
  font-size:18px;
  font-weight:600;
}

/* CTA */
.comunidades-cta{
  margin-top:72px;
  text-align:center;
}

.btn-comunidades{
  display:inline-block;
  background:var(--teal);
  color:#fff;
  padding:14px 28px;
  border-radius:10px;
  font-weight:600;
  text-decoration:none;
}

/* RESPONSIVE */
@media(max-width:1200px){
  .comunidades-grid{
    grid-template-columns:repeat(3,1fr);
  }
}

@media(max-width:768px){
  .comunidades-grid{
    grid-template-columns:repeat(2,1fr);
  }

  .comunidad img{
    height:360px;
  }
}

@media(max-width:480px){
  .comunidades-grid{
    grid-template-columns:1fr;
  }
}
/* ===== FOOTER ===== */
.footer{
  background:#0b1c3d;
  color:#fff;
}

/* NEWSLETTER */
.footer-newsletter{
  padding:64px 0;
  border-bottom:1px solid rgba(255,255,255,.15);
}

.footer-newsletter-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:40px;
}

.newsletter-text h3{
  font-size:28px;
  margin-bottom:8px;
}

.newsletter-text p{
  font-size:16px;
  opacity:.9;
}

.newsletter-form{
  display:flex;
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  min-width:420px;
}

.newsletter-form input{
  border:none;
  padding:16px;
  flex:1;
  font-size:15px;
  outline:none;
}

.newsletter-form button{
  background:#cceef2;
  border:none;
  padding:0 28px;
  font-weight:600;
  cursor:pointer;
}

/* MAIN */
.footer-main{
  padding:80px 0;
  border-bottom:1px solid rgba(255,255,255,.15);
}

.footer-main-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  display:grid;
  grid-template-columns:1fr 2fr;
  gap:80px;
}

.footer-brand span{
  font-size:28px;
  font-style:italic;
}

.footer-cols{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:64px;
}

.footer-col h4{
  font-size:18px;
  margin-bottom:20px;
}

.footer-col a{
  display:block;
  color:#fff;
  text-decoration:none;
  margin-bottom:12px;
  opacity:.85;
}

.footer-col a:hover{
  opacity:1;
}

/* BOTTOM */
.footer-bottom{
  padding:32px 0 24px;
}

.footer-bottom-inner{
  max-width:1440px;
  margin:0 auto;
  padding:0 32px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  gap:24px;
}

.footer-legal a{
  color:#fff;
  text-decoration:none;
  font-size:14px;
  opacity:.85;
}

.footer-legal span{
  margin:0 8px;
  opacity:.5;
}

.footer-social span{
  margin-left:18px;
  font-size:18px;
  cursor:pointer;
}

.footer-copy{
  margin-top:16px;
  padding:0 32px;
  font-size:13px;
  opacity:.75;
}

/* RESPONSIVE */
@media(max-width:1024px){
  .footer-newsletter-inner,
  .footer-main-inner,
  .footer-bottom-inner{
    flex-direction:column;
    align-items:flex-start;
  }

  .newsletter-form{
    width:100%;
    min-width:auto;
  }

  .footer-cols{
    grid-template-columns:1fr;
  }
}

</style>
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
    <div class="top-right">
      🔍 Acceso
    </div>
  </div>
</div>

<!-- BLUE LINE -->
<div class="blue-line"></div>

<!-- EVENT BAR -->
<section class="event-bar">
  <div class="event-inner">
    <div>Vive la Gala de los Soles 2026 · 7d · 4h · 28m · 34s</div>
    <div class="event-right">
      <div>Todo sobre la Gala ›</div>
      <div class="event-btn">Añadir al calendario</div>
    </div>
  </div>
</section>

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
    <img src="https://picsum.photos/900/700?cocktail">
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
          <img src="https://picsum.photos/700/900?churros">
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
          <img src="https://picsum.photos/700/900?bar">
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
          <img src="https://picsum.photos/700/900?ramen">
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
        <img src="https://picsum.photos/500/350?food1">
        <div class="local-info">
          <h3>Miga Cana</h3>
          <p>Bar · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="https://picsum.photos/500/350?food2">
        <div class="local-info">
          <h3>Kitchen 154</h3>
          <p>Restaurante · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="https://picsum.photos/500/350?food3">
        <div class="local-info">
          <h3>Batch</h3>
          <p>Bar · Madrid, España</p>
          <span class="solete">● Solete · €</span>
        </div>
      </article>

      <article class="local-card">
        <img src="https://picsum.photos/500/350?food4">
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
        <img src="https://picsum.photos/900/600?coffee">
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
        <img src="https://picsum.photos/400/300?bar">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>El bar donde los actores toman el vermú con la gente del barrio</h4>
          <p>‘Merinas’, el bar de tres conocidas actrices en Carabanchel</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="https://picsum.photos/400/300?books">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>Soletes para celebrar la Feria del libro a cualquier hora del día</h4>
          <p>Dónde comer barato cerca del Parque del Retiro (Madrid)</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="https://picsum.photos/400/300?dog">
        <div class="card-content">
          <span class="card-tag">ψ Reportaje gastronómico</span>
          <h4>Seis mesas cántabras en la mejor compañía</h4>
          <p>Dónde desayunar, comer y tomar algo en Cantabria con tu mascota</p>
          <div class="card-actions">♡ ⤴ 🔖</div>
        </div>
      </article>

      <article class="ultimo-card">
        <img src="https://picsum.photos/400/300?galicia">
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
        <img src="https://picsum.photos/600/800?cafe">
        <h3>Cafeterías</h3>
      </article>

      <article class="destacado-item">
        <img src="https://picsum.photos/600/800?bar">
        <h3>Bares</h3>
      </article>

      <article class="destacado-item">
        <img src="https://picsum.photos/600/800?pizza">
        <h3>Fast Good</h3>
      </article>

      <article class="destacado-item">
        <img src="https://picsum.photos/600/800?wine">
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
          <img src="https://picsum.photos/700/900?soup">
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
          <img src="https://picsum.photos/700/900?chocolate">
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
          <img src="https://picsum.photos/700/900?people">
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
        <img src="https://picsum.photos/500/650?madrid">
        <h3>Madrid</h3>
      </article>

      <article class="comunidad">
        <img src="https://picsum.photos/500/650?catalunya">
        <h3>Catalunya</h3>
      </article>

      <article class="comunidad">
        <img src="https://picsum.photos/500/650?valencia">
        <h3>Comunitat Valenciana</h3>
      </article>

      <article class="comunidad">
        <img src="https://picsum.photos/500/650?extremadura">
        <h3>Extremadura</h3>
      </article>

      <article class="comunidad">
        <img src="https://picsum.photos/500/650?euskadi">
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
