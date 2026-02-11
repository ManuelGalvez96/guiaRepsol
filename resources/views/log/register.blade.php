<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <title>Guía Repsol - Registro</title>
</head>

<body>
    <div class="login-header">
        <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        <a href="{{ route('home') }}" class="btn-close-header">✕</a>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2 class="login-title">Crea tu cuenta Repsol</h2>

            <!-- Formulario -->
            <form class="login-form" method="POST" action="{{ route('login.post') }}">
                @csrf
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
                <div class="divider">
                    <span>o</span>
                </div>

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
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre"
                        class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" id="apellidos" name="apellidos"
                        class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}"
                        required>
                    @error('apellidos')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

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
                    </div>
                    @error('password')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <div class="password-input">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" required>
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger" style="font-size: 12px;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Registrarse</button>

            </form>
            <hr>
            <div class="signup-link">
                ¿Ya tienes una cuenta? <br><a href="{{ route('login') }}">Inicia sesión</a>
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

