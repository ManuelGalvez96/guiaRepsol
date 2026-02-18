// Configurar CSRF token para todas las peticiones AJAX
let csrfToken;

// Inicializar modal de Bootstrap
let detallesModal;
document.addEventListener('DOMContentLoaded', function() {
    // Obtener CSRF token de forma segura
    const metaCsrf = document.querySelector('meta[name="csrf-token"]');
    if (metaCsrf) {
        csrfToken = metaCsrf.getAttribute('content');
        console.log('CSRF Token obtenido correctamente');
    } else {
        console.error('ERROR: No se encontró el meta tag csrf-token');
    }
    
    // Pequeño delay para asegurar que Bootstrap esté cargado
    setTimeout(function() {
        const modalElement = document.getElementById('detallesModal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            detallesModal = new bootstrap.Modal(modalElement);
        } else if (!modalElement) {
            console.error('Modal element #detallesModal no encontrado');
        } else if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap no está cargado');
        }
    }, 100);
    
    // Configurar event listeners para botones
    setupSolicitudesEventListeners();
});

// Función para configurar event listeners
function setupSolicitudesEventListeners() {
    console.log('=== setupSolicitudesEventListeners() ===');
    
    // Botón de logout
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Cerrar sesión?',
                text: '¿Estás seguro?',
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
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
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
                    })
                    .catch(error => {
                        console.error('Error al cerrar sesión:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al cerrar sesión'
                        });
                    });
                }
            });
        });
    }
    
    // Delegación de eventos en la tabla
    const tbody = document.querySelector('table tbody');
    console.log('✓ table tbody encontrado:', !!tbody);
    
    if (tbody) {
        tbody.addEventListener('click', function(e) {
            console.log('🖱 Click en tabla solicitudes. Target:', e.target.className);
            
            // Botón de ver detalles
            const detallesBtn = e.target.closest('.action-ver-detalles-btn');
            if (detallesBtn) {
                const solicitudId = detallesBtn.getAttribute('data-solicitud-id');
                console.log('✓ Click en VER DETALLES. ID:', solicitudId);
                verDetalles(solicitudId);
                return;
            }
            
            // Botón de aprobar
            const aprobarBtn = e.target.closest('.action-aprobar-btn');
            if (aprobarBtn) {
                const solicitudId = aprobarBtn.getAttribute('data-solicitud-id');
                console.log('✓ Click en APROBAR. ID:', solicitudId);
                aprobarSolicitud(solicitudId);
                return;
            }
            
            // Botón de rechazar
            const rechazarBtn = e.target.closest('.action-rechazar-btn');
            if (rechazarBtn) {
                const solicitudId = rechazarBtn.getAttribute('data-solicitud-id');
                console.log('✓ Click en RECHAZAR. ID:', solicitudId);
                rechazarSolicitud(solicitudId);
                return;
            }
        });
        console.log('✓ Event listeners configurados para tabla solicitudes');
    } else {
        console.warn('⚠ table tbody NO encontrado');
    }
}

// Función para mostrar modal con detalles
function verDetalles(id) {
    const data = window.solicitudesData[id];
    
    if (!data) {
        console.error('No se encontraron datos para la solicitud ID:', id);
        return;
    }
    
    // Rellenar el modal con los datos
    document.getElementById('modalImagen').src = data.imagen;
    
    // Mostrar imágenes adicionales si existen
    const imagenesAdicionalesContainer = document.getElementById('imagenesAdicionalesContainer');
    const imagenesAdicionalesDiv = document.getElementById('imagenesAdicionales');
    
    if (data.imagenes_adicionales && data.imagenes_adicionales.length > 0) {
        imagenesAdicionalesDiv.innerHTML = '';
        data.imagenes_adicionales.forEach(function(url) {
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Imagen adicional';
            img.className = 'img-thumbnail';
            img.style.maxWidth = '100px';
            img.style.cursor = 'pointer';
            img.onclick = function() {
                document.getElementById('modalImagen').src = url;
            };
            imagenesAdicionalesDiv.appendChild(img);
        });
        imagenesAdicionalesContainer.style.display = 'block';
    } else {
        imagenesAdicionalesContainer.style.display = 'none';
    }
    
    document.getElementById('modalNombre').textContent = data.nombre;
    document.getElementById('modalCategoria').textContent = data.categoria;
    document.getElementById('modalDescripcion').textContent = data.descripcion;
    document.getElementById('modalDireccion').textContent = data.direccion;
    document.getElementById('modalCiudad').textContent = data.ciudad;
    document.getElementById('modalProvincia').textContent = data.provincia;
    document.getElementById('modalCodigoPostal').textContent = data.codigo_postal;
    document.getElementById('modalComunidad').textContent = data.comunidad;
    document.getElementById('modalTelefono').textContent = data.telefono || '-';
    document.getElementById('modalEmail').textContent = data.email;
    document.getElementById('modalWeb').textContent = data.web || '-';
    document.getElementById('modalPrecio').textContent = data.precio;
    document.getElementById('modalTiposComida').textContent = data.tipos_comida;
    document.getElementById('modalUsuario').textContent = data.usuario;
    document.getElementById('modalFecha').textContent = data.fecha;
    
    // Mostrar el modal con Bootstrap
    if (detallesModal) {
        detallesModal.show();
    }
}

// Función para cerrar modal (mantener para compatibilidad)
function cerrarModal() {
    if (detallesModal) {
        detallesModal.hide();
    }
}

// Función para aprobar solicitud
function aprobarSolicitud(id) {
    console.log('aprobarSolicitud() llamado con ID:', id);
    console.log('CSRF Token disponible:', csrfToken);
    
    Swal.fire({
        title: '¿Aprobar esta solicitud?',
        text: "El restaurante será visible para todos los usuarios",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#27ae60',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Aprobando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = `/admin/solicitudes/${id}/aprobar`;
            console.log('Enviando POST a:', url);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Aprobado!',
                        text: 'La solicitud ha sido aprobada',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo aprobar la solicitud'
                    });
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al aprobar la solicitud: ' + error.message
                });
            });
        }
    });
}

// Función para rechazar solicitud
function rechazarSolicitud(id) {
    console.log('rechazarSolicitud() llamado con ID:', id);
    console.log('CSRF Token disponible:', csrfToken);
    
    Swal.fire({
        title: '¿Rechazar esta solicitud?',
        text: "El restaurante será eliminado de la base de datos",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Rechazando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = `/admin/solicitudes/${id}/rechazar`;
            console.log('Enviando DELETE a:', url);
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Rechazado!',
                        text: 'La solicitud ha sido rechazada',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo rechazar la solicitud'
                    });
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al rechazar la solicitud: ' + error.message
                });
            });
        }
    });
}

// Hacer funciones disponibles globalmente
window.verDetalles = verDetalles;
window.cerrarModal = cerrarModal;
window.aprobarSolicitud = aprobarSolicitud;
window.rechazarSolicitud = rechazarSolicitud;
