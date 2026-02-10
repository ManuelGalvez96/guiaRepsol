<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Crear Restaurante - Guía Repsol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 500;
        }

        .logo::before {
            content: "☀️";
            font-size: 24px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-primary {
            background: #ffd500;
            color: #000;
        }

        .btn-primary:hover {
            background: #e6c000;
        }

        .btn-secondary {
            background: #fff;
            border: 1px solid #ddd;
            color: #000;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="header">
        <div class="logo">guia repsol</div>
    </div>

    <div class="container">
        <h1>Crear Nuevo Restaurante</h1>

        <form id="createRestauranteForm" action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div id="alertContainer"></div>

            <div class="form-group">
                <label for="nombre">Nombre del Restaurante *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría *</label>
                <select id="categoria_id" name="categoria_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                <select id="ubicacion_id" name="ubicacion_id" required style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;">
                    <option value="">Seleccione una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}" {{ old('ubicacion_id') == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->ciudad }} - {{ $ubicacion->provincia }} ({{ $ubicacion->comunidad_autonoma }})
                        </option>
                    @endforeach
                </select>
                @error('ubicacion_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Tipos de Comida</label>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; margin-top: 10px;">
                    @foreach($tiposComida as $tipo)
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input 
                                type="checkbox" 
                                name="tipos_comida[]" 
                                value="{{ $tipo->id }}"
                                {{ is_array(old('tipos_comida')) && in_array($tipo->id, old('tipos_comida')) ? 'checked' : '' }}
                                style="cursor: pointer;"
                            >
                            <span style="font-size: 14px; font-weight: normal;">{{ $tipo->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tipos_comida')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="web">Sitio Web</label>
                <input type="url" id="web" name="web" value="{{ old('web') }}">
                @error('web')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio Promedio (€) *</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio') }}" step="0.01" required>
                @error('precio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="soles">Soles Repsol (0-3)</label>
                <input type="number" id="soles" name="soles" value="{{ old('soles', 0) }}" min="0" max="3">
                @error('soles')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="valoracion_promedio">Valoración (0-5)</label>
                <input type="number" id="valoracion_promedio" name="valoracion_promedio" value="{{ old('valoracion_promedio') }}" step="0.1" min="0" max="5">
                @error('valoracion_promedio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary" id="submitBtn">Crear Restaurante</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        const form = document.getElementById('createRestauranteForm');
        const submitBtn = document.getElementById('submitBtn');
        const alertContainer = document.getElementById('alertContainer');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Limpiar errores previos
            document.querySelectorAll('.error').forEach(el => el.remove());
            alertContainer.innerHTML = '';
            
            // Mostrar estado de carga
            submitBtn.textContent = 'Creando...';
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
                        title: '¡Éxito!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    
                    // Limpiar formulario
                    form.reset();
                    
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
                        text: error.message || 'Error al crear el restaurante'
                    });
                }
                
                // Restaurar botón
                submitBtn.textContent = 'Crear Restaurante';
                submitBtn.disabled = false;
                form.classList.remove('loading');
            });
        });

        // No necesitamos la función showAlert ya que usamos SweetAlert directamente
    </script>
</body>
</html>
