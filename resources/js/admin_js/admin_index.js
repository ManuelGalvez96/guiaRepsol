/**
 * Admin Index JavaScript - Funcionalidad principal del panel de administración
 * Incluye: Filtros, búsqueda, paginación, modales, CRUD de restaurantes
 */

// Variables globales
let csrfToken;
let currentFilters = {};
let searchTimeout = null;

// Configuración inicial
document.addEventListener('DOMContentLoaded', function() {
    initializeAdmin();
});

/**
 * Inicialización principal
 */
function initializeAdmin() {
    // Obtener configuración pasada desde PHP
    if (typeof window.adminConfig !== 'undefined') {
        csrfToken = window.adminConfig.csrfToken;
        currentFilters = window.adminConfig.currentFilters;
    } else {
        // Fallback si no se pasó la configuración
        csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Obtener filtros actuales desde el DOM
        const filterBuscarEl = document.getElementById('filterBuscar');
        const filterTipoComidaEl = document.getElementById('filterTipoComida');
        const filterValoracionEl = document.getElementById('filterValoracion');
        const filterPrecioEl = document.getElementById('filterPrecio');
        
        // Obtener página actual desde paginación
        const paginationActive = document.querySelector('.pagination .page-link.active');
        const currentPage = paginationActive ? parseInt(paginationActive.textContent) : 1;
        
        currentFilters = {
            buscar: filterBuscarEl ? filterBuscarEl.value : '',
            tipo_comida: filterTipoComidaEl ? filterTipoComidaEl.value : '',
            valoracion: filterValoracionEl ? filterValoracionEl.value : '',
            precio: filterPrecioEl ? filterPrecioEl.value : '',
            page: currentPage
        };
    }
    
    setupEventListeners();
}

/**
 * Configurar todos los event listeners
 */
function setupEventListeners() {
    // Filtros
    const filterBuscar = document.getElementById('filterBuscar');
    const filterTipoComida = document.getElementById('filterTipoComida');
    const filterValoracion = document.getElementById('filterValoracion');
    const filterPrecio = document.getElementById('filterPrecio');
    const resetFiltersBtn = document.getElementById('resetFilters');

    if (filterBuscar) filterBuscar.addEventListener('input', handleSearchInput);
    if (filterTipoComida) filterTipoComida.addEventListener('change', handleFilterChange);
    if (filterValoracion) filterValoracion.addEventListener('change', handleFilterChange);
    if (filterPrecio) filterPrecio.addEventListener('change', handleFilterChange);
    if (resetFiltersBtn) resetFiltersBtn.addEventListener('click', resetFilters);

    // Paginación (delegación de eventos)
    document.addEventListener('click', function(e) {
        if (e.target.matches('.page-link') && !e.target.classList.contains('active') && !e.target.classList.contains('page-disabled')) {
            e.preventDefault();
            const href = e.target.getAttribute('href');
            if (href) {
                const url = new URL(href, window.location.origin);
                const page = url.searchParams.get('page') || 1;
                loadRestaurantesPage(page);
            }
        }
    });
}

/**
 * Manejo de búsqueda con debounce
 */
function handleSearchInput(e) {
    const searchValue = e.target.value;
    const searchInput = e.target;
    
    // Agregar clase visual de búsqueda
    if (searchValue.length > 0) {
        searchInput.classList.add('searching');
    } else {
        searchInput.classList.remove('searching');
    }
    
    // Limpiar timeout anterior
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    
    // Agregar debounce de 500ms
    searchTimeout = setTimeout(() => {
        currentFilters.buscar = searchValue;
        currentFilters.page = 1; // Resetear a página 1
        loadRestaurantes();
        
        // Remover clase de búsqueda después de cargar
        setTimeout(() => {
            searchInput.classList.remove('searching');
        }, 300);
    }, 500);
}

/**
 * Manejo de cambios en filtros de selección
 */
function handleFilterChange(e) {
    const filterName = e.target.name;
    const filterValue = e.target.value;
    
    currentFilters[filterName] = filterValue;
    currentFilters.page = 1; // Resetear a página 1
    
    loadRestaurantes();
}

/**
 * Resetear todos los filtros
 */
function resetFilters() {
    currentFilters = {
        buscar: '',
        tipo_comida: '',
        valoracion: '',
        precio: '',
        page: 1
    };
    
    // Actualizar campos en la interfaz
    const filterBuscar = document.getElementById('filterBuscar');
    const filterTipoComida = document.getElementById('filterTipoComida');
    const filterValoracion = document.getElementById('filterValoracion');
    const filterPrecio = document.getElementById('filterPrecio');
    
    if (filterBuscar) filterBuscar.value = '';
    if (filterTipoComida) filterTipoComida.value = '';
    if (filterValoracion) filterValoracion.value = '';
    if (filterPrecio) filterPrecio.value = '';
    
    loadRestaurantes();
}

/**
 * Cargar restaurantes con filtros via AJAX
 */
function loadRestaurantes() {
    const params = new URLSearchParams();
    
    Object.keys(currentFilters).forEach(key => {
        if (currentFilters[key]) {
            params.append(key, currentFilters[key]);
        }
    });

    // Mostrar loading
    const container = document.getElementById('restaurantesContainer');
    if (container) {
        container.innerHTML = '<div class="text-center p-40"><div class="loading-spinner"></div><p>Cargando restaurantes...</p></div>';
    }

    // Construir URL dinámicamente
    const baseUrl = window.location.pathname;
    const url = `${baseUrl}?${params.toString()}`;

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        if (container) {
            container.innerHTML = html;
            setupEventListeners(); // Re-establecer listeners para nueva paginación
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar los restaurantes', 'error');
    });
}

/**
 * Cargar página específica de restaurantes
 */
function loadRestaurantesPage(page) {
    currentFilters.page = page;
    loadRestaurantes();
}

/**
 * Eliminar restaurante con confirmación
 */
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
            // Mostrar loading
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
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
                    }).then(() => {
                        loadRestaurantes(); // Recargar tabla con AJAX
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
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al eliminar el restaurante'
                });
            });
        }
    });
}

/**
 * Logout con confirmación
 */
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
            // Construir URL de logout dinámicamente
            const logoutUrl = window.adminConfig?.routes?.logout || '/logout';
            
            fetch(logoutUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
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
                    throw new Error('Error al cerrar sesión');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',  
                    title: 'Error',
                    text: 'Error al cerrar sesión'
                });
            });
        }
    });
}

/**
 * Abrir modal para crear restaurante
 */
function openCreateModal() {
    const modalTitle = document.getElementById('modalTitle');
    if (modalTitle) {
        modalTitle.textContent = 'Crear Nuevo Restaurante';
    }
    
    const createUrl = window.adminConfig?.routes?.adminCreate || '/admin/create';
    fetch(createUrl, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Extraer solo el contenido del formulario
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const form = doc.querySelector('form');
        
        const modalBody = document.getElementById('modalBody');
        const modalOverlay = document.getElementById('modalOverlay');
        
        if (modalBody && modalOverlay && form) {
            modalBody.innerHTML = form.outerHTML;
            modalOverlay.classList.remove('modal-hidden');
            setupCreateFormHandler();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar el formulario', 'error');
    });
}

/**
 * Abrir modal para editar restaurante
 */
function openEditModal(id) {
    const modalTitle = document.getElementById('modalTitle');
    if (modalTitle) {
        modalTitle.textContent = 'Editar Restaurante';
    }
    
    fetch(`/admin/${id}/edit`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Extraer solo el contenido del formulario
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const form = doc.querySelector('form');
        
        const modalBody = document.getElementById('modalBody');
        const modalOverlay = document.getElementById('modalOverlay');
        
        if (modalBody && modalOverlay && form) {
            modalBody.innerHTML = form.outerHTML;
            modalOverlay.classList.remove('modal-hidden');
            setupEditFormHandler();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Error al cargar el formulario', 'error');
    });
}

/**
 * Cerrar modal
 */
function closeModal() {
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBody = document.getElementById('modalBody');
    
    if (modalOverlay) {
        modalOverlay.classList.add('modal-hidden');
    }
    if (modalBody) {
        modalBody.innerHTML = '';
    }
}

/**
 * Configurar event listener para formulario de crear
 */
function setupCreateFormHandler() {
    const form = document.getElementById('createRestauranteForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitFormAjax(form, 'Creando...', 'Crear Restaurante');
    });
}

/**
 * Configurar event listener para formulario de editar
 */
function setupEditFormHandler() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitFormAjax(form, 'Actualizando...', 'Actualizar Restaurante');
    });
}

/**
 * Submit de formulario via AJAX
 */
function submitFormAjax(form, loadingText, originalText) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const formData = new FormData(form);
    
    // Limpiar errores previos
    form.querySelectorAll('.error').forEach(el => el.remove());
    
    // Mostrar loading
    if (submitBtn) {
        submitBtn.textContent = loadingText;
        submitBtn.disabled = true;
    }
    
    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw data;
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                closeModal();
                loadRestaurantes(); // Recargar tabla
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        if (error.errors) {
            Object.keys(error.errors).forEach(field => {
                const input = form.querySelector(`#${field}`);
                if (input) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error';
                    errorDiv.textContent = error.errors[field][0];
                    input.parentNode.appendChild(errorDiv);
                }
            });
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                text: 'Por favor corrige los errores en el formulario'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Error al procesar la solicitud'
            });
        }
        
        // Restaurar botón
        if (submitBtn) {
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
        }
    });
}

/**
 * Mostrar alertas con SweetAlert2
 */
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

// Hacer funciones disponibles globalmente para uso con onclick en HTML
window.logoutUser = logoutUser;
window.openCreateModal = openCreateModal;
window.openEditModal = openEditModal;
window.closeModal = closeModal;
window.deleteRestaurante = deleteRestaurante;
window.showAlert = showAlert;