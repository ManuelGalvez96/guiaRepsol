// JavaScript para panel admin 
var csrfToken;
var ajaxObj;
var READY_STATE_COMPLETE = 4;

window.onload = () => {
    console.log('Iniciando panel admin...');
    
    // Obtener token CSRF del atributo data-csrf del body
    csrfToken = document.body.getAttribute('data-csrf');
    if (!csrfToken) {
        var metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }
    
    // Inicializar filtros
    initFiltros();
    
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
                
                // Ejecutar scripts que vienen en el HTML inyectado
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
                
                // Inicializar el formulario de edición DESPUÉS de cargar el contenido
                if (typeof window.initEditForm === 'function') {
                    window.initEditForm();
                }
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
    
    // Siempre incluir headers necesarios
    ajaxObj.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    ajaxObj.setRequestHeader('Accept', 'application/json');
    ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    
    if (metodo === 'POST' || metodo === 'DELETE') {
        if (!esFormulario) {
            ajaxObj.setRequestHeader('Content-Type', 'application/json');
        }
    }
    
    ajaxObj.onreadystatechange = funcionCallback;
    
    if ((metodo === 'POST' || metodo === 'DELETE') && !esFormulario) {
        ajaxObj.send(JSON.stringify({}));
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
            const logoutUrl = document.body.getAttribute('data-route-logout') || '/logout';
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

// ==================== FILTROS ====================
let filtroTimeout = null;

function initFiltros() {
    // Los eventos se asignan inline en el HTML (oninput, onchange, onclick)
    console.log('Filtros inicializados');
}

// Función para el input de búsqueda con delay
function filtroConDelay() {
    clearTimeout(filtroTimeout);
    filtroTimeout = setTimeout(function() {
        aplicarFiltros();
    }, 400);
}

// Función para resetear todos los filtros
function resetearFiltros() {
    var inputBuscar = document.getElementById('filterBuscar');
    var selectTipo = document.getElementById('filterTipoComida');
    var selectValoracion = document.getElementById('filterValoracion');
    var selectPrecio = document.getElementById('filterPrecio');

    if (inputBuscar) inputBuscar.value = '';
    if (selectTipo) selectTipo.value = '';
    if (selectValoracion) selectValoracion.value = '';
    if (selectPrecio) selectPrecio.value = '';
    aplicarFiltros();
}

function aplicarFiltros(page) {
    const buscar = document.getElementById('filterBuscar')?.value || '';
    const tipoComida = document.getElementById('filterTipoComida')?.value || '';
    const valoracion = document.getElementById('filterValoracion')?.value || '';
    const precio = document.getElementById('filterPrecio')?.value || '';

    const params = new URLSearchParams();
    if (buscar) params.append('buscar', buscar);
    if (tipoComida) params.append('tipo_comida', tipoComida);
    if (valoracion) params.append('valoracion', valoracion);
    if (precio) params.append('precio', precio);
    if (page) params.append('page', page);

    const url = (document.body.getAttribute('data-route-index') || '/admin') + '?' + params.toString();

    // Actualizar URL del navegador sin recargar
    window.history.replaceState({}, '', url);

    const container = document.getElementById('restaurantesContainer');
    if (container) {
        container.style.opacity = '0.5';
    }

    const ajax = new XMLHttpRequest();
    ajax.open('GET', url);
    ajax.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    ajax.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    ajax.onreadystatechange = function() {
        if (ajax.readyState === READY_STATE_COMPLETE) {
            if (ajax.status === 200) {
                if (container) {
                    container.innerHTML = ajax.responseText;
                    container.style.opacity = '1';
                    // Re-vincular paginación AJAX
                    vincularPaginacion();
                }
            } else {
                if (container) container.style.opacity = '1';
                console.error('Error al filtrar:', ajax.status);
            }
        }
    };
    ajax.send();
}

function vincularPaginacion() {
    var links = document.querySelectorAll('#restaurantesContainer .pagination a');
    for (var i = 0; i < links.length; i++) {
        links[i].onclick = function(e) {
            e.preventDefault();
            var url = new URL(this.href);
            var page = url.searchParams.get('page');
            aplicarFiltros(page);
        };
    }
}

window.aplicarFiltros = aplicarFiltros;
window.filtroConDelay = filtroConDelay;
window.resetearFiltros = resetearFiltros;