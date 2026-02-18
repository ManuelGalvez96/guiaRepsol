<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Usuario - Guía Repsol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body data-csrf="{{ csrf_token() }}">
    <!-- Header -->
    <div class="header">
        <div class="servicios-iconos">
            <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        </div>
    </div>

    <div class="container" style="margin: 30px auto; max-width: 600px;">
        <div style="margin-bottom: 30px;">
            <h1>Crear Nuevo Usuario</h1>
            <p style="color: #666;">Completa el formulario para crear un nuevo usuario en el sistema.</p>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>✗ Errores encontrados:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Formulario -->
        <form action="{{ route('admin.usuarios.store') }}" method="POST" id="createUserForm" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre <span style="color: #e74c3c;">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                    placeholder="Ej: Juan" value="{{ old('name') }}" required>
                <span id="error-name" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos <span style="color: #e74c3c;">*</span></label>
                <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" 
                    placeholder="Ej: García López" value="{{ old('apellidos') }}" required>
                <span id="error-apellidos" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email <span style="color: #e74c3c;">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                    placeholder="ejemplo@correo.com" value="{{ old('email') }}" required>
                <span id="error-email" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Rol -->
            <div class="mb-3">
                <label for="rol" class="form-label">Rol <span style="color: #e74c3c;">*</span></label>
                <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                    <option value="">Selecciona un rol</option>
                    <option value="administrador" {{ old('rol') === 'administrador' ? 'selected' : '' }}>👤 Administrador</option>
                    <option value="gerente" {{ old('rol') === 'gerente' ? 'selected' : '' }}>🏪 Gerente</option>
                    <option value="usuario" {{ old('rol') === 'usuario' ? 'selected' : '' }}>👥 Usuario</option>
                </select>
                <span id="error-rol" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña <span style="color: #e74c3c;">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" 
                    placeholder="Mínimo 6 caracteres" required>
                <small style="color: #666;">Mínimo 6 caracteres</small>
                <span id="error-password" style="color: #e74c3c; font-size: 13px; display: block;"></span>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña <span style="color: #e74c3c;">*</span></label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" 
                    placeholder="Repite la contraseña" required>
                <span id="error-password-confirm" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 10px; margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    ➕ Crear Usuario
                </button>
                <a href="{{ route('admin.usuarios.index') }}" class="btn btn-secondary" style="flex: 1;">
                    ← Volver
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
