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
            <div class="burger" onclick="window.location.href='{{ route('home') }}'" style="cursor: pointer;">☰</div>
            <div class="logo" onclick="window.location.href='{{ route('home') }}'" style="cursor: pointer;">guía repsol</div>
            <nav class="nav">
                <a href="{{ route('home') }}">Inicio</a>
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

    <form action="#" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- INFORMACIÓN BÁSICA -->
        <div class="form-section">
            <h2>Información básica</h2>

            <div class="form-group">
                <label>Nombre del negocio <span class="required">*</span></label>
                <input type="text" name="nombre" required placeholder="Ej: Mesón El Rincón">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Tipo de establecimiento <span class="required">*</span></label>
                    <select name="tipo" required>
                        <option value="">Selecciona una opción</option>
                        <option value="restaurante">Restaurante</option>
                        <option value="bar">Bar</option>
                        <option value="cafeteria">Cafetería</option>
                        <option value="vinoteca">Vinoteca</option>
                        <option value="heladeria">Heladería</option>
                        <option value="terraza">Terraza / Chiringuito</option>
                        <option value="fast_good">Fast Good</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Rango de precio <span class="required">*</span></label>
                    <select name="precio" required>
                        <option value="">Selecciona una opción</option>
                        <option value="€">€ (0-15€)</option>
                        <option value="€€">€€ (15-30€)</option>
                        <option value="€€€">€€€ (30-50€)</option>
                        <option value="€€€€">€€€€ (+50€)</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Descripción del negocio <span class="required">*</span></label>
                <textarea name="descripcion" required placeholder="Describe tu negocio, su ambiente, especialidades, historia..."></textarea>
                <small>Mínimo 100 caracteres</small>
            </div>
        </div>

        <!-- UBICACIÓN -->
        <div class="form-section">
            <h2>Ubicación</h2>

            <div class="form-group">
                <label>Dirección completa <span class="required">*</span></label>
                <input type="text" name="direccion" required placeholder="Calle, número, piso">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Ciudad <span class="required">*</span></label>
                    <input type="text" name="ciudad" required placeholder="Ej: Madrid">
                </div>

                <div class="form-group">
                    <label>Código postal <span class="required">*</span></label>
                    <input type="text" name="codigo_postal" required placeholder="Ej: 28001">
                </div>
            </div>

            <div class="form-group">
                <label>Comunidad Autónoma <span class="required">*</span></label>
                <select name="comunidad" required>
                    <option value="">Selecciona una opción</option>
                    <option value="madrid">Madrid</option>
                    <option value="catalunya">Catalunya</option>
                    <option value="comunitat_valenciana">Comunitat Valenciana</option>
                    <option value="euskadi">Euskadi</option>
                    <option value="andalucia">Andalucía</option>
                    <option value="galicia">Galicia</option>
                    <option value="castilla_leon">Castilla y León</option>
                    <option value="extremadura">Extremadura</option>
                    <option value="cantabria">Cantabria</option>
                    <option value="otras">Otras</option>
                </select>
            </div>
        </div>

        <!-- CONTACTO -->
        <div class="form-section">
            <h2>Información de contacto</h2>

            <div class="form-row">
                <div class="form-group">
                    <label>Teléfono <span class="required">*</span></label>
                    <input type="tel" name="telefono" required placeholder="Ej: 912345678">
                </div>

                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" required placeholder="contacto@tunegocio.com">
                </div>
            </div>

            <div class="form-group">
                <label>Sitio web</label>
                <input type="url" name="web" placeholder="https://www.tunegocio.com">
            </div>
        </div>

        <!-- HORARIOS Y DETALLES -->
        <div class="form-section">
            <h2>Horarios y características</h2>

            <div class="form-group">
                <label>Horario</label>
                <textarea name="horario" placeholder="Ej: Lunes a Viernes: 13:00 - 16:00 y 20:00 - 23:00&#10;Sábado y Domingo: 13:00 - 00:00" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label>Especialidades culinarias</label>
                <input type="text" name="especialidades" placeholder="Ej: Cocina mediterránea, Arroces, Pescados">
                <small>Separa las especialidades con comas</small>
            </div>

            <div class="form-group">
                <label>Características especiales</label>
                <div class="checkbox-group">
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="pet_friendly" id="pet_friendly">
                        <label for="pet_friendly">Pet Friendly</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="terraza" id="terraza">
                        <label for="terraza">Terraza</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="wifi" id="wifi">
                        <label for="wifi">WiFi gratis</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="parking" id="parking">
                        <label for="parking">Parking</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="accesible" id="accesible">
                        <label for="accesible">Accesible</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="reservas" id="reservas">
                        <label for="reservas">Acepta reservas</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="vegetariano" id="vegetariano">
                        <label for="vegetariano">Opciones vegetarianas</label>
                    </div>
                    <div class="checkbox-item">
                        <input type="checkbox" name="caracteristicas[]" value="celiacos" id="celiacos">
                        <label for="celiacos">Apto para celíacos</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- IMÁGENES -->
        <div class="form-section">
            <h2>Imágenes</h2>

            <div class="form-group">
                <label>Foto principal del negocio <span class="required">*</span></label>
                <div class="file-upload" onclick="document.getElementById('foto_principal').click()">
                    <div class="file-upload-icon">📷</div>
                    <div class="file-upload-text">
                        <strong>Haz clic para subir</strong> o arrastra la imagen aquí
                        <br><small>Formatos JPG, PNG. Máximo 5MB</small>
                    </div>
                    <input type="file" id="foto_principal" name="foto_principal" accept="image/*" required>
                </div>
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
            <button type="button" class="btn btn-secondary" onclick="window.location.href='{{ route('home') }}'">Cancelar</button>
            <button type="submit" class="btn btn-primary">Enviar solicitud</button>
        </div>
    </form>
</div>

<footer class="form-footer">
    <p>© Repsol S.A. 2000 - 2026 | Guía Repsol</p>
</footer>

</body>
</html>
