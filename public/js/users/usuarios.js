const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const currentUserId = parseInt(document.body.getAttribute('data-current-user'));
const rutaIndex = document.body.getAttribute('data-ruta-index');
const rutaStore = document.body.getAttribute('data-ruta-store');

let currentPage = 1;
let currentBuscar = '';
let currentRol = '';

// Cargar usuarios al iniciar
document.addEventListener('DOMContentLoaded', function() {
    cargarUsuarios();
});

// Función para cargar usuarios con AJAX
function cargarUsuarios(page = 1) {
    currentPage = page;
    const buscar = document.getElementById('buscar').value;
    const rol = document.getElementById('filtro-rol').value;
    
    currentBuscar = buscar;
    currentRol = rol;
    
    const url = `${rutaIndex}?page=${page}&buscar=${encodeURIComponent(buscar)}&rol=${encodeURIComponent(rol)}&ajax=1`;
    
    fetch(url, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        actualizarTabla(data.html);
        actualizarPaginacion(data.pagination);
        document.getElementById('total-usuarios').textContent = data.total;
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Error al cargar los usuarios', 'error');
    });
}

// Actualizar tabla
function actualizarTabla(html) {
    document.getElementById('tabla-container').innerHTML = html;
}

// Actualizar paginación
function actualizarPaginacion(paginationHtml) {
    const container = document.getElementById('paginacion-container');
    container.innerHTML = paginationHtml;
    
    // Agregar eventos a los enlaces de paginación
    container.querySelectorAll('a[data-page]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const page = parseInt(this.getAttribute('data-page'));
            cargarUsuarios(page);
        });
    });
}

// Buscar usuarios
function buscarUsuarios() {
    cargarUsuarios(1);
}

// Limpiar filtros
function limpiarFiltros() {
    document.getElementById('buscar').value = '';
    document.getElementById('filtro-rol').value = '';
    cargarUsuarios(1);
}

// Debounce para búsqueda mientras escribes
let buscarTimeout = null;

// Configurar eventos de búsqueda automática
document.addEventListener('DOMContentLoaded', function() {
    // Búsqueda mientras escribes (con delay de 500ms)
    document.getElementById('buscar').addEventListener('input', function() {
        clearTimeout(buscarTimeout);
        buscarTimeout = setTimeout(function() {
            buscarUsuarios();
        }, 500);
    });
    
    // Búsqueda al cambiar el rol
    document.getElementById('filtro-rol').addEventListener('change', function() {
        buscarUsuarios();
    });
    
    // También mantener la búsqueda al presionar Enter (para los que prefieran)
    document.getElementById('buscar').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(buscarTimeout); // Cancelar el timeout si presiona Enter
            buscarUsuarios();
        }
    });
});

// Abrir modal crear
function abrirModalCrear() {
    document.getElementById('formCrear').reset();
    limpiarErrores('crear');
    const modal = new bootstrap.Modal(document.getElementById('modalCrear'));
    modal.show();
}

// Abrir modal editar
function abrirModalEditar(usuarioId) {
    fetch(`/admin/usuarios/${usuarioId}/editar?ajax=1`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const usuario = data.usuario;
            document.getElementById('editar_id').value = usuario.id;
            document.getElementById('editar_id_display').textContent = usuario.id;
            document.getElementById('editar_name').value = usuario.name;
            document.getElementById('editar_apellidos').value = usuario.apellidos;
            document.getElementById('editar_email').value = usuario.email;
            document.getElementById('editar_rol').value = usuario.rol;
            document.getElementById('editar_created_at').textContent = usuario.created_at;
            document.getElementById('editar_password').value = '';
            document.getElementById('editar_password_confirmation').value = '';
            
            // Actualizar preview de foto de perfil
            const previewFoto = document.getElementById('editar_preview_foto');
            if (previewFoto) {
                previewFoto.src = usuario.foto_perfil || '/img/avatares/default-avatar.png';
            }
            
            // Limpiar input de foto
            const fotoInput = document.getElementById('editar_foto_perfil');
            if (fotoInput) {
                fotoInput.value = '';
            }
            
            limpiarErrores('editar');
            const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
            modal.show();
        } else {
            Swal.fire('Error', 'No se pudo cargar el usuario', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Error al cargar los datos del usuario', 'error');
    });
}

// Limpiar errores
function limpiarErrores(tipo) {
    document.querySelectorAll(`[id^="error-${tipo}-"]`).forEach(el => {
        el.textContent = '';
        el.parentElement.querySelector('input, select')?.classList.remove('is-invalid');
    });
}

// Mostrar errores
function mostrarErrores(tipo, errors) {
    limpiarErrores(tipo);
    for (const [field, messages] of Object.entries(errors)) {
        const errorElement = document.getElementById(`error-${tipo}-${field}`);
        const inputElement = document.getElementById(`${tipo}_${field}`);
        if (errorElement && inputElement) {
            errorElement.textContent = messages[0];
            inputElement.classList.add('is-invalid');
            errorElement.style.display = 'block';
        }
    }
}

// Submit formulario crear
document.getElementById('formCrear').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch(rutaStore, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalCrear')).hide();
            Swal.fire({
                icon: 'success',
                title: '¡Usuario creado!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
            cargarUsuarios(currentPage);
        } else if (data.errors) {
            mostrarErrores('crear', data.errors);
        } else {
            Swal.fire('Error', data.message || 'Error al crear el usuario', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'Error al crear el usuario', 'error');
    });
});

// Submit formulario editar
document.getElementById('formEditar').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const usuarioId = document.getElementById('editar_id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    
    console.log('Submitting update for user:', usuarioId);
    console.log('FormData entries:');
    for (let pair of formData.entries()) {
        console.log(pair[0], ':', pair[1]);
    }
    
    fetch(`/admin/usuarios/${usuarioId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.json().then(data => {
            if (!response.ok) {
                console.error('Validation errors:', data);
                throw data;
            }
            return data;
        });
    })
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
            Swal.fire({
                icon: 'success',
                title: '¡Usuario actualizado!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            });
            cargarUsuarios(currentPage);
        } else if (data.errors) {
            console.log('Showing errors:', data.errors);
            mostrarErrores('editar', data.errors);
            Swal.fire({
                icon: 'error',
                title: 'Errores de validación',
                html: Object.values(data.errors).flat().join('<br>')
            });
        } else {
            Swal.fire('Error', data.message || 'Error al actualizar el usuario', 'error');
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        
        let errorMessage = 'Error al actualizar el usuario';
        if (error.errors) {
            mostrarErrores('editar', error.errors);
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage
        });
    });
});

// Confirmar y eliminar usuario
function confirmarEliminar(usuarioId) {
    if (usuarioId === currentUserId) {
        Swal.fire('Error', 'No puedes eliminar tu propio usuario', 'error');
        return;
    }
    
    Swal.fire({
        title: '¿Eliminar usuario?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/admin/usuarios/${usuarioId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    cargarUsuarios(currentPage);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Error al eliminar el usuario', 'error');
            });
        }
    });
}

// Logout handler
document.addEventListener('DOMContentLoaded', function() {
    // Preview de foto en modal editar
    const editarFotoInput = document.getElementById('editar_foto_perfil');
    if (editarFotoInput) {
        editarFotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validar tipo de archivo
                if (!['image/jpeg', 'image/jpg', 'image/png', 'image/webp'].includes(file.type)) {
                    Swal.fire('Error', 'La imagen debe ser JPG, PNG o WEBP', 'error');
                    this.value = '';
                    return;
                }
                
                // Validar tamaño (5MB)
                if (file.size > 5120 * 1024) {
                    Swal.fire('Error', 'La imagen no puede exceder 5MB', 'error');
                    this.value = '';
                    return;
                }
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('editar_preview_foto');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Cerrar sesión?',
                text: "¿Estás seguro?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#95a5a6',
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const logoutUrl = document.body.getAttribute('data-route-logout') || '/logout';
                    
                    fetch(logoutUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(() => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sesión cerrada',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/';
                        });
                    });
                }
            });
        });
    }
});
