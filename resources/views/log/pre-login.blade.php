<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Guía Repsol - Login</title>
</head>

<body>
    <div class="login-header">
        <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        <a href="{{ url('/') }}" class="btn-close-header">✕</a>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2 class="login-title">Accede con tu cuenta</h2>
            <p class="login-description">
                Accede con tu correo electrónico y contraseña o mediante redes sociales. Recuerda que puedes utilizar la
                misma
                cuenta que empleas para
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalRepsol" class="link-repsol">webs y apps
                    de Repsol.</a>
            </p>

            <!-- Iconos de servicios -->
            <div class="servicios-iconos">
                <img src="{{ asset('img/Aplicaciones_repsol.png') }}" alt="Aplicaciones Repsol">
            </div>
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <button type="submit" class="btn-login">Iniciar Sesion</button>
            </form>
            <div class="divider">
                <span>o</span>
            </div>
            <!-- Formulario -->
            <form class="login-form" method="POST" action="{{ route('login') }}">
                @csrf
                <button type="submit" class="btn-login">Iniciar Sesion</button>
            </form>
            <br>
            <form class="login-form" method="POST" action="{{ route('register') }}">
                @csrf
                <button type="submit" class="btn-login">Crear una cuenta</button>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>
