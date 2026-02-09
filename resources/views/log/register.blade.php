<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Guía Repsol - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <div class="login-header">
        <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        <a href="{{ route('welcome') }}" class="btn-close-header">✕</a>
    </div>

    <div class="login-container">
        <div class="login-box">
            <h2 class="login-title">Crea tu cuenta</h2>
            <p class="login-description">
                Completa los campos para crear una nueva cuenta y acceder a todos nuestros servicios.
            </p>

            <!-- Formulario de registro -->
            <form class="login-form" method="POST" action="{{ route('register.post') }}">
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
                    <label for="name">Nombre completo</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-input">
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        <button type="button" class="toggle-password">👁</button>
                    </div>
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <div class="password-input">
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required>
                        <button type="button" class="toggle-password">👁</button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login">Crear cuenta</button>

                <div class="divider">
                    <span>o</span>
                </div>

                <button type="button" class="btn-social btn-facebook">
                    <span class="social-icon">f</span>
                    Registrarse con Facebook
                </button>

                <button type="button" class="btn-social btn-google">
                    <span class="social-icon">G</span>
                    Registrarse con Google
                </button>

                <button type="button" class="btn-social btn-apple">
                    <span class="social-icon"></span>
                    Registrarse con Apple ID
                </button>
            </form>

            <div class="signup-link">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
            </div>
        </div>
    </div>

</body>

</html>
