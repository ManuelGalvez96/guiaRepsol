<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite(['resources/js/login.js'])
    <title>Guía Repsol - Login</title>
</head>

<body>
    <div class="login-header">
        <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        <a href="{{ route('home') }}" class="btn-close-header">✕</a>
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

            <!-- Formulario -->
            <form class="login-form" method="POST" action="{{ route('login.post') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul style="margin: 0;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-input">
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" required>
                        <button type="button" class="toggle-password">👁</button>
                    </div>
                    @error('password')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <a href="#" class="forgot-password">Olvidé mi contraseña</a>

                <button type="submit" class="btn-login">Iniciar Sesión</button>

                <div class="divider">
                    <span>o</span>
                </div>

                <button type="button" class="btn-social btn-facebook">
                    <span class="social-icon">f</span>
                    Acceder con Facebook
                </button>

                <button type="button" class="btn-social btn-google">
                    <span class="social-icon">G</span>
                    Acceder con Google
                </button>

                <button type="button" class="btn-social btn-apple">
                    <span class="social-icon"></span>
                    Acceder con Apple ID
                </button>
            </form>
            <hr>
            <div class="signup-link">
                ¿Necesitas una cuenta? <br><a href="{{ route('register') }}">Regístrate aquí</a>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalRepsol" tabindex="-1" aria-labelledby="modalRepsolLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRepsolLabel">¿Cuáles son las webs y apps de Repsol?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>Si tienes una cuenta en cualquiera de ellas, tienes una cuenta única de Repsol. Así, podrás
                            acceder a todas con el mismo correo electrónico y contraseña.</p>
                    </div>
                    <ul><span class="icono_modal">✓</span> Waylet, App de pagos</ul>
                    <ul><span class="icono_modal">✓</span> Repsol Vivit y Yrea Cliente de Luz y Gas</ul>
                    <ul><span class="icono_modal">✓</span> Pide tu Bombona y Pide tu Gasoleo</ul>
                    <ul><span class="icono_modal">✓</span> Box Repsol</ul>
                    <ul><span class="icono_modal">✓</span> Guía Repsol</ul>
                    <ul><span class="icono_modal">✓</span> Repsol.es y Tienda Online</ul>
                    <ul><span class="icono_modal">✓</span> Yrea profesional Mi Solred</ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>
