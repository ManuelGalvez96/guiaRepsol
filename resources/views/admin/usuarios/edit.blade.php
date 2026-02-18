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
        <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST" id="editUserForm" 
            enctype="multipart/form-data" style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
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

            <!-- Foto de Perfil -->
            <div class="mb-3">
                <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                
                <!-- Vista previa de la foto actual -->
                <div class="mb-2 text-center">
                    <img id="preview-foto" src="{{ $usuario->foto_perfil ? asset($usuario->foto_perfil) : asset('img/avatares/default-avatar.png') }}" 
                        alt="Foto de perfil" 
                        style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #ddd;">
                </div>
                
                <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" 
                    id="foto_perfil" name="foto_perfil" accept="image/jpeg,image/jpg,image/png,image/webp"
                    onchange="previewImage(event)">
                <small style="color: #666;">Formatos permitidos: JPG, PNG, WEBP. Máximo 5MB</small>
                <span id="error-foto" style="color: #e74c3c; font-size: 13px; display: block;"></span>
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
    
    <script>
        // Vista previa de la imagen seleccionada
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview-foto');
            const file = input.files[0];
            
            if (file) {
                // Validar tipo
                if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Formato no válido',
                        text: 'La imagen debe ser JPG, PNG o WEBP'
                    });
                    input.value = '';
                    return;
                }
                
                // Validar tamaño (5MB)
                if (file.size > 5120 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Imagen muy grande',
                        text: 'La imagen no puede exceder 5MB'
                    });
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
        
        // Manejo del formulario
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Guardar referencia al formulario
            const form = this;
            
            // Validar contraseñas si se proporcionaron
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirmation').value;
            
            if (password || passwordConfirm) {
                if (password !== passwordConfirm) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Las contraseñas no coinciden'
                    });
                    return;
                }
                
                if (password.length < 6) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'La contraseña debe tener al menos 6 caracteres'
                    });
                    return;
                }
            }
            
            // Confirmación antes de actualizar
            Swal.fire({
                title: '¿Actualizar usuario?',
                text: "Se guardarán los cambios realizados",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3498db',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar loading
                    Swal.fire({
                        title: 'Actualizando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Enviar formulario
                    const formData = new FormData(form);
                    
                    console.log('Form action:', form.action);
                    console.log('FormData entries:');
                    for (let pair of formData.entries()) {
                        console.log(pair[0], ':', pair[1]);
                    }
                    
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response ok:', response.ok);
                        if (!response.ok) {
                            return response.json().then(data => {
                                console.error('Error data:', data);
                                throw data;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Usuario actualizado!',
                                text: data.message || 'Los cambios se han guardado correctamente',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = '{{ route("admin.usuarios.index") }}';
                            });
                        } else if (data.errors) {
                            let errorMsg = '';
                            for (let field in data.errors) {
                                errorMsg += data.errors[field][0] + '\n';
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Errores de validación',
                                text: errorMsg
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'No se pudo actualizar el usuario'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error completo:', error);
                        let errorMessage = 'Ocurrió un error al actualizar el usuario';
                        
                        if (error.message) {
                            errorMessage = error.message;
                        } else if (error.errors) {
                            errorMessage = Object.values(error.errors).flat().join('\n');
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
