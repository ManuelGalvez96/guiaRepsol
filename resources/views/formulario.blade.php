<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dar a conocer mi negocio | Guía Repsol</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/soletes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulario.css') }}">
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="topbar-inner">
        <div class="top-left">
            <div class="burger" onclick="window.location.href='/'" style="cursor: pointer;">☰</div>
            <div class="logo" onclick="window.location.href='/'" style="cursor: pointer;">guía repsol</div>
            <nav class="nav">
                <a href="/">Inicio</a>
                <a href="#" class="active">Registro de Negocio</a>
            </nav>
        </div>
        <div class="top-right" onclick="window.location.href='{{ route('login') }}'" style="cursor: pointer;">Acceso</div>
    </div>
</div>

<!-- BLUE LINE -->
<div class="blue-line"></div>

<!-- FORMULARIO -->
<div class="form-container">
    <div class="form-header">
        <h1>Da a conocer tu negocio</h1>
        <p>Completa el formulario para que tu establecimiento forme parte de la Guía Repsol Soletes</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #ffe6e6; border: 1px solid #ff4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <strong style="color: #cc0000;">⚠️ Por favor, corrija los siguientes errores:</strong>
            <ul style="margin: 10px 0 0 20px; color: #cc0000;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('restaurantes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- INFORMACIÓN BÁSICA -->
        <div class="form-section">
            <h2>Información básica</h2>

            <div class="form-group">
                <label>Nombre del negocio <span class="required">*</span></label>
                <input type="text" name="nombre" required placeholder="Ej: Mesón El Rincón" value="{{ old('nombre') }}"
                    class="@error('nombre') error @enderror">
                @error('nombre')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Categoría <span class="required">*</span></label>
                    <select name="categoria_id" required>
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias ?? [] as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Precio promedio <span class="required">*</span></label>
                    <input type="number" name="precio" required placeholder="Ej: 25.00" step="0.01" min="0" value="{{ old('precio') }}">
                    <small>Precio promedio por persona en euros</small>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción del negocio <span class="required">*</span></label>
                <textarea name="descripcion" required placeholder="Describe tu negocio, su ambiente, especialidades, historia..." class="@error('descripcion') error @enderror">{{ old('descripcion') }}</textarea>
                <small>Mínimo 100 caracteres</small>
                @error('descripcion')
                    <small style="color: #e74c3c; display: block;">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- UBICACIÓN -->
        <div class="form-section">
            <h2>Ubicación</h2>

            <div class="form-group">
                <label>Dirección completa <span class="required">*</span></label>
                <input type="text" name="direccion" required placeholder="Calle, número, piso" value="{{ old('direccion') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ciudad <span class="required">*</span></label>
                    <input type="text" name="ciudad" required placeholder="Ej: Madrid" value="{{ old('ciudad') }}">
                </div>

                <div class="form-group">
                    <label>Provincia <span class="required">*</span></label>
                    <input type="text" name="provincia" required placeholder="Ej: Madrid" value="{{ old('provincia') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Código postal <span class="required">*</span></label>
                    <input type="text" name="codigo_postal" required placeholder="Ej: 28001" value="{{ old('codigo_postal') }}">
                </div>

                <div class="form-group">
                    <label>Comunidad Autónoma <span class="required">*</span></label>
                    <input type="text" name="comunidad_autonoma" required placeholder="Ej: Comunidad de Madrid" value="{{ old('comunidad_autonoma') }}">
                </div>
            </div>
        </div>

        <!-- CONTACTO -->
        <div class="form-section">
            <h2>Información de contacto</h2>

            <div class="form-row">
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" name="telefono" placeholder="Ej: 912345678" value="{{ old('telefono') }}">
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" required placeholder="contacto@tunegocio.com" value="{{ old('email') }}" class="@error('email') error @enderror">
                    @error('email')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Sitio web</label>
                <input type="url" name="web" placeholder="https://www.tunegocio.com" value="{{ old('web') }}">
            </div>
        </div>

        <!-- TIPOS DE COMIDA -->
        <div class="form-section">
            <h2>Tipos de cocina</h2>

            <div class="form-group">
                <label>Selecciona los tipos de cocina que ofreces</label>
                <div class="checkbox-group">
                    @foreach($tiposComida ?? [] as $tipo)
                        <div class="checkbox-item">
                            <input type="checkbox" name="tipos_comida[]" value="{{ $tipo->id }}" id="tipo_{{ $tipo->id }}"
                                {{ in_array($tipo->id, old('tipos_comida', [])) ? 'checked' : '' }}>
                            <label for="tipo_{{ $tipo->id }}">{{ $tipo->nombre }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- IMÁGENES -->
        <div class="form-section">
            <h2>Imágenes</h2>

            <div class="form-group">
                <label>Foto principal del negocio <span class="required">*</span></label>
                <div class="file-upload @error('foto_principal') error @enderror" onclick="document.getElementById('foto_principal').click()">
                    <div class="file-upload-icon">📷</div>
                    <div class="file-upload-text">
                        <strong>Haz clic para subir</strong> o arrastra la imagen aquí
                        <br><small>Formatos JPG, PNG. Máximo 5MB</small>
                    </div>
                    <input type="file" id="foto_principal" name="foto_principal" accept="image/*" required>
                </div>
                @error('foto_principal')
                    <small style="color: #e74c3c;">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label>Imágenes adicionales (máximo 5)</label>
                <div class="file-upload" onclick="document.getElementById('fotos_adicionales').click()">
                    <div class="file-upload-icon">🖼️</div>
                    <div class="file-upload-text">
                        <strong>Haz clic para subir</strong> o arrastra las imágenes aquí
                        <br><small>Puedes seleccionar múltiples archivos</small>
                    </div>
                    <input type="file" id="fotos_adicionales" name="fotos_adicionales[]" accept="image/*" multiple>
                </div>
            </div>
        </div>

        <!-- BOTONES -->
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('restaurantes') }}'">Cancelar</button>
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
        </div>
    </form>
</div>

<footer class="form-footer">
    <p>© Repsol S.A. 2000 - 2026 | Guía Repsol</p>
</footer>

<script src="{{ asset('js/formulario-validacion.js') }}"></script>

</body>
</html>
