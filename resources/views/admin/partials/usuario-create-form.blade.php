<form id="createUserForm" onsubmit="guardarUsuario(event)">
    <div class="form-group">
        <label for="user_name">Nombre <span class="required">*</span></label>
        <input type="text" id="user_name" name="name" required class="form-control"
            placeholder="Nombre del usuario">
        <span class="error" id="error_user_name"></span>
    </div>

    <div class="form-group">
        <label for="user_apellidos">Apellidos <span class="required">*</span></label>
        <input type="text" id="user_apellidos" name="apellidos" required class="form-control"
            placeholder="Apellidos del usuario">
        <span class="error" id="error_user_apellidos"></span>
    </div>

    <div class="form-group">
        <label for="user_email">Email <span class="required">*</span></label>
        <input type="email" id="user_email" name="email" required class="form-control"
            placeholder="email@ejemplo.com">
        <span class="error" id="error_user_email"></span>
    </div>

    <div class="form-group">
        <label for="user_password">Contraseña <span class="required">*</span></label>
        <input type="password" id="user_password" name="password" required class="form-control"
            placeholder="Mínimo 6 caracteres" minlength="6">
        <span class="error" id="error_user_password"></span>
    </div>

    <div class="form-group">
        <label for="user_rol">Rol <span class="required">*</span></label>
        <select id="user_rol" name="rol" required class="form-control">
            <option value="">Seleccionar rol</option>
            <option value="administrador">Administrador</option>
            <option value="usuario">Usuario</option>
            <option value="gerente">Gerente</option>
        </select>
        <span class="error" id="error_user_rol"></span>
    </div>

    <div class="form-actions">
        <button type="button" class="btn btn-cancel" onclick="closeUserModal()">Cancelar</button>
        <button type="submit" class="btn btn-submit" id="btnGuardarUsuario">Crear Usuario</button>
    </div>
</form>
