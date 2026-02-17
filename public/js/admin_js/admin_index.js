// JavaScript para panel admin 
var csrfToken;

window.onload = () => {
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
}

// Función para abrir modal de crear restaurante
function openCreateModal() {
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
    
    // Cargar formulario via fetch
    fetch('/admin/create', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        modalBody.innerHTML = html;
        
        // Inicializar validación del formulario de creación
        if (typeof initValidacionCrear === 'function') {
            initValidacionCrear();
        } else {
            console.error('La función initValidacionCrear no está disponible');
        }
        
        // Reinicializar listeners del preview de imágenes
        const imagenesInput = document.getElementById('imagenes');
        if (imagenesInput && typeof previewImages === 'function') {
            imagenesInput.onchange = function(event) {
                previewImages(event);
            };
        }
    })
    .catch(error => {
        console.error('Error al cargar el formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
    });
}

// Función para abrir modal de editar restaurante  
function openEditModal(restauranteId) {
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
    
    // Cargar formulario via fetch
    fetch(`/admin/${restauranteId}/edit`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        modalBody.innerHTML = html;
        
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
        if (typeof window.initializeEditForm === 'function') {
            window.initializeEditForm();
        }
        
        // Inicializar validaciones DESPUÉS de cargar el contenido
        if (typeof window.initValidacionEditar === 'function') {
            window.initValidacionEditar();
        }
    })
    .catch(error => {
        console.error('Error al cargar el formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
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

// Eliminar restaurante 
function deleteRestaurante(id) {
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

            // Eliminar con fetch
            fetch(`/admin/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Eliminado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo eliminar el restaurante'
                    });
                }
            })
            .catch(error => {
                console.error('Error al eliminar:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al eliminar el restaurante'
                });
            });
        }
    });
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
            fetch(logoutUrl, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                if (response.redirected) {
                    window.location.href = response.url;
                    return null;
                }
                const contentType = response.headers.get('content-type') || '';
                if (contentType.includes('application/json')) {
                    return response.json();
                }
                return null;
            })
            .then(data => {
                if (data === null) {
                    return;
                }
                Swal.fire({
                    icon: 'success',
                    title: 'Sesión cerrada',
                    text: 'Hasta la próxima',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '/login';
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

    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        if (container) {
            container.innerHTML = html;
            container.style.opacity = '1';
            // Re-vincular paginación AJAX
            vincularPaginacion();
        }
    })
    .catch(error => {
        if (container) container.style.opacity = '1';
        console.error('Error al filtrar:', error);
    });
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