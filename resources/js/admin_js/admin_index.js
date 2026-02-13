// JavaScript para panel admin 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;

window.onload = () => {
    console.log('Iniciando panel admin...');
    
    // Obtener token CSRF
    if (typeof window.adminConfig !== 'undefined') {
        csrfToken = window.adminConfig.csrfToken;
    } else {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }
    
    console.log('Panel admin cargado');
}

// Función para abrir modal de crear restaurante
function openCreateModal() {
    console.log('Abriendo modal crear...');
    
    const modalOverlay = document.getElementById('modalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    
    if (!modalOverlay || !modalTitle || !modalBody) {
        console.error('Elementos del modal no encontrados');
        return;
    }
    
    modalTitle.textContent = 'Crear Restaurante';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;"><div style="display: inline-block; width: 30px; height: 30px; border: 3px solid #f3f3f3; border-top: 3px solid #ffd500; border-radius: 50%; animation: spin 1s linear infinite;"></div><br>Cargando formulario...</div>';
    
    // Mostrar modal
    modalOverlay.classList.remove('modal-hidden');
    
    // Cargar formulario via AJAX
    peticionAjax('/admin/create', 'GET', function() {
        if (ajaxObj.readyState === READY_STATE_COMPLETE) {
            if (ajaxObj.status === 200) {
                modalBody.innerHTML = ajaxObj.responseText;
                
                // Hacer las funciones disponibles globalmente después de cargar el contenido
                setTimeout(() => {
                    if (typeof window.previewImages === 'function') {
                        console.log('Función previewImages disponible');
                    } else {
                        console.error('Función previewImages NO disponible');
                    }
                }, 100);
            } else {
                modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
            }
        }
    });
}

// Función para abrir modal de editar restaurante  
function openEditModal(restauranteId) {
    console.log('Abriendo modal editar:', restauranteId);
    
    const modalOverlay = document.getElementById('modalOverlay');
    const modalTitle = document.getElementById('modalTitle');
    const modalBody = document.getElementById('modalBody');
    
    if (!modalOverlay || !modalTitle || !modalBody) {
        console.error('Elementos del modal no encontrados');
        return;
    }
    
    modalTitle.textContent = 'Editar Restaurante';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;"><div style="display: inline-block; width: 30px; height: 30px; border: 3px solid #f3f3f3; border-top: 3px solid #ffd500; border-radius: 50%; animation: spin 1s linear infinite;"></div><br>Cargando formulario...</div>';
    
    // Mostrar modal
    modalOverlay.classList.remove('modal-hidden');
    
    // Cargar formulario via AJAX
    peticionAjax(`/admin/${restauranteId}/edit`, 'GET', function() {
        if (ajaxObj.readyState === READY_STATE_COMPLETE) {
            if (ajaxObj.status === 200) {
                modalBody.innerHTML = ajaxObj.responseText;
                
                // Ejecutar scripts que vienen en el HTML inyectado (innerHTML no los ejecuta)
                var scripts = modalBody.querySelectorAll('script');
                scripts.forEach(function(oldScript) {
                    var newScript = document.createElement('script');
                    if (oldScript.src) {
                        newScript.src = oldScript.src;
                    } else {
                        newScript.textContent = oldScript.textContent;
                    }
                    oldScript.parentNode.replaceChild(newScript, oldScript);
                });
                
                // Inicializar funciones del formulario de edición después de cargar el contenido
                setTimeout(() => {
                    console.log('Inicializando formulario de edición en modal...');
                    
                    // Llamar a initEditForm si está disponible
                    if (typeof window.initEditForm === 'function') {
                        window.initEditForm();
                    } else if (typeof initEditForm === 'function') {
                        initEditForm();
                    }
                    
                    // Configurar botones de eliminación de imágenes
                    if (typeof window.setupExistingImageDeleteButtons === 'function') {
                        window.setupExistingImageDeleteButtons();
                    } else if (typeof setupExistingImageDeleteButtons === 'function') {
                        setupExistingImageDeleteButtons();
                    }
                    
                    console.log('Formulario de edición inicializado en modal');
                }, 100);
            } else {
                modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
            }
        }
    });
}

// Función para cerrar modal
function closeModal() {
    const modalOverlay = document.getElementById('modalOverlay');
    if (modalOverlay) {
        modalOverlay.classList.add('modal-hidden');
    }
}

// Hacer funciones disponibles globalmente
window.openCreateModal = openCreateModal;
window.openEditModal = openEditModal;
window.closeModal = closeModal;

// Función AJAX con soporte para diferentes tipos de contenido
function peticionAjax(url, metodo, funcionCallback, esFormulario = false) {
    ajaxObj = new XMLHttpRequest();
    ajaxObj.open(metodo, url);
    
    // Siempre incluir X-Requested-With para identificar peticiones AJAX
    ajaxObj.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    if (metodo === 'POST' || metodo === 'DELETE') {
        if (esFormulario) {
            ajaxObj.setRequestHeader('Accept', 'application/json');
            ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        } else {
            ajaxObj.setRequestHeader('Content-Type', 'application/json');
            ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            ajaxObj.setRequestHeader('Accept', 'application/json');
        }
    } else {
        // Para GET que esperan HTML (para modales)
        ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    }
    
    ajaxObj.onreadystatechange = funcionCallback;
    
    if (metodo === 'POST' || metodo === 'DELETE') {
        if (!esFormulario) {
            ajaxObj.send(JSON.stringify({}));
        } else {
            ajaxObj.send(); // Para FormData se envía sin parámetros
        }
    } else {
        ajaxObj.send();
    }
}

// Eliminar restaurante 
function deleteRestaurante(id) {
    console.log('Eliminar restaurante:', id);

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar cargando
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX con patrón 
            peticionAjax(`/admin/${id}`, 'DELETE', manejarEliminar);
        }
    });
}

function manejarEliminar() {
    if (ajaxObj.readyState == READY_STATE_COMPLETE) {
        if (ajaxObj.status == 200) {
            const data = JSON.parse(ajaxObj.responseText);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Eliminado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // Recargar página simple
                    window.location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar el restaurante'
                });
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al eliminar el restaurante'
            });
        }
    }
}

// Cerrar sesión 
function logoutUser() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        text: "¿Estás seguro de que quieres cerrar sesión?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, cerrar sesión',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const logoutUrl = window.adminConfig?.routes?.logout || '/logout';
            peticionAjax(logoutUrl, 'POST', manejarLogout);
        }
    });
}

function manejarLogout() {
    if (ajaxObj.readyState == READY_STATE_COMPLETE) {
        if (ajaxObj.status == 200) {
            Swal.fire({
                icon: 'success',
                title: 'Sesión cerrada',
                text: 'Hasta la próxima',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = '/login';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al cerrar sesión'
            });
        }
    }
}

// Función simple para mostrar alertas
function showAlert(message, type) {
    Swal.fire({
        icon: type === 'success' ? 'success' : 'error',
        title: type === 'success' ? '¡Éxito!' : 'Error',
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
}

// Hacer funciones disponibles globalmente para onclick
window.logoutUser = logoutUser;
window.deleteRestaurante = deleteRestaurante;
window.showAlert = showAlert;