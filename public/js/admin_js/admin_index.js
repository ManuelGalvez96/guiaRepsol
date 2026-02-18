// JavaScript para panel admin 
var csrfToken;
var restaurantModal;
var adminIndexRoute;
var adminCreateRoute;

// Usar DOMContentLoaded en lugar de window.onload para mayor compatibilidad
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== admin_index.js DOMContentLoaded ===');
    
    // Obtener token CSRF del atributo data-csrf del body
    csrfToken = document.body.getAttribute('data-csrf');
    if (!csrfToken) {
        var metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }
    console.log('✓ CSRF Token obtenido:', !!csrfToken);
    
    adminIndexRoute = document.body.getAttribute('data-route-index') || '/admin/restaurantes';
    adminCreateRoute = document.body.getAttribute('data-route-create') || '/admin/restaurantes/create';
    console.log('✓ adminIndexRoute:', adminIndexRoute);
    console.log('✓ adminCreateRoute:', adminCreateRoute);
    
    // Inicializar modal de Bootstrap con un pequeño delay para asegurar que Bootstrap esté cargado
    setTimeout(function() {
        const modalElement = document.getElementById('restaurantModal');
        console.log('✓ Modal element encontrado:', !!modalElement);
        console.log('✓ Bootstrap disponible:', typeof bootstrap !== 'undefined');
        
        if (modalElement && typeof bootstrap !== 'undefined') {
            restaurantModal = new bootstrap.Modal(modalElement);
            console.log('✓ restaurantModal inicializado');
        } else if (!modalElement) {
            console.error('✗ Modal element #restaurantModal no encontrado');
        } else if (typeof bootstrap === 'undefined') {
            console.error('✗ Bootstrap no está cargado');
        }
    }, 100);
    
    // Inicializar filtros
    console.log('Llamando initFiltros()');
    initFiltros();
    
    // Configurar event listeners (reemplaza los onclick inline)
    console.log('Llamando setupEventListeners()');
    setupEventListeners();
});

// Función para configurar event listeners
function openCreateModal() {
    console.log('=== openCreateModal() llamado ===');
    
    if (!restaurantModal) {
        console.error('✗ restaurantModal no está inicializado');
        // Intentar inicializar el modal si no existe
        const modalElement = document.getElementById('restaurantModal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            restaurantModal = new bootstrap.Modal(modalElement);
            console.log('✓ restaurantModal inicializado en openCreateModal');
        } else {
            alert('Error: No se puede abrir el modal. Por favor, recarga la página.');
            return;
        }
    }
    
    const modalTitle = document.getElementById('restaurantModalLabel');
    const modalBody = document.getElementById('modalBody');
    
    if (!modalTitle || !modalBody) {
        console.error('✗ Elementos del modal no encontrados');
        return;
    }
    
    console.log('✓ Modal elementos encontrados. Mostrando modal...');
    modalTitle.textContent = 'Crear Restaurante';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Cargando...</span></div><br>Cargando formulario...</div>';
    
    // Mostrar modal con Bootstrap
    restaurantModal.show();
    console.log('✓ Modal visible');
    
    // Cargar formulario via fetch
    console.log('Cargando formulario desde:', adminCreateRoute);
    fetch(adminCreateRoute, {
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
        
        // Agregar listener para botón de cerrar modal CON DELAY para asegurar que el DOM esté listo
        setTimeout(function() {
            setupFormModalListeners();
        }, 100);
    })
    .catch(error => {
        console.error('Error al cargar el formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
    });
}

// Función para abrir modal de editar restaurante  
function openEditModal(restauranteId) {
    console.log('=== openEditModal() llamado con ID:', restauranteId, '===');
    
    if (!restaurantModal) {
        console.error('✗ restaurantModal no está inicializado');
        // Intentar inicializar el modal si no existe
        const modalElement = document.getElementById('restaurantModal');
        if (modalElement && typeof bootstrap !== 'undefined') {
            restaurantModal = new bootstrap.Modal(modalElement);
            console.log('✓ restaurantModal inicializado en openEditModal');
        } else {
            alert('Error: No se puede abrir el modal. Por favor, recarga la página.');
            return;
        }
    }
    
    const modalTitle = document.getElementById('restaurantModalLabel');
    const modalBody = document.getElementById('modalBody');
    
    if (!modalTitle || !modalBody) {
        console.error('✗ Elementos del modal no encontrados');
        return;
    }
    
    console.log('✓ Modal elementos encontrados. Mostrando modal...');
    modalTitle.textContent = 'Editar Restaurante';
    modalBody.innerHTML = '<div style="text-align: center; padding: 20px;"><div class="spinner-border text-warning" role="status"><span class="visually-hidden">Cargando...</span></div><br>Cargando formulario...</div>';
    
    // Mostrar modal con Bootstrap
    restaurantModal.show();
    console.log('✓ Modal visible');
    
    // Cargar formulario via fetch
    const editUrl = `${adminIndexRoute}/${restauranteId}/edit`;
    console.log('Cargando formulario desde:', editUrl);
    fetch(editUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text();
    })
    .then(html => {
        console.log('✓ Formulario recibido, longitud:', html.length);
        modalBody.innerHTML = html;
        
        // Pequeño delay para asegurar que el DOM esté actualizado
        setTimeout(function() {
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
                try {
                    window.initializeEditForm();
                    console.log('✓ initializeEditForm ejecutado');
                } catch (e) {
                    console.error('✗ Error en initializeEditForm:', e);
                }
            } else {
                console.warn('⚠ initializeEditForm no está definido');
            }
            
            // Inicializar validaciones DESPUÉS de cargar el contenido
            if (typeof window.initValidacionEditar === 'function') {
                try {
                    window.initValidacionEditar();
                    console.log('✓ initValidacionEditar ejecutado');
                } catch (e) {
                    console.error('✗ Error en initValidacionEditar:', e);
                }
            } else {
                console.warn('⚠ initValidacionEditar no está definido');
            }
            
            // Agregar listener específicamente para botones de cerrar modal en el modal
            setupFormModalListeners();
            
            console.log('Formulario de edición inyectado y configurado');
        }, 100);
    })
    .catch(error => {
        console.error('Error al cargar el formulario:', error);
        modalBody.innerHTML = '<div style="text-align: center; color: #e74c3c; padding: 20px;">Error al cargar el formulario</div>';
    });
}

// Función para cerrar modal (mantener para compatibilidad)
function closeModal() {
    if (restaurantModal) {
        restaurantModal.hide();
    }
}

// Hacer funciones disponibles globalmente
window.openCreateModal = openCreateModal;
window.openEditModal = openEditModal;
window.closeModal = closeModal;
console.log('Funciones globales expuestas:', { 
    openCreateModal: typeof window.openCreateModal, 
    openEditModal: typeof window.openEditModal, 
    closeModal: typeof window.closeModal 
});

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

// Función manejadora para clicks en botones de tabla (edit/delete)
function handleTableButtonClick(e) {
    console.log('=== handleTableButtonClick EJECUTADO ===');
    console.log('Click en tabla. Event:', e);
    console.log('Target element:', e.target);
    console.log('Target classes:', e.target.className);
    console.log('Target tag:', e.target.tagName);
    
    // Botón de editar
    const editBtn = e.target.closest('.action-edit-btn');
    if (editBtn) {
        const restauranteId = editBtn.getAttribute('data-restaurante-id');
        console.log('✓✓✓ Botón EDIT DETECTADO. ID:', restauranteId);
        e.preventDefault();
        e.stopPropagation();
        openEditModal(restauranteId);
        return;
    }
    
    // Botón de eliminar
    const deleteBtn = e.target.closest('.action-delete-btn');
    if (deleteBtn) {
        const restauranteId = deleteBtn.getAttribute('data-restaurante-id');
        console.log('✓✓✓ Botón DELETE DETECTADO. ID:', restauranteId);
        e.preventDefault();
        e.stopPropagation();
        deleteRestaurante(restauranteId);
        return;
    }
    
    console.log('ℹ Click en tabla pero no en botones de acción');
}

// Función para configurar SOLO los listeners de la tabla
function setupTableListeners() {
    const container = document.getElementById('restaurantesContainer');
    console.log('=== setupTableListeners() CALLED ===');
    console.log('Container encontrado:', !!container);
    
    if (container) {
        console.log('Container elemento:', container);
        console.log('Container HTML sample:', container.innerHTML.substring(0, 200));
        
        // Verificar que los botones existan
        const editBtns = container.querySelectorAll('.action-edit-btn');
        const deleteBtns = container.querySelectorAll('.action-delete-btn');
        console.log('Botones .action-edit-btn encontrados:', editBtns.length);
        console.log('Botones .action-delete-btn encontrados:', deleteBtns.length);
        
        // Remover listener anterior para evitar duplicados
        container.removeEventListener('click', handleTableButtonClick);
        
        // Agregar nuevo listener
        container.addEventListener('click', handleTableButtonClick);
        console.log('✓ Listeners de tabla configurados correctamente');
    } else {
        console.error('✗ restaurantesContainer NO encontrado');
    }
}

// Función para configurar event listeners en lugar de usar onclick inline
function setupEventListeners() {
    console.log('=== setupEventListeners() ===');
    
    // Botón de logout
    const logoutBtn = document.querySelector('.logout-btn');
    console.log('✓ Botón logout encontrado:', !!logoutBtn);
    if (logoutBtn) {
        logoutBtn.addEventListener('click', logoutUser);
        console.log('✓ Listener logout configurado');
    }
    
    // Botón de crear restaurante
    const createBtn = document.getElementById('openCreateBtn');
    console.log('✓ Botón crear (openCreateBtn) encontrado:', !!createBtn);
    if (createBtn) {
        createBtn.addEventListener('click', openCreateModal);
        console.log('✓ Listener crear configurado');
    } else {
        console.error('✗ Botón openCreateBtn NO encontrado');
    }
    
    // Botón de reset de filtros
    const resetBtn = document.getElementById('resetFilters');
    console.log('✓ Botón reset (resetFilters) encontrado:', !!resetBtn);
    if (resetBtn) {
        resetBtn.addEventListener('click', resetearFiltros);
        console.log('✓ Listener reset configurado');
    }
    
    // Configurar listeners de tabla
    console.log('Configurando setupTableListeners()...');
    setupTableListeners();
    
    // Los botones .close-modal-btn se configurarán en setupFormModalListeners()
    // cuando se inyecten en el modal dinámicamente
}

// Función para configurar event listeners para formularios cargados dinámicamente en el modal
function setupFormModalListeners() {
    console.log('setupFormModalListeners called');
    
    // Buscar dentro del modal específicamente
    const modalBody = document.getElementById('modalBody');
    if (!modalBody) {
        console.error('modalBody NO encontrado');
        return;
    }
    
    // Buscar todos los botones de cerrar modal dentro del modal
    const closeModalBtns = modalBody.querySelectorAll('.close-modal-btn');
    console.log('Botones close-modal-btn encontrados en modalBody:', closeModalBtns.length);
    
    if (closeModalBtns.length === 0) {
        console.warn('No se encontraron botones close-modal-btn en modalBody');
        // Intentar buscar también en todo el documento como fallback
        const allBtns = document.querySelectorAll('.close-modal-btn');
        console.log('Botones en documento completo:', allBtns.length);
        return;
    }
    
    closeModalBtns.forEach((btn, index) => {
        console.log(`Procesando botón ${index + 1}:`, btn);
        
        // Remover listeners previos para evitar duplicados
        btn.removeEventListener('click', closeModal);
        
        // Agregar nuevo listener explícitamente
        const clickHandler = function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Botón cerrar modal clickeado');
            closeModal();
        };
        
        btn.addEventListener('click', clickHandler);
        console.log(`Listener configurado correctamente para botón ${index + 1}`);
    });
}

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
    var selectEstado = document.getElementById('filterEstado');
    var selectTipo = document.getElementById('filterTipoComida');
    var selectValoracion = document.getElementById('filterValoracion');
    var selectPrecio = document.getElementById('filterPrecio');

    if (inputBuscar) inputBuscar.value = '';
    if (selectEstado) selectEstado.value = ''; // Resetear a todos los estados
    if (selectTipo) selectTipo.value = '';
    if (selectValoracion) selectValoracion.value = '';
    if (selectPrecio) selectPrecio.value = '';
    aplicarFiltros();
}

function aplicarFiltros(page) {
    const buscar = document.getElementById('filterBuscar')?.value || '';
    const estado = document.getElementById('filterEstado')?.value || '';
    const tipoComida = document.getElementById('filterTipoComida')?.value || '';
    const valoracion = document.getElementById('filterValoracion')?.value || '';
    const precio = document.getElementById('filterPrecio')?.value || '';

    const params = new URLSearchParams();
    if (buscar) params.append('buscar', buscar);
    if (estado) params.append('estado', estado);
    if (tipoComida) params.append('tipo_comida', tipoComida);
    if (valoracion) params.append('valoracion', valoracion);
    if (precio) params.append('precio', precio);
    if (page) params.append('page', page);

    const url = (document.body.getAttribute('data-route-index') || '/admin/restaurantes') + '?' + params.toString();

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
            console.log('Tabla actualizada. Re-configurando listeners...');
            // Re-vincular paginación AJAX
            vincularPaginacion();
            // RE-configurar listeners de tabla porque el innerHTML destruyó los anteriores
            setupTableListeners();
        }
    })
    .catch(error => {
        if (container) container.style.opacity = '1';
        console.error('Error al filtrar:', error);
    });
}

function vincularPaginacion() {
    var links = document.querySelectorAll('#restaurantesContainer .pagination a');
    console.log('Vinculando paginación. Enlaces encontrados:', links.length);
    
    for (var i = 0; i < links.length; i++) {
        // Remover onclick antiguo si existe
        links[i].onclick = null;
        
        // Agregar listener moderno (usando closure para capturar i)
        links[i].addEventListener('click', (function(link) {
            return function(e) {
                e.preventDefault();
                var url = new URL(link.href);
                var page = url.searchParams.get('page');
                console.log('Paginación clickeada. Página:', page);
                aplicarFiltros(page);
            };
        })(links[i]));
    }
}

window.aplicarFiltros = aplicarFiltros;
window.filtroConDelay = filtroConDelay;
window.resetearFiltros = resetearFiltros;
window.logoutUser = logoutUser;
window.openCreateModal = openCreateModal;
window.openEditModal = openEditModal;
window.deleteRestaurante = deleteRestaurante;
window.closeModal = closeModal;