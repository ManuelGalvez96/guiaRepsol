// JavaScript para el panel de administración
// Aqui esta todo lo de filtros, AJAX, modales ...

// Variables globales
let csrfToken;
let currentFilters = {};
let searchTimeout = null;

// Cuando cargue la página, inicializar todo
document.addEventListener('DOMContentLoaded', function () {
    console.log('Iniciando panel admin...');
    initializeAdmin();
});

// Inicializar configuración
function initializeAdmin() {
    // Obtener el token CSRF y los filtros desde PHP
    if (typeof window.adminConfig !== 'undefined') {
        csrfToken = window.adminConfig.csrfToken;
        currentFilters = window.adminConfig.currentFilters;
        console.log('Configuración cargada:', currentFilters);
    } else {
        // Por si acaso no se pasó la config
        csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Obtener filtros del DOM
        const filterBuscarEl = document.getElementById('filterBuscar');
        const filterTipoComidaEl = document.getElementById('filterTipoComida');
        const filterValoracionEl = document.getElementById('filterValoracion');
        const filterPrecioEl = document.getElementById('filterPrecio');

        // Página actual
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

// Configurar todos los listeners
function setupEventListeners() {
    // Los filtros
    const filterBuscar = document.getElementById('filterBuscar');
    const filterTipoComida = document.getElementById('filterTipoComida');
    const filterValoracion = document.getElementById('filterValoracion');
    const filterPrecio = document.getElementById('filterPrecio');
    const resetFiltersBtn = document.getElementById('resetFilters');

    if (filterBuscar && !filterBuscar.hasListener) {
        filterBuscar.addEventListener('input', handleSearchInput);
        filterBuscar.hasListener = true;
    }
    if (filterTipoComida && !filterTipoComida.hasListener) {
        filterTipoComida.addEventListener('change', handleFilterChange);
        filterTipoComida.hasListener = true;
    }
    if (filterValoracion && !filterValoracion.hasListener) {
        filterValoracion.addEventListener('change', handleFilterChange);
        filterValoracion.hasListener = true;
    }
    if (filterPrecio && !filterPrecio.hasListener) {
        filterPrecio.addEventListener('change', handleFilterChange);
        filterPrecio.hasListener = true;
    }
    if (resetFiltersBtn && !resetFiltersBtn.hasListener) {
        resetFiltersBtn.addEventListener('click', resetFilters);
        resetFiltersBtn.hasListener = true;
    }

    // Paginación - usar delegación de eventos para que funcione con AJAX
    if (!document.hasPaginationListener) {
        document.addEventListener('click', function (e) {
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
        document.hasPaginationListener = true;
    }
}

// Búsqueda con delay para no hacer petición a cada letra
function handleSearchInput(e) {
    const searchValue = e.target.value;
    const searchInput = e.target;

    // Efecto visual mientras busca
    if (searchValue.length > 0) {
        searchInput.classList.add('searching');
    } else {
        searchInput.classList.remove('searching');
    }

    // Cancelar búsqueda anterior si todavía no se ejecutó
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }

    // Esperar 500ms antes de buscar (por si sigue escribiendo)
    searchTimeout = setTimeout(() => {
        currentFilters.buscar = searchValue;
        currentFilters.page = 1; // volver a página 1
        loadRestaurantes();

        // Quitar efecto visual
        setTimeout(() => {
            searchInput.classList.remove('searching');
        }, 300);
    }, 500);
}

// Cuando cambia un filtro (select)
function handleFilterChange(e) {
    const filterName = e.target.name;
    const filterValue = e.target.value;

    console.log('Filtro cambiado:', filterName, '=', filterValue); // para debug

    currentFilters[filterName] = filterValue;
    currentFilters.page = 1; // resetear página

    loadRestaurantes();
}

// Limpiar todos los filtros
function resetFilters() {
    console.log('Limpiando filtros...');

    currentFilters = {
        buscar: '',
        tipo_comida: '',
        valoracion: '',
        precio: '',
        page: 1
    };

    // Actualizar los campos en la interfaz
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

// Cargar restaurantes con AJAX
function loadRestaurantes() {
    const params = new URLSearchParams();

    // Agregar todos los filtros activos
    Object.keys(currentFilters).forEach(key => {
        if (currentFilters[key]) {
            params.append(key, currentFilters[key]);
        }
    });

    // Mostrar spinner de carga
    const container = document.getElementById('restaurantesContainer');
    if (container) {
        container.innerHTML = '<div class="text-center p-40"><div class="loading-spinner"></div><p>Cargando restaurantes...</p></div>';
    }

    // Construir URL
    const baseUrl = window.location.pathname;
    const url = `${baseUrl}?${params.toString()}`;

    console.log('Cargando:', url); // debug

    fetch(url, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
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
                console.log('Restaurantes cargados correctamente');
            }
        })
        .catch(error => {
            console.error('Error cargando restaurantes:', error);
            if (container) {
                container.innerHTML = '<div class="text-center p-40"><p>Error al cargar los restaurantes. Por favor intenta de nuevo.</p></div>';
            }
            showAlert('Error al cargar los restaurantes', 'error');
        });
}

// Cargar una página específica
function loadRestaurantesPage(page) {
    console.log('Cargando página:', page);
    currentFilters.page = page;
    loadRestaurantes();
}

// Eliminar restaurante - primero pregunta para estar seguro
function deleteRestaurante(id) {
    console.log('Intentando eliminar restaurante:', id);

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
            // Mostrar que está procesando
            Swal.fire({
                title: 'Eliminando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Hacer la petición DELETE
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
                        console.log('Restaurante eliminado correctamente');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminado!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            loadRestaurantes(); // recargar la tabla
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

// Modal para crear restaurante
function openCreateModal() {
    console.log('Abriendo modal de crear restaurante');
    const modalTitle = document.getElementById('modalTitle');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBody = document.getElementById('modalBody');
    
    if (modalTitle) {
        modalTitle.textContent = 'Crear Nuevo Restaurante';
    }

    // Mostrar loading
    if (modalBody) {
        modalBody.innerHTML = '<div class="text-center p-40"><div class="loading-spinner"></div><p>Cargando formulario...</p></div>';
    }
    
    if (modalOverlay) {
        modalOverlay.classList.remove('modal-hidden');
    }

    const createUrl = window.adminConfig?.routes?.adminCreate || '/admin/create';
    console.log('Fetching:', createUrl);

    fetch(createUrl, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('Formulario de crear cargado');
            // Sacar solo el formulario del HTML que devuelve
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const form = doc.querySelector('form');

            const modalBody = document.getElementById('modalBody');
            const modalOverlay = document.getElementById('modalOverlay');

            if (modalBody && modalOverlay && form) {
                modalBody.innerHTML = form.outerHTML;
                modalOverlay.classList.remove('modal-hidden');
                setupCreateFormHandler(); // configurar el submit del form
            }
        })
        .catch(error => {
            console.error('Error cargando formulario:', error);
            showAlert('Error al cargar el formulario', 'error');
        });
}

// Modal para editar restaurante
function openEditModal(id) {
    console.log('Abriendo modal para editar:', id);

    const modalTitle = document.getElementById('modalTitle');
    const modalOverlay = document.getElementById('modalOverlay');
    const modalBody = document.getElementById('modalBody');
    
    if (modalTitle) {
        modalTitle.textContent = 'Editar Restaurante';
    }

    // Mostrar loading
    if (modalBody) {
        modalBody.innerHTML = '<div class="text-center p-40"><div class="loading-spinner"></div><p>Cargando formulario...</p></div>';
    }
    
    if (modalOverlay) {
        modalOverlay.classList.remove('modal-hidden');
    }

    fetch(`/admin/${id}/edit`, {
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            console.log('Formulario de editar cargado');
            // Igual que en crear, sacar solo el form
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const form = doc.querySelector('form');

            if (modalBody && form) {
                modalBody.innerHTML = form.outerHTML;
                setupEditFormHandler();
            } else {
                console.error('No se encontró el formulario');
                showAlert('Error: No se pudo cargar el formulario', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (modalBody) {
                modalBody.innerHTML = '<div class="text-center p-40"><p>Error al cargar el formulario. Por favor intenta de nuevo.</p></div>';
            }
            showAlert('Error al cargar el formulario', 'error');
        });
}

// Cerrar el modal
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

// Configurar submit del form de crear
function setupCreateFormHandler() {
    const form = document.getElementById('createRestauranteForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('Enviando formulario de crear...');
        submitFormAjax(form, 'Creando...', 'Crear Restaurante');
    });
}

// Configurar submit del form de editar
function setupEditFormHandler() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('Enviando formulario de editar...');
        submitFormAjax(form, 'Actualizando...', 'Actualizar Restaurante');
    });
}

// Enviar formulario con AJAX (funciona para crear y editar)
function submitFormAjax(form, loadingText, originalText) {
    const submitBtn = form.querySelector('button[type="submit"]');
    const formData = new FormData(form);

    // Quitar errores anteriores si los hay
    form.querySelectorAll('.error').forEach(el => el.remove());

    // Cambiar texto del botón y deshabilitarlo
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
                console.log('Operación exitosa!');
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    closeModal();
                    loadRestaurantes(); // recargar tabla
                });
            }
        })
        .catch(error => {
            console.error('Error en submit:', error);

            // Si hay errores de validación, mostrarlos
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

            // Restaurar el botón
            if (submitBtn) {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });
}

// Función para mostrar alertas
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

// Hacer las funciones accesibles desde el HTML (onclick)
window.logoutUser = logoutUser;
window.openCreateModal = openCreateModal;
window.openEditModal = openEditModal;
window.closeModal = closeModal;
window.deleteRestaurante = deleteRestaurante;
window.showAlert = showAlert;