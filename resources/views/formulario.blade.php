<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dar a conocer mi negocio | Guía Repsol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/soletes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/restaurantes.css') }}">
</head>

<body>

    <!-- Header -->
    <header class="header-main">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-auto">
                    <button class="btn-menu">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-img">
                </div>
                <div class="col">
                    <div class="search-bar">
                        <button class="btn-close-search" id="restaurant-search-clear">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <input type="text" class="search-input" id="restaurant-search-input" placeholder="Buscar">
                        <button class="btn-search-submit" id="restaurant-search-button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-auto">
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-acceso-detalle">
                            <i class="bi bi-person"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Tabs Navigation -->
    <div class="tabs-nav">
        <div class="container">
            <ul class="nav nav-tabs border-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="bi bi-house"></i> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes') }}"><i class="bi bi-list-ul"></i> Listado</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a Conocer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i>
                        Guardados</a>
                </li>
                <li class="nav-item ms-auto">
                    <a class="nav-link" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Da a conocer tu
                        negocio</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- FORMULARIO -->
    <div class="form-container">
        <div class="form-header">
            <h1>Da a conocer tu negocio</h1>
            <p>Completa el formulario para que tu establecimiento forme parte de la Guía Repsol Soletes</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger"
                style="background-color: #ffe6e6; border: 1px solid #ff4444; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
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
                    <input type="text" name="nombre" required placeholder="Ej: Mesón El Rincón"
                        value="{{ old('nombre') }}" class="@error('nombre') error @enderror">
                    @error('nombre')
                        <small style="color: #e74c3c;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Categoría <span class="required">*</span></label>
                        <select name="categoria_id" required>
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias ?? [] as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Precio promedio <span class="required">*</span></label>
                        <input type="number" name="precio" required placeholder="Ej: 25.00" step="0.01"
                            min="0.01" max="9999.99" value="{{ old('precio') }}">
                        <small>Precio promedio por persona en euros (máximo 9999.99€)</small>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripción del negocio <span class="required">*</span></label>
                    <textarea name="descripcion" required placeholder="Describe tu negocio, su ambiente, especialidades, historia..."
                        class="@error('descripcion') error @enderror" maxlength="1000" id="descripcion">{{ old('descripcion') }}</textarea>
                    <small>Mínimo 100 caracteres | Máximo 1000 caracteres | <span id="charCount">0</span>/1000</small>
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
                    <input type="text" name="direccion" required placeholder="Calle, número, piso"
                        value="{{ old('direccion') }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ciudad <span class="required">*</span></label>
                        <input type="text" name="ciudad" required placeholder="Ej: Madrid"
                            value="{{ old('ciudad') }}">
                    </div>

                    <div class="form-group">
                        <label>Provincia <span class="required">*</span></label>
                        <input type="text" name="provincia" required placeholder="Ej: Madrid"
                            value="{{ old('provincia') }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Código postal <span class="required">*</span></label>
                        <input type="text" name="codigo_postal" required placeholder="Ej: 28001"
                            value="{{ old('codigo_postal') }}">
                    </div>

                    <div class="form-group">
                        <label>Comunidad Autónoma <span class="required">*</span></label>
                        <input type="text" name="comunidad_autonoma" required
                            placeholder="Ej: Comunidad de Madrid" value="{{ old('comunidad_autonoma') }}">
                    </div>
                </div>
            </div>

            <!-- CONTACTO -->
            <div class="form-section">
                <h2>Información de contacto</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="tel" name="telefono" placeholder="Ej: 912345678"
                            value="{{ old('telefono') }}">
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required placeholder="contacto@tunegocio.com"
                            value="{{ old('email') }}" class="@error('email') error @enderror">
                        @error('email')
                            <small style="color: #e74c3c;">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Sitio web</label>
                    <input type="url" name="web" placeholder="https://www.tunegocio.com"
                        value="{{ old('web') }}">
                </div>
            </div>

            <!-- TIPOS DE COMIDA -->
            <div class="form-section">
                <h2>Tipos de cocina</h2>

                <div class="form-group">
                    <label>Selecciona los tipos de cocina que ofreces</label>
                    <div class="checkbox-group">
                        @foreach ($tiposComida ?? [] as $tipo)
                            <div class="checkbox-item">
                                <input type="checkbox" name="tipos_comida[]" value="{{ $tipo->id }}"
                                    id="tipo_{{ $tipo->id }}"
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
                    <div class="file-upload @error('foto_principal') error @enderror"
                        onclick="document.getElementById('foto_principal').click()">
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
                        <input type="file" id="fotos_adicionales" name="fotos_adicionales[]" accept="image/*"
                            multiple>
                    </div>
                </div>
            </div>

            <!-- BOTONES -->
            <div class="form-actions">
                <button type="button" class="btn-form btn-secondary"
                    onclick="window.location.href='{{ route('restaurantes') }}'">Cancelar</button>
                <button type="submit" class="btn-form btn-primary">Enviar solicitud</button>
            </div>
        </form>
    </div>

    <footer class="form-footer">
        <p>© Repsol S.A. 2000 - 2026 | Guía Repsol</p>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

    <!-- Contador de caracteres para descripción -->
    <script>
        const descripcionField = document.getElementById('descripcion');
        const charCountSpan = document.getElementById('charCount');

        if (descripcionField && charCountSpan) {
            // Actualizar contador al cargar la página (si hay valor previo)
            charCountSpan.textContent = descripcionField.value.length;

            // Actualizar contador en tiempo real
            descripcionField.addEventListener('input', () => {
                charCountSpan.textContent = descripcionField.value.length;
            });
        }
    </script>

</body>

</html>
