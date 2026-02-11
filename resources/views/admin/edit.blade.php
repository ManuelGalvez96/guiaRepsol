<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Editar Restaurante - Guía Repsol</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="header">
        <div class="logo">guia repsol</div>
    </div>

    <div class="container">
        <h1>Editar Restaurante: {{ $restaurante->nombre }}</h1>

        <div id="alertContainer"></div>

        <form id="editRestauranteForm" action="{{ route('admin.update', $restaurante) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre del Restaurante *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $restaurante->nombre) }}" required>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion', $restaurante->descripcion) }}</textarea>
                @error('descripcion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría *</label>
                <select id="categoria_id" name="categoria_id" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $restaurante->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ubicacion_id">Ubicación *</label>
                <select id="ubicacion_id" name="ubicacion_id" required>
                    <option value="">Seleccione una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id', $restaurante->ubicacion_id) == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->ciudad }} - {{ $ubicacion->provincia }} ({{ $ubicacion->comunidad_autonoma }})
                        </option>
                    @endforeach
                </select>
                @error('ubicacion_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_id">Gerente del Restaurante *</label>
                <select id="user_id" name="user_id" required class="form-select">
                    <option value="">Seleccione un gerente</option>
                    @foreach($gerentes as $gerente)
                        <option value="{{ $gerente->id }}" {{ old('user_id', $restaurante->user_id) == $gerente->id ? 'selected' : '' }}>
                            {{ $gerente->name }} ({{ $gerente->email }})
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $restaurante->direccion) }}" required>
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Tipos de Comida</label>
                <div class="tipos-comida-grid">
                    @foreach($tiposComida as $tipo)
                        <label class="tipos-comida-label">
                            <input 
                                type="checkbox" 
                                name="tipos_comida[]" 
                                value="{{ $tipo->id }}"
                                {{ (is_array(old('tipos_comida')) && in_array($tipo->id, old('tipos_comida'))) || 
                                   (!old('tipos_comida') && $restaurante->tiposComida->contains($tipo->id)) ? 'checked' : '' }}
                                class="tipos-comida-checkbox"
                            >
                            <span class="tipos-comida-text">{{ $tipo->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tipos_comida')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $restaurante->telefono) }}">
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $restaurante->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="web">Sitio Web</label>
                <input type="url" id="web" name="web" value="{{ old('web', $restaurante->web) }}">
                @error('web')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio Promedio (€) *</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio', $restaurante->precio) }}" step="0.01" required>
                @error('precio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="soles">Soles Repsol (0-3)</label>
                <input type="number" id="soles" name="soles" value="{{ old('soles', $restaurante->soles) }}" min="0" max="3">
                @error('soles')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="valoracion_promedio">Valoración (0-5)</label>
                <input type="number" id="valoracion_promedio" name="valoracion_promedio" value="{{ old('valoracion_promedio', $restaurante->valoracion_promedio) }}" step="0.1" min="0" max="5">
                @error('valoracion_promedio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del Restaurante</label>
                @if($restaurante->imagenes->first())
                    <div class="current-image">
                        <p class="current-image-text">Imagen actual:</p>
                        <img src="{{ asset('storage/' . $restaurante->imagenes->first()->url) }}" alt="{{ $restaurante->nombre }}">
                    </div>
                @endif
                <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)" class="mt-10">
                @error('imagen')
                    <div class="error">{{ $message }}</div>
                @enderror
                <div class="image-preview" id="imagePreview">
                    <img id="preview" src="" alt="Vista previa">
                </div>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">Actualizar Restaurante</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('editRestauranteForm');
        const submitBtn = document.getElementById('submitBtn');
        const alertContainer = document.getElementById('alertContainer');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Función para previsualizar imagen
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('imagePreview').classList.add('active');
                    document.getElementById('imagePreview').style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Limpiar errores previos
            document.querySelectorAll('.error').forEach(el => el.remove());
            alertContainer.innerHTML = '';
            
            // Mostrar estado de carga
            submitBtn.textContent = 'Actualizando...';
            submitBtn.disabled = true;
            form.classList.add('loading');
            
            // Preparar datos del formulario
            const formData = new FormData(form);
            
            // Enviar petición AJAX
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw data;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito con SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    // Redirigir después de 1.5 segundos
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.index") }}';
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Mostrar errores de validación
                if (error.errors) {
                    Object.keys(error.errors).forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'error';
                            errorDiv.textContent = error.errors[field][0];
                            input.parentNode.appendChild(errorDiv);
                        }
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de validación',
                        text: 'Por favor corrige los errores en el formulario',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al actualizar el restaurante'
                    });
                }
                
                // Restaurar botón
                submitBtn.textContent = 'Actualizar Restaurante';
                submitBtn.disabled = false;
                form.classList.remove('loading');
            });
        });

        // No necesitamos la función showAlert ya que usamos SweetAlert directamente
    </script>
</body>
</html>
