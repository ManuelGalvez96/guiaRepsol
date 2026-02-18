<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Usuario - Guía Repsol</title>
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
            <h1>Editar Usuario</h1>
            <p style="color: #666;">Actualiza los datos del usuario: <strong>{{ $usuario->name }} {{ $usuario->apellidos }}</strong></p>
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
        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" id="editUserForm" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @csrf
            @method('PUT')

            <!-- ID del usuario (solo lectura) -->
            <div class="mb-3">
                <label class="form-label">ID de Usuario</label>
                <input type="text" class="form-control" value="{{ $usuario->id }}" disabled>
                <small style="color: #666;">Este campo no se puede cambiar</small>
            </div>

            <!-- Nombre -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre <span style="color: #e74c3c;">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                    placeholder="Ej: Juan" value="{{ old('name', $usuario->name) }}" required>
                <span id="error-name" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Apellidos -->
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos <span style="color: #e74c3c;">*</span></label>
                <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" 
                    placeholder="Ej: García López" value="{{ old('apellidos', $usuario->apellidos) }}" required>
                <span id="error-apellidos" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email <span style="color: #e74c3c;">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                    placeholder="ejemplo@correo.com" value="{{ old('email', $usuario->email) }}" required>
                <small style="color: #666;">Email actual: {{ $usuario->email }}</small>
                <span id="error-email" style="color: #e74c3c; font-size: 13px; display: block;"></span>
            </div>

            <!-- Rol -->
            <div class="mb-3">
                <label for="rol" class="form-label">Rol <span style="color: #e74c3c;">*</span></label>
                <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                    <option value="" disabled>Selecciona un rol</option>
                    <option value="administrador" {{ old('rol', $usuario->rol) === 'administrador' ? 'selected' : '' }}>👤 Administrador</option>
                    <option value="gerente" {{ old('rol', $usuario->rol) === 'gerente' ? 'selected' : '' }}>🏪 Gerente</option>
                    <option value="usuario" {{ old('rol', $usuario->rol) === 'usuario' ? 'selected' : '' }}>👥 Usuario</option>
                </select>
                <span id="error-rol" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Información de registro -->
            <div class="mb-3" style="background: #f8f9fa; padding: 15px; border-radius: 6px;">
                <small style="color: #666;">
                    <strong>Registrado:</strong> {{ $usuario->created_at->format('d/m/Y H:i') }}<br>
                    <strong>Última actualización:</strong> {{ $usuario->updated_at->format('d/m/Y H:i') }}
                </small>
            </div>

            <hr>

            <h5 style="margin-top: 25px; margin-bottom: 15px;">Cambiar Contraseña <span style="font-size: 12px; color: #999;">(Opcional)</span></h5>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Nueva Contraseña</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" 
                    placeholder="Déjalo en blanco para mantener la contraseña actual">
                <small style="color: #666;">Mínimo 6 caracteres. Déjalo vacío si no quieres cambiar la contraseña.</small>
                <span id="error-password" style="color: #e74c3c; font-size: 13px; display: block;"></span>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" 
                    placeholder="Repite la contraseña">
                <span id="error-password-confirm" style="color: #e74c3c; font-size: 13px;"></span>
            </div>

            <!-- Botones -->
            <div style="display: flex; gap: 10px; margin-top: 25px;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">
                    ✓ Actualizar Usuario
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
