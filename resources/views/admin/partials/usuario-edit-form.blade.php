<form id="editUserForm" onsubmit="actualizarUsuario(event)" data-user-id="{{ $usuario->id }}">
    <div class="form-group">
        <label for="edit_user_name">Nombre <span class="required">*</span></label>
        <input type="text" id="edit_user_name" name="name" required class="form-control"
            value="{{ $usuario->name }}" placeholder="Nombre del usuario">
        <span class="error" id="error_edit_user_name"></span>
    </div>

    <div class="form-group">
        <label for="edit_user_apellidos">Apellidos <span class="required">*</span></label>
        <input type="text" id="edit_user_apellidos" name="apellidos" required class="form-control"
            value="{{ $usuario->apellidos }}" placeholder="Apellidos del usuario">
        <span class="error" id="error_edit_user_apellidos"></span>
    </div>

    <div class="form-group">
        <label for="edit_user_email">Email <span class="required">*</span></label>
        <input type="email" id="edit_user_email" name="email" required class="form-control"
            value="{{ $usuario->email }}" placeholder="email@ejemplo.com">
        <span class="error" id="error_edit_user_email"></span>
    </div>

    <div class="form-group">
        <label for="edit_user_password">Contraseña <small>(dejar vacío para no cambiar)</small></label>
        <input type="password" id="edit_user_password" name="password" class="form-control"
            placeholder="Nueva contraseña (mínimo 6 caracteres)" minlength="6">
        <span class="error" id="error_edit_user_password"></span>
    </div>

    <div class="form-group">
        <label for="edit_user_rol">Rol <span class="required">*</span></label>
        <select id="edit_user_rol" name="rol" required class="form-control">
            <option value="administrador" {{ $usuario->rol === 'administrador' ? 'selected' : '' }}>Administrador</option>
            <option value="usuario" {{ $usuario->rol === 'usuario' ? 'selected' : '' }}>Usuario</option>
            <option value="gerente" {{ $usuario->rol === 'gerente' ? 'selected' : '' }}>Gerente</option>
        </select>
        <span class="error" id="error_edit_user_rol"></span>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="closeUserModal()">Cancelar</button>
        <button type="submit" class="btn btn-submit" id="btnActualizarUsuario">Guardar Cambios</button>
    </div>
</form>
