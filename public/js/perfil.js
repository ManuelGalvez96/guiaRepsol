// Cargar datos del perfil al abrir el modal
function cargarDatosPerfil() {
    fetch('/perfil', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('perfilNombre').value = data.usuario.name || '';
            document.getElementById('perfilApellidos').value = data.usuario.apellidos || '';
            document.getElementById('perfilEmail').value = data.usuario.email || '';
        }
    })
    .catch(error => console.error('Error:', error));
}

// Abrir modal de perfil
function abrirModalPerfil() {
    cargarDatosPerfil();
    const modal = new bootstrap.Modal(document.getElementById('modalPerfil'));
    modal.show();
}

// Guardar cambios del perfil
function guardarPerfil() {
    const nombre = document.getElementById('perfilNombre').value.trim();
    const apellidos = document.getElementById('perfilApellidos').value.trim();
    const email = document.getElementById('perfilEmail').value.trim();
    const fotoInput = document.getElementById('perfilFotoInput');

    // Validar campos
    if (!nombre || !apellidos || !email) {
        alert('Todos los campos son obligatorios');
        return;
    }
    if (nombre.length < 2 || apellidos.length < 2) {
        alert('El nombre y apellidos deben tener al menos 2 caracteres');
        return;
    }
    if (!validarEmail(email)) {
        alert('El email no es válido');
        return;
    }

    // Crear FormData
    const formData = new FormData();
    formData.append('name', nombre);
    formData.append('apellidos', apellidos);
    formData.append('email', email);
    
    if (fotoInput.files.length > 0) {
        const archivo = fotoInput.files[0];
        
        // Validar tipo de archivo
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(archivo.type)) {
            alert('La imagen debe ser JPG, PNG o WEBP');
            return;
        }
        
        // Validar tamaño
        if (archivo.size > 2048 * 1024) {
            alert('La imagen no puede exceder 2MB');
            return;
        }
        
        formData.append('foto_perfil', archivo);
    }

    // Enviar datos
    fetch('/perfil', {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => { throw data; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Perfil actualizado correctamente');
            // Actualizar avatar en el header
            const avatarImg = document.getElementById('avatarHeaderImg');
            if (avatarImg && data.usuario.foto_perfil) {
                avatarImg.src = data.usuario.foto_perfil;
            }
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalPerfil'));
            modal.hide();
        } else {
            // Mostrar errores de validación
            if (data.errors) {
                const errorMsg = Object.values(data.errors).flat().join('\n');
                alert('Errores de validación:\n' + errorMsg);
            } else {
                alert(data.message || 'Error al actualizar el perfil');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            const errorMsg = Object.values(error.errors).flat().join('\n');
            alert('Errores de validación:\n' + errorMsg);
        } else if (error.message) {
            alert('Error: ' + error.message);
        } else {
            alert('Error al actualizar el perfil');
        }
    });
}

// Validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
// Preview de imagen
document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('perfilFotoInput');
    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('perfilAvatarImg').src = e.target.result;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
});
// ========== NOTIFICACIONES ==========

// Cargar notificaciones
function cargarNotificaciones() {
    fetch('/notificaciones', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const contenedor = document.getElementById('notificacionesContenido');
            const badge = document.getElementById('notificacionesBadge');

            // Actualizar badge
            if (data.no_leidas > 0) {
                badge.textContent = data.no_leidas;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }

            // Mostrar notificaciones
            if (data.notificaciones.length === 0) {
                contenedor.innerHTML = '<div class="notificaciones-vacia"><i class="bi bi-inbox"></i><p>No hay notificaciones</p></div>';
            } else {
                let html = '';
                data.notificaciones.forEach(notif => {
                    const clase = notif.leida ? '' : 'no-leida';
                    const fecha = new Date(notif.created_at).toLocaleDateString('es-ES');

                    html += `
                        <div class="notificacion-item ${clase}">
                            <h6 class="notificacion-titulo">${notif.titulo}</h6>
                            <p class="notificacion-mensaje">${notif.mensaje}</p>
                            <p class="notificacion-fecha">${fecha}</p>
                            <div class="notificacion-acciones">
                                ${!notif.leida ? `<button class="notificacion-btn-leida" onclick="marcarNotificacionLeida(${notif.id})">✓</button>` : ''}
                                <button class="notificacion-btn-eliminar" onclick="eliminarNotificacion(${notif.id})">✕</button>
                            </div>
                        </div>
                    `;
                });
                contenedor.innerHTML = html;
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

// Abrir panel de notificaciones
function abrirPanelNotificaciones() {
    cargarNotificaciones();
    const panel = document.getElementById('notificacionesPanel');
    panel.classList.add('active');
}

// Cerrar panel de notificaciones
function cerrarPanelNotificaciones() {
    const panel = document.getElementById('notificacionesPanel');
    panel.classList.remove('active');
}

// Marcar notificación como leída
function marcarNotificacionLeida(id) {
    fetch(`/notificaciones/${id}/leida`, {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarNotificaciones();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Marcar todas como leídas
function marcarTodasLeidas() {
    fetch('/notificaciones/marcar-todas-leidas', {
        method: 'PUT',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            cargarNotificaciones();
        }
    })
    .catch(error => console.error('Error:', error));
}

// Eliminar notificación
function eliminarNotificacion(id) {
    if (confirm('¿Estás seguro?')) {
        fetch(`/notificaciones/${id}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cargarNotificaciones();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Cerrar panel al hacer clic fuera
document.addEventListener('click', function(event) {
    const panel = document.getElementById('notificacionesPanel');
    const btnNotificaciones = document.getElementById('btnNotificaciones');
    
    if (panel && !panel.contains(event.target) && event.target !== btnNotificaciones && !btnNotificaciones.contains(event.target)) {
        cerrarPanelNotificaciones();
    }
});

