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
                    <button class="btn-menu-detalle" id="btnToggleMenu" onclick="toggleMobileMenu()">
                        <i class="bi bi-list"></i>
                    </button>
                </div>
                <div class="col-auto">
                    <img src="{{ asset('img/Guia_Repsol.png') }}" alt="Guía Repsol" class="logo-img">
                </div>
                <div class="col">
                </div>
                <div class="col-auto">
                    @auth
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <!-- Botón de Notificaciones -->
                        <div style="position: relative;">
                            <button id="btnNotificaciones" class="btn-perfil-header btn-notificaciones" onclick="abrirPanelNotificaciones()" style="position: relative;">
                                <i class="bi bi-bell-fill" style="font-size: 20px; color: #00a3e0;"></i>
                                <span id="notificacionesBadge" class="notificaciones-badge" style="display: none; position: absolute; top: -5px; right: -5px;">0</span>
                            </button>
                        </div>
                        <!-- Botón de Perfil -->
                        <button class="btn-perfil-header" onclick="abrirModalPerfil()">
                            <img id="avatarHeaderImg" src="{{ Auth::user()->foto_perfil ? asset(Auth::user()->foto_perfil) : asset('img/avatares/default-avatar.png') }}" alt="Perfil" class="perfil-avatar-small">
                            <span style="font-size: 12px; color: #333;">{{ Auth::user()->name }}</span>
                        </button>
                        <!-- Form Logout -->
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-acceso-detalle">
                                <i class="bi bi-box-arrow-right"></i> Salir
                            </button>
                        </form>
                    </div>
                    @else
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-acceso-detalle">
                            <i class="bi bi-person"></i> Cerrar Sesión
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <ul class="mobile-nav">
            <li><a href="{{ route('home') }}"><i class="bi bi-house"></i> Inicio</a></li>
            <li><a href="{{ route('restaurantes') }}"><i class="bi bi-list-ul"></i> Listado</a></li>
            <li><a href="{{ route('formulario') }}" class="active"><i class="bi bi-shop"></i> Date a Conocer</a></li>
            <li><a href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i> Guardados</a></li>
        </ul>
    </div>

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
                    <a class="nav-link active" href="{{ route('formulario') }}"><i class="bi bi-shop"></i> Date a
                        Conocer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('restaurantes.guardados') }}"><i class="bi bi-bookmark-fill"></i>
                        Guardados</a>
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
    </div>

    <div class="form-container">
        <form id="formCrearNegocio" action="{{ route('restaurantes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- INFORMACIÓN BÁSICA -->
            <div class="form-section">
                <h2>Información básica</h2>

                <div class="form-group">
                    <label>Nombre del negocio <span class="required">*</span></label>
                    <input type="text" name="nombre" placeholder="Ej: Mesón El Rincón" value="{{ old('nombre') }}"
                        class="@error('nombre') error @enderror">
                    <span id="error-nombre" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Categoría <span class="required">*</span></label>
                        <select name="categoria_id">
                            <option value="" disabled selected>Selecciona una categoría</option>
                            @foreach ($categorias ?? [] as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <span id="error-categoria" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>

                    <div class="form-group">
                        <label>Precio promedio <span class="required">*</span></label>
                        <input type="number" name="precio" placeholder="Ej: 25.00" step="0.01" min="0.01"
                            max="9999.99" value="{{ old('precio') }}">
                        <small>Precio promedio por persona en euros (máximo 9999.99€)</small>
                        <span id="error-precio" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Descripción del negocio <span class="required">*</span></label>
                    <textarea name="descripcion" placeholder="Describe tu negocio, su ambiente, especialidades, historia..."
                        class="@error('descripcion') error @enderror">{{ old('descripcion') }}</textarea>
                    <small>Mínimo 100 caracteres</small>
                    <span id="error-descripcion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                </div>
            </div>

            <!-- UBICACIÓN -->
            <div class="form-section">
                <h2>Ubicación</h2>

                <div class="form-group">
                    <label>Dirección completa <span class="required">*</span></label>
                    <input type="text" name="direccion" placeholder="Calle, número, piso"
                        value="{{ old('direccion') }}">
                    <span id="error-direccion" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Ciudad <span class="required">*</span></label>
                        <input type="text" name="ciudad" placeholder="Ej: Madrid" value="{{ old('ciudad') }}">
                        <span id="error-ciudad" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>

                    <div class="form-group">
                        <label>Provincia <span class="required">*</span></label>
                        <input type="text" name="provincia" placeholder="Ej: Madrid"
                            value="{{ old('provincia') }}">
                        <span id="error-provincia" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Código postal <span class="required">*</span></label>
                        <input type="text" name="codigo_postal" placeholder="Ej: 28001"
                            value="{{ old('codigo_postal') }}">
                        <span id="error-codigo-postal" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>

                    <div class="form-group">
                        <label>Comunidad Autónoma <span class="required">*</span></label>
                        <input type="text" name="comunidad_autonoma" placeholder="Ej: Comunidad de Madrid"
                            value="{{ old('comunidad_autonoma') }}">
                        <span id="error-comunidad" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
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
                        <span id="error-telefono" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" placeholder="contacto@tunegocio.com"
                            value="{{ old('email') }}" class="@error('email') error @enderror">
                        <span id="error-email" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Sitio web</label>
                    <input type="url" name="web" placeholder="https://www.tunegocio.com"
                        value="{{ old('web') }}">
                    <span id="error-web" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
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
                        <input type="file" id="foto_principal" name="foto_principal" accept="image/*">
                    </div>
                    <span id="error-foto-principal" style="color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;"></span>
                </div>

                <div class="form-group">
                    <label>Imágenes adicionales (máximo 8)</label>
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
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='{{ route('restaurantes') }}'">Cancelar</button>
                <button type="submit" class="btn btn-primary" id="btnEnviarFormulario" disabled>Enviar solicitud</button>
            </div>
        </form>
    </div>

    <footer class="form-footer">
        <p>© Repsol S.A. 2000 - 2026 | Guía Repsol</p>
    </footer>

    <!-- Modal de Perfil - Solo para usuarios autenticados -->
    @auth
<div class="modal fade" id="modalPerfil" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Mi Perfil</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formPerfil">
                            <div class="perfil-avatar-section text-center mb-4">
                                <img id="perfilAvatarImg" src="{{ Auth::user()->foto_perfil ? asset(Auth::user()->foto_perfil) : asset('img/avatares/default-avatar.png') }}" alt="Avatar" class="perfil-avatar-img rounded-circle" style="width: 120px; height: 120px; object-fit: cover; margin-bottom: 15px;">
                                <div class="perfil-avatar-upload">
                                    <input type="file" id="perfilFotoInput" class="d-none" accept="image/*">
                                    <label for="perfilFotoInput" class="btn btn-sm btn-primary">
                                        <i class="bi bi-cloud-upload"></i> Cambiar Foto
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="perfilNombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="perfilNombre" required>
                            </div>

                            <div class="mb-3">
                                <label for="perfilApellidos" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="perfilApellidos" required>
                            </div>

                            <div class="mb-3">
                                <label for="perfilEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="perfilEmail" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarPerfil()">Guardar Cambios</button>
                    </div>
                </div>
        </div>
    </div>

    <!-- Panel de Notificaciones -->
    <div id="notificacionesPanel" class="notificaciones-panel">
        <div class="notificaciones-header">
            <h3>Notificaciones <span id="notificacionesBadgeHeader" class="notificaciones-badge"></span></h3>
            <button class="notificaciones-close" onclick="cerrarPanelNotificaciones()">×</button>
        </div>
        <div id="notificacionesContenido" class="notificaciones-content">
            <!-- Las notificaciones se cargarán aquí -->
        </div>
        <div class="notificaciones-footer">
            <button class="notificaciones-btn-marcar-todo" onclick="marcarTodasLeidas()">Marcar todo como leído</button>
        </div>
    </div>
    @endauth

    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/mobile-menu.js') }}"></script>
    <script src="{{ asset('js/validacion-formulario.js') }}"></script>
    @auth
    <script src="{{ asset('js/perfil.js') }}"></script>
    @endauth

</body>

</html>
