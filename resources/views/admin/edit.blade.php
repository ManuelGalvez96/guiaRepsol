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
    <h1>Editar Restaurante: {{ $restaurante->nombre }}</h1>
    <div class="container">
        <div id="alertContainer"></div>

        <form id="editRestauranteForm" action="{{ route('admin.update', $restaurante) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre del Restaurante *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $restaurante->nombre) }}"
                    >
                <span id="error-nombre" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion', $restaurante->descripcion) }}</textarea>
                <span id="error-descripcion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('descripcion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría *</label>
                <select id="categoria_id" name="categoria_id">
                    <option value="">Seleccione una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}"
                            {{ old('categoria_id', $restaurante->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                <span id="error-categoria" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('categoria_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="ubicacion_id">Ubicación *</label>
                <select id="ubicacion_id" name="ubicacion_id">
                    <option value="">Seleccione una ubicación</option>
                    @foreach ($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}"
                            {{ old('ubicacion_id', $restaurante->ubicacion_id) == $ubicacion->id ? 'selected' : '' }}>
                            {{ $ubicacion->ciudad }} - {{ $ubicacion->provincia }}
                            ({{ $ubicacion->comunidad_autonoma }})
                        </option>
                    @endforeach
                </select>
                <span id="error-ubicacion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('ubicacion_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="user_id">Gerente del Restaurante *</label>
                <select id="user_id" name="user_id" class="form-select">
                    <option value="">Seleccione un gerente</option>
                    @foreach ($gerentes as $gerente)
                        <option value="{{ $gerente->id }}"
                            {{ old('user_id', $restaurante->user_id) == $gerente->id ? 'selected' : '' }}>
                            {{ $gerente->name }} ({{ $gerente->email }})
                        </option>
                    @endforeach
                </select>
                <span id="error-gerente" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('user_id')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion"
                    value="{{ old('direccion', $restaurante->direccion) }}" >
                <span id="error-direccion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Tipos de Comida</label>
                <div class="tipos-comida-grid">
                    @foreach ($tiposComida as $tipo)
                        <label class="tipos-comida-label">
                            <input type="checkbox" name="tipos_comida[]" value="{{ $tipo->id }}"
                                {{ (is_array(old('tipos_comida')) && in_array($tipo->id, old('tipos_comida'))) ||
                                (!old('tipos_comida') && $restaurante->tiposComida->contains($tipo->id))
                                    ? 'checked'
                                    : '' }}
                                class="tipos-comida-checkbox">
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
                <input type="text" id="telefono" name="telefono"
                    value="{{ old('telefono', $restaurante->telefono) }}">
                <span id="error-telefono" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email', $restaurante->email) }}"
                    >
                <span id="error-email" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="web">Sitio Web</label>
                <input type="url" id="web" name="web" value="{{ old('web', $restaurante->web) }}">
                <span id="error-web" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('web')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio Promedio (€) *</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio', $restaurante->precio) }}"
                    step="0.01" >
                <span id="error-precio" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('precio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="soles">Soles Repsol (0-3)</label>
                <input type="number" id="soles" name="soles" value="{{ old('soles', $restaurante->soles) }}"
                    min="0" max="3">
                <span id="error-soles" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('soles')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="valoracion_promedio">Valoración (0-5)</label>
                <input type="number" id="valoracion_promedio" name="valoracion_promedio"
                    value="{{ old('valoracion_promedio', $restaurante->valoracion_promedio) }}" step="0.1"
                    min="0" max="5">
                <span id="error-valoracion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('valoracion_promedio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagenes">Imágenes del Restaurante</label>
                <div class="images-container" id="allImagesContainer"
                    style="display: flex; flex-wrap: wrap; gap: 15px; margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 6px; min-height: 140px;">
                    @if ($restaurante->imagenes->count() > 0)
                        @foreach ($restaurante->imagenes as $imagen)
                            <div class="current-image-item" data-imagen-id="{{ $imagen->id }}"
                                style="position: relative; text-align: center; border: 2px solid #ddd; border-radius: 8px; padding: 5px; background: white; max-width: 170px;">
                                <button type="button" class="btn-eliminar-imagen-existente"
                                    data-imagen-id="{{ $imagen->id }}"
                                    style="position: absolute; top: 3px; right: 3px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; z-index: 1000; box-shadow: 0 2px 6px rgba(0,0,0,0.3);"
                                    title="Eliminar imagen">×</button>
                                <img src="{{ asset($imagen->url) }}" alt="{{ $restaurante->nombre }}"
                                    style="width: 150px; height: 100px; object-fit: cover; border-radius: 5px; display: block;">
                                <small
                                    style="display: block; margin-top: 5px; color: #666; font-size: 11px;">{{ $imagen->principal ? 'Principal' : 'Adicional' }}</small>
                            </div>
                        @endforeach
                    @else
                        <p id="noImagesMessage" style="width: 100%; text-align: center; color: #999; margin: 20px 0;">
                            No hay imágenes. Selecciona algunas para añadir.</p>
                    @endif
                </div>
                <!-- Input oculto para enviar imágenes a eliminar -->
                <input type="hidden" name="imagenes_eliminar" id="imagenes_eliminar" value="">
                <div style="margin-top: 15px;">
                    <label for="imagenes"
                        style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">➕ Seleccionar
                        nuevas imágenes:</label>
                    <input type="file" id="imagenes" name="imagenes[]" accept="image/*" multiple
                        onchange="if(typeof previewImages === 'function') previewImages(event); if(typeof comprobarImagenes === 'function') comprobarImagenes();" style="margin-top: 5px;">
                </div>
                <span id="error-imagenes" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                @error('imagenes')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group" style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn btn-primary" id="submitBtn" style="flex: 1; padding: 10px 20px; background-color: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: background-color 0.3s;">Actualizar Restaurante</button>
                <button type="button" class="btn btn-secondary close-modal-btn" style="flex: 1; padding: 10px 20px; background-color: #95a5a6; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: background-color 0.3s;">Cancelar</button>
            </div>
        </form>
    </div>

    <!-- JavaScript separado para mejor mantenimiento -->
    <script>
        // Pasar configuración de PHP a JavaScript
        window.editConfig = {
            csrfToken: '{{ csrf_token() }}',
            adminIndexRoute: '{{ route('admin.index') }}'
        };

        // Array global para imágenes existentes a eliminar
        window.imagenesAEliminar = [];
    </script>
    <script src="{{ asset('js/validacion_admin_js/editar.js') }}"></script>
    <script src="{{ asset('js/admin_js/admin_edit.js') }}"></script>
</body>

</html>
