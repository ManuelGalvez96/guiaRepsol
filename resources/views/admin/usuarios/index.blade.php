<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestión de Usuarios - Guía Repsol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/users/usuarios.css') }}">
</head>
<body data-csrf="{{ csrf_token() }}" data-route-logout="{{ route('logout') }}"
      data-current-user="{{ auth()->id() }}"
      data-ruta-index="{{ route('admin.usuarios.index') }}"
      data-ruta-store="{{ route('admin.usuarios.store') }}">
    <!-- Header -->
    <div class="header">
        <div class="servicios-iconos">
            <img src="{{ asset('img/Guia_Repsol.png') }}" class="logo" alt="Guía Repsol">
        </div>
        <button type="button" class="logout-btn">Cerrar sesión</button>
    </div>

    <div class="container" style="margin: 30px auto;">
        <div class="top-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
            <div>
                <h1 style="margin: 0;">Gestión de Usuarios</h1>
                <p style="color: #666; margin: 5px 0;">Total de usuarios: <strong id="total-usuarios">{{ $usuarios->total() }}</strong></p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="{{ route('admin.dashboard') }}" class="create-btn" style="background-color: #9b59b6;">Dashboard</a>
                <a href="{{ route('admin.index') }}" class="create-btn" style="background-color: #3498db;">Gestión de Restaurantes</a>
                <a href="{{ route('admin.solicitudes') }}" class="create-btn" style="background-color: #f39c12;">Solicitudes de negocio</a>
                <button class="create-btn" onclick="abrirModalCrear()">➕ Nuevo Usuario</button>
            </div>
        </div>

        <!-- Buscador y filtros -->
        <div class="search-box" style="background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                <div style="flex: 1; min-width: 250px;">
                    <input type="text" id="buscar" placeholder="Buscar por nombre, apellidos o email..." 
                        class="form-control">
                </div>
                
                <div style="flex: 0 0 auto;">
                    <select id="filtro-rol" class="form-select">
                        <option value="">Todos los roles</option>
                        <option value="administrador">Administrador</option>
                        <option value="gerente">Gerente</option>
                        <option value="usuario">Usuario</option>
                    </select>
                </div>
                
                <div style="flex: 0 0 auto;">
                    <button type="button" class="btn btn-secondary" onclick="limpiarFiltros()">✕ Limpiar</button>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" id="tabla-container">
            <!-- Se llenará con AJAX -->
        </div>

        <!-- Paginación -->
        <div id="paginacion-container" style="margin-top: 20px; display: flex; justify-content: center;">
            <!-- Se llenará con AJAX -->
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="modalCrear" tabindex="-1" aria-labelledby="modalCrearLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearLabel">➕ Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formCrear">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="crear_name" name="name" required>
                                <div class="invalid-feedback" id="error-crear-name"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="crear_apellidos" name="apellidos" required>
                                <div class="invalid-feedback" id="error-crear-apellidos"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="crear_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="crear_email" name="email" required>
                            <div class="invalid-feedback" id="error-crear-email"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="crear_rol" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-select" id="crear_rol" name="rol" required>
                                <option value="">Selecciona un rol</option>
                                <option value="administrador">👤 Administrador</option>
                                <option value="gerente">🏪 Gerente</option>
                                <option value="usuario">👥 Usuario</option>
                            </select>
                            <div class="invalid-feedback" id="error-crear-rol"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crear_password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="crear_password" name="password" required minlength="6">
                                <small class="text-muted">Mínimo 6 caracteres</small>
                                <div class="invalid-feedback" id="error-crear-password"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="crear_password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="crear_password_confirmation" name="password_confirmation" required>
                                <div class="invalid-feedback" id="error-crear-password-confirmation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">✓ Crear Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">✏️ Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditar">
                    <input type="hidden" id="editar_id" name="id">
                    <div class="modal-body">
                        <div class="alert alert-info mb-3">
                            <small><strong>ID:</strong> <span id="editar_id_display"></span> | <strong>Registrado:</strong> <span id="editar_created_at"></span></small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editar_name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editar_name" name="name" required>
                                <div class="invalid-feedback" id="error-editar-name"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editar_apellidos" class="form-label">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="editar_apellidos" name="apellidos" required>
                                <div class="invalid-feedback" id="error-editar-apellidos"></div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editar_email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="editar_email" name="email" required>
                            <div class="invalid-feedback" id="error-editar-email"></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editar_rol" class="form-label">Rol <span class="text-danger">*</span></label>
                            <select class="form-select" id="editar_rol" name="rol" required>
                                <option value="">Selecciona un rol</option>
                                <option value="administrador">👤 Administrador</option>
                                <option value="gerente">🏪 Gerente</option>
                                <option value="usuario">👥 Usuario</option>
                            </select>
                            <div class="invalid-feedback" id="error-editar-rol"></div>
                        </div>
                        
                        <hr>
                        <h6>Cambiar Contraseña <span class="text-muted">(Opcional)</span></h6>
                        <small class="text-muted">Déjalo en blanco para mantener la contraseña actual</small>
                        
                        <div class="row mt-3">
                            <div class="col-md-6 mb-3">
                                <label for="editar_password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="editar_password" name="password" minlength="6">
                                <small class="text-muted">Mínimo 6 caracteres</small>
                                <div class="invalid-feedback" id="error-editar-password"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="editar_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="editar_password_confirmation" name="password_confirmation">
                                <div class="invalid-feedback" id="error-editar-password-confirmation"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">✓ Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/users/usuarios.js') }}"></script>
</body>
</html>
