// JavaScript para gestión de usuarios en admin
var csrfToken;
var filtroTimeoutUsuarios = null;

window.onload = function () {
    csrfToken = document.body.getAttribute('data-csrf');
    if (!csrfToken) {
        var metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }

    // Vincular paginación AJAX al cargar
    vincularPaginacionUsuarios();
};

// ==================== MODAL ====================

function openCreateUserModal() {
    var modalOverlay = document.getElementById('modalOverlay');
    var modalTitle = document.getElementById('modalTitle');
    var modalBody = document.getElementById('modalBody');

    if (!modalOverlay || !modalTitle || !modalBody) return;

    modalTitle.textContent = 'Crear Usuario';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;">Cargando formulario...</div>';
    modalOverlay.classList.remove('modal-hidden');

    var routeCrear = document.body.getAttribute('data-route-usuarios-crear') || '/admin/usuarios/crear';

    fetch(routeCrear, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function (response) {
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.text();
    })
    .then(function (html) {
        modalBody.innerHTML = html;
    })
    .catch(function (error) {
        console.error('Error al cargar formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
    });
}

function openEditUserModal(userId) {
    var modalOverlay = document.getElementById('modalOverlay');
    var modalTitle = document.getElementById('modalTitle');
    var modalBody = document.getElementById('modalBody');

    if (!modalOverlay || !modalTitle || !modalBody) return;

    modalTitle.textContent = 'Editar Usuario';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;">Cargando formulario...</div>';
    modalOverlay.classList.remove('modal-hidden');

    fetch('/admin/usuarios/' + userId + '/editar', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function (response) {
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.text();
    })
    .then(function (html) {
        modalBody.innerHTML = html;
    })
    .catch(function (error) {
        console.error('Error al cargar formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
    });
}

function closeUserModal() {
    var modalOverlay = document.getElementById('modalOverlay');
    if (modalOverlay) {
        modalOverlay.classList.add('modal-hidden');
    }
}

// ==================== CRUD ====================

var enviandoUsuario = false;

function guardarUsuario(event) {
    event.preventDefault();

    if (enviandoUsuario) return;
    enviandoUsuario = true;

    var form = document.getElementById('createUserForm');
    var formData = new FormData(form);

    // Validación básica
    var name = formData.get('name');
    var apellidos = formData.get('apellidos');
    var email = formData.get('email');
    var password = formData.get('password');
    var rol = formData.get('rol');

    if (!name || !apellidos || !email || !password || !rol) {
        Swal.fire({ icon: 'warning', title: 'Campos incompletos', text: 'Por favor, rellena todos los campos obligatorios.' });
        enviandoUsuario = false;
        return;
    }

    if (password.length < 6) {
        Swal.fire({ icon: 'warning', title: 'Contraseña corta', text: 'La contraseña debe tener al menos 6 caracteres.' });
        enviandoUsuario = false;
        return;
    }

    Swal.fire({
        title: 'Creando usuario...',
        allowOutsideClick: false,
        didOpen: function () { Swal.showLoading(); }
    });

    fetch('/admin/usuarios', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(function (response) {
        if (response.status === 200 || response.status === 201) {
            return response.json().then(function (data) { return { ok: true, data: data }; });
        }
        if (response.status === 422) {
            return response.json().then(function (data) { return { ok: false, data: data }; });
        }
        throw new Error('HTTP error ' + response.status);
    })
    .then(function (result) {
        if (result.ok) {
            Swal.fire({
                icon: 'success',
                title: '¡Creado!',
                text: result.data.message || 'Usuario creado exitosamente',
                timer: 1500,
                showConfirmButton: false
            }).then(function () {
                closeUserModal();
                aplicarFiltrosUsuarios();
            });
        } else {
            // Errores de validación
            var errores = result.data.errors || {};
            var mensajes = [];
            for (var campo in errores) {
                mensajes.push(errores[campo].join(', '));
                var errorSpan = document.getElementById('error_user_' + campo);
                if (errorSpan) errorSpan.textContent = errores[campo].join(', ');
            }
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: mensajes.join('<br>')
            });
        }
    })
    .catch(function (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Error al crear el usuario' });
    })
    .finally(function () {
        enviandoUsuario = false;
    });
}

function actualizarUsuario(event) {
    event.preventDefault();

    if (enviandoUsuario) return;
    enviandoUsuario = true;

    var form = document.getElementById('editUserForm');
    var userId = form.getAttribute('data-user-id');
    var formData = new FormData(form);

    // Validación básica
    var name = formData.get('name');
    var apellidos = formData.get('apellidos');
    var email = formData.get('email');
    var rol = formData.get('rol');

    if (!name || !apellidos || !email || !rol) {
        Swal.fire({ icon: 'warning', title: 'Campos incompletos', text: 'Por favor, rellena todos los campos obligatorios.' });
        enviandoUsuario = false;
        return;
    }

    var password = formData.get('password');
    if (password && password.length < 6) {
        Swal.fire({ icon: 'warning', title: 'Contraseña corta', text: 'La contraseña debe tener al menos 6 caracteres.' });
        enviandoUsuario = false;
        return;
    }

    Swal.fire({
        title: 'Actualizando usuario...',
        allowOutsideClick: false,
        didOpen: function () { Swal.showLoading(); }
    });

    // Para PUT con FormData, añadimos _method
    formData.append('_method', 'PUT');

    fetch('/admin/usuarios/' + userId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(function (response) {
        if (response.status === 200) {
            return response.json().then(function (data) { return { ok: true, data: data }; });
        }
        if (response.status === 422) {
            return response.json().then(function (data) { return { ok: false, data: data }; });
        }
        throw new Error('HTTP error ' + response.status);
    })
    .then(function (result) {
        if (result.ok) {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: result.data.message || 'Usuario actualizado exitosamente',
                timer: 1500,
                showConfirmButton: false
            }).then(function () {
                closeUserModal();
                aplicarFiltrosUsuarios();
            });
        } else {
            var errores = result.data.errors || {};
            var mensajes = [];
            for (var campo in errores) {
                mensajes.push(errores[campo].join(', '));
                var errorSpan = document.getElementById('error_edit_user_' + campo);
                if (errorSpan) errorSpan.textContent = errores[campo].join(', ');
            }
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: mensajes.join('<br>')
            });
        }
    })
    .catch(function (error) {
        console.error('Error:', error);
        Swal.fire({ icon: 'error', title: 'Error', text: 'Error al actualizar el usuario' });
    })
    .finally(function () {
        enviandoUsuario = false;
    });
}

function deleteUsuario(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(function (result) {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                didOpen: function () { Swal.showLoading(); }
            });

            fetch('/admin/usuarios/' + id, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(function (response) {
                if (!response.ok) {
                    return response.json().then(function (data) {
                        throw new Error(data.message || 'Error al eliminar');
                    });
                }
                return response.json();
            })
            .then(function (data) {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {
                        aplicarFiltrosUsuarios();
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'No se pudo eliminar el usuario' });
                }
            })
            .catch(function (error) {
                console.error('Error:', error);
                Swal.fire({ icon: 'error', title: 'Error', text: error.message || 'Error al eliminar el usuario' });
            });
        }
    });
}

// ==================== FILTROS ====================

function filtroConDelayUsuarios() {
    clearTimeout(filtroTimeoutUsuarios);
    filtroTimeoutUsuarios = setTimeout(function () {
        aplicarFiltrosUsuarios();
    }, 400);
}

function resetearFiltrosUsuarios() {
    var inputBuscar = document.getElementById('filterBuscar');
    var selectRol = document.getElementById('filterRol');

    if (inputBuscar) inputBuscar.value = '';
    if (selectRol) selectRol.value = '';
    aplicarFiltrosUsuarios();
}

function aplicarFiltrosUsuarios(page) {
    var buscar = document.getElementById('filterBuscar') ? document.getElementById('filterBuscar').value : '';
    var rol = document.getElementById('filterRol') ? document.getElementById('filterRol').value : '';

    var params = new URLSearchParams();
    if (buscar) params.append('buscar', buscar);
    if (rol) params.append('rol', rol);
    if (page) params.append('page', page);

    var routeUsuarios = document.body.getAttribute('data-route-usuarios') || '/admin/usuarios';
    var url = routeUsuarios + '?' + params.toString();

    // Actualizar URL sin recargar
    window.history.replaceState({}, '', url);

    var container = document.getElementById('usuariosContainer');
    if (container) container.style.opacity = '0.5';

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(function (response) {
        if (!response.ok) throw new Error('HTTP error ' + response.status);
        return response.text();
    })
    .then(function (html) {
        if (container) {
            container.innerHTML = html;
            container.style.opacity = '1';
            vincularPaginacionUsuarios();
        }
    })
    .catch(function (error) {
        if (container) container.style.opacity = '1';
        console.error('Error al filtrar:', error);
    });
}

function vincularPaginacionUsuarios() {
    var links = document.querySelectorAll('#usuariosContainer .pagination a');
    for (var i = 0; i < links.length; i++) {
        links[i].onclick = function (e) {
            e.preventDefault();
            var url = new URL(this.href);
            var page = url.searchParams.get('page');
            aplicarFiltrosUsuarios(page);
        };
    }
}

// ==================== LOGOUT ====================

function logoutUser() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        text: '¿Estás seguro de que quieres cerrar sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then(function (result) {
        if (result.isConfirmed) {
            var logoutUrl = document.body.getAttribute('data-route-logout') || '/logout';
            fetch(logoutUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(function (response) {
                if (response.redirected) {
                    window.location.href = response.url;
                    return null;
                }
                return response.json();
            })
            .then(function (data) {
                if (data === null) return;
                window.location.href = '/login';
            })
            .catch(function (error) {
                console.error('Error:', error);
                window.location.href = '/login';
            });
        }
    });
}

// Hacer funciones disponibles globalmente
window.openCreateUserModal = openCreateUserModal;
window.openEditUserModal = openEditUserModal;
window.closeUserModal = closeUserModal;
window.guardarUsuario = guardarUsuario;
window.actualizarUsuario = actualizarUsuario;
window.deleteUsuario = deleteUsuario;
window.filtroConDelayUsuarios = filtroConDelayUsuarios;
window.resetearFiltrosUsuarios = resetearFiltrosUsuarios;
window.aplicarFiltrosUsuarios = aplicarFiltrosUsuarios;
window.logoutUser = logoutUser;
