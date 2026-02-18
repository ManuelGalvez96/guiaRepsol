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
    // Limpiar errores previos
    limpiarErrores();
    
    const nombre = document.getElementById('perfilNombre').value.trim();
    const apellidos = document.getElementById('perfilApellidos').value.trim();
    const email = document.getElementById('perfilEmail').value.trim();
    const fotoInput = document.getElementById('perfilFotoInput');

    let hayErrores = false;

    // Validar nombre
    if (!nombre) {
        mostrarError('perfilNombre', 'El nombre es obligatorio');
        hayErrores = true;
    } else if (nombre.length < 2) {
        mostrarError('perfilNombre', 'El nombre debe tener al menos 2 caracteres');
        hayErrores = true;
    } else if (nombre.length > 50) {
        mostrarError('perfilNombre', 'El nombre no puede exceder 50 caracteres');
        hayErrores = true;
    } else {
        marcarCampoValido('perfilNombre');
    }

    // Validar apellidos
    if (!apellidos) {
        mostrarError('perfilApellidos', 'Los apellidos son obligatorios');
        hayErrores = true;
    } else if (apellidos.length < 2) {
        mostrarError('perfilApellidos', 'Los apellidos deben tener al menos 2 caracteres');
        hayErrores = true;
    } else if (apellidos.length > 100) {
        mostrarError('perfilApellidos', 'Los apellidos no pueden exceder 100 caracteres');
        hayErrores = true;
    } else {
        marcarCampoValido('perfilApellidos');
    }

    // Validar email
    if (!email) {
        mostrarError('perfilEmail', 'El email es obligatorio');
        hayErrores = true;
    } else if (!validarEmail(email)) {
        mostrarError('perfilEmail', 'El email no es válido');
        hayErrores = true;
    } else if (email.length > 255) {
        mostrarError('perfilEmail', 'El email no puede exceder 255 caracteres');
        hayErrores = true;
    } else {
        marcarCampoValido('perfilEmail');
    }

    // Validar foto si hay una seleccionada
    if (fotoInput.files.length > 0) {
        const archivo = fotoInput.files[0];
        
        if (!['image/jpeg', 'image/png', 'image/webp', 'image/jpg'].includes(archivo.type)) {
            mostrarError('perfilFoto', 'La imagen debe ser JPG, PNG o WEBP');
            hayErrores = true;
        } else if (archivo.size > 2048 * 1024) {
            mostrarError('perfilFoto', 'La imagen no puede exceder 2MB');
            hayErrores = true;
        }
    }

    // Si hay errores, detener el envío
    if (hayErrores) {
        return;
    }

    // Crear FormData
    const formData = new FormData();
    formData.append('_method', 'PUT'); // Simular método PUT para Laravel
    formData.append('name', nombre);
    formData.append('apellidos', apellidos);
    formData.append('email', email);
    
    if (fotoInput.files.length > 0) {
        formData.append('foto_perfil', fotoInput.files[0]);
    }

    // Deshabilitar botón de guardar mientras se procesa
    const btnGuardar = event.target || document.querySelector('.modal-footer .btn-primary');
    const textoOriginal = btnGuardar ? btnGuardar.textContent : '';
    if (btnGuardar) {
        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Guardando...';
    }

    // Enviar datos usando POST con _method=PUT para que Laravel parsee el FormData correctamente
    fetch('/perfil', {
        method: 'POST',
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
            // Actualizar avatar en el header
            const avatarImg = document.getElementById('avatarHeaderImg');
            if (avatarImg && data.usuario.foto_perfil) {
                avatarImg.src = data.usuario.foto_perfil;
            }
            
            // Actualizar avatar en el modal
            const perfilAvatarImg = document.getElementById('perfilAvatarImg');
            if (perfilAvatarImg && data.usuario.foto_perfil) {
                perfilAvatarImg.src = data.usuario.foto_perfil;
            }
            
            // Mostrar mensaje de éxito
            mostrarMensajeExito('Perfil actualizado correctamente');
            
            // Cerrar modal después de 1 segundo
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalPerfil'));
                modal.hide();
            }, 1000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Mostrar errores de validación del servidor
        if (error.errors) {
            Object.keys(error.errors).forEach(campo => {
                let campoId = campo;
                
                // Mapear nombres de campos del servidor a IDs del formulario
                if (campo === 'name') campoId = 'perfilNombre';
                else if (campo === 'apellidos') campoId = 'perfilApellidos';
                else if (campo === 'email') campoId = 'perfilEmail';
                else if (campo === 'foto_perfil') campoId = 'perfilFoto';
                
                mostrarError(campoId, error.errors[campo][0]);
            });
        } else if (error.message) {
            mostrarError('perfilNombre', error.message);
        } else {
            mostrarError('perfilNombre', 'Error al actualizar el perfil. Por favor, inténtalo de nuevo.');
        }
    })
    .finally(() => {
        // Rehabilitar botón
        if (btnGuardar) {
            btnGuardar.disabled = false;
            btnGuardar.textContent = textoOriginal || 'Guardar Cambios';
        }
    });
}

// Función para mostrar error en un campo
function mostrarError(campoId, mensaje) {
    const campo = document.getElementById(campoId);
    const errorDiv = document.getElementById('error' + campoId.charAt(0).toUpperCase() + campoId.slice(1));
    
    if (campo && !campoId.includes('Foto')) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
    }
    
    if (errorDiv) {
        errorDiv.textContent = mensaje;
        errorDiv.classList.add('d-block');
    }
}

// Función para marcar campo como válido
function marcarCampoValido(campoId) {
    const campo = document.getElementById(campoId);
    const errorDiv = document.getElementById('error' + campoId.charAt(0).toUpperCase() + campoId.slice(1));
    
    if (campo) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
    }
    
    if (errorDiv) {
        errorDiv.textContent = '';
        errorDiv.classList.remove('d-block');
    }
}

// Función para limpiar todos los errores
function limpiarErrores() {
    const campos = ['perfilNombre', 'perfilApellidos', 'perfilEmail'];
    campos.forEach(campoId => {
        const campo = document.getElementById(campoId);
        const errorDiv = document.getElementById('error' + campoId.charAt(0).toUpperCase() + campoId.slice(1));
        
        if (campo) {
            campo.classList.remove('is-invalid', 'is-valid');
        }
        
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.classList.remove('d-block');
        }
    });
    
    // Limpiar error de foto
    const errorFoto = document.getElementById('errorPerfilFoto');
    if (errorFoto) {
        errorFoto.textContent = '';
        errorFoto.classList.remove('d-block');
    }
}

// Función para mostrar mensaje de éxito
function mostrarMensajeExito(mensaje) {
    // Crear un div temporal para el mensaje de éxito
    const modalBody = document.querySelector('#modalPerfil .modal-body');
    
    // Remover mensaje existente si hay uno
    const mensajeExistente = modalBody.querySelector('.alert-success');
    if (mensajeExistente) {
        mensajeExistente.remove();
    }
    
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show';
    alertDiv.innerHTML = `
        <i class="bi bi-check-circle-fill me-2"></i>${mensaje}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    modalBody.insertBefore(alertDiv, modalBody.firstChild);
}


// Validar email
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
// Preview de imagen y validación en tiempo real
document.addEventListener('DOMContentLoaded', function() {
    // Preview de foto de perfil
    const fotoInput = document.getElementById('perfilFotoInput');
    if (fotoInput) {
        fotoInput.addEventListener('change', function() {
            // Limpiar error previo
            const errorFoto = document.getElementById('errorPerfilFoto');
            if (errorFoto) {
                errorFoto.textContent = '';
                errorFoto.classList.remove('d-block');
            }
            
            if (this.files && this.files[0]) {
                const archivo = this.files[0];
                
                // Validar tipo y tamaño
                if (!['image/jpeg', 'image/png', 'image/webp', 'image/jpg'].includes(archivo.type)) {
                    mostrarError('perfilFoto', 'La imagen debe ser JPG, PNG o WEBP');
                    this.value = '';
                    return;
                }
                
                if (archivo.size > 2048 * 1024) {
                    mostrarError('perfilFoto', 'La imagen no puede exceder 2MB');
                    this.value = '';
                    return;
                }
                
                // Mostrar preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('perfilAvatarImg').src = e.target.result;
                };
                reader.readAsDataURL(archivo);
            }
        });
    }
    
    // Validación en tiempo real para nombre
    const nombreInput = document.getElementById('perfilNombre');
    if (nombreInput) {
        nombreInput.addEventListener('input', function() {
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError('perfilNombre', 'El nombre es obligatorio');
            } else if (valor.length < 2) {
                mostrarError('perfilNombre', 'El nombre debe tener al menos 2 caracteres');
            } else if (valor.length > 50) {
                mostrarError('perfilNombre', 'El nombre no puede exceder 50 caracteres');
            } else {
                marcarCampoValido('perfilNombre');
            }
        });
    }
    
    // Validación en tiempo real para apellidos
    const apellidosInput = document.getElementById('perfilApellidos');
    if (apellidosInput) {
        apellidosInput.addEventListener('input', function() {
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError('perfilApellidos', 'Los apellidos son obligatorios');
            } else if (valor.length < 2) {
                mostrarError('perfilApellidos', 'Los apellidos deben tener al menos 2 caracteres');
            } else if (valor.length > 100) {
                mostrarError('perfilApellidos', 'Los apellidos no pueden exceder 100 caracteres');
            } else {
                marcarCampoValido('perfilApellidos');
            }
        });
    }
    
    // Validación en tiempo real para email
    const emailInput = document.getElementById('perfilEmail');
    if (emailInput) {
        emailInput.addEventListener('input', function() {
            const valor = this.value.trim();
            
            if (!valor) {
                mostrarError('perfilEmail', 'El email es obligatorio');
            } else if (!validarEmail(valor)) {
                mostrarError('perfilEmail', 'El email no es válido');
            } else if (valor.length > 255) {
                mostrarError('perfilEmail', 'El email no puede exceder 255 caracteres');
            } else {
                marcarCampoValido('perfilEmail');
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

