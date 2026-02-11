<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel de Administración - Guía Repsol</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">guia repsol</div>
        <button type="button" class="logout-btn" onclick="logoutUser()">Cerrar sesión</button>
    </div>

    <!-- Container -->
    <div class="container">
        <div class="top-section">
            <h1>Gestión de restaurantes</h1>
            <button type="button" class="create-btn" onclick="openCreateModal()">Crear Restaurante</button>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filters -->
        <div class="filters">
            <input type="text" name="buscar" class="filter-search" id="filterBuscar" 
                   placeholder="🔍 Buscar restaurante..." 
                   value="{{ request('buscar') }}">

            <select name="tipo_comida" class="filter-select" id="filterTipoComida">
                <option value="">Tipo de comida</option>
                @foreach($tiposComida as $tipo)
                    <option value="{{ $tipo->id }}" {{ request('tipo_comida') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->nombre }}
                    </option>
                @endforeach
            </select>

            <select name="valoracion" class="filter-select" id="filterValoracion">
                <option value="">Valoración</option>
                <option value="5" {{ request('valoracion') == '5' ? 'selected' : '' }}>5 estrellas</option>
                <option value="4" {{ request('valoracion') == '4' ? 'selected' : '' }}>4 estrellas</option>
                <option value="3" {{ request('valoracion') == '3' ? 'selected' : '' }}>3 estrellas</option>
                <option value="2" {{ request('valoracion') == '2' ? 'selected' : '' }}>2 estrellas</option>
                <option value="1" {{ request('valoracion') == '1' ? 'selected' : '' }}>1 estrella</option>
            </select>

            <select name="precio" class="filter-select" id="filterPrecio">
                <option value="">Precio</option>
                <option value="0-10" {{ request('precio') == '0-10' ? 'selected' : '' }}>0-10€</option>
                <option value="10-20" {{ request('precio') == '10-20' ? 'selected' : '' }}>10-20€</option>
                <option value="20-30" {{ request('precio') == '20-30' ? 'selected' : '' }}>20-30€</option>
                <option value="30-50" {{ request('precio') == '30-50' ? 'selected' : '' }}>30-50€</option>
                <option value="50+" {{ request('precio') == '50+' ? 'selected' : '' }}>50€+</option>
            </select>
            
            <button type="button" class="btn btn-reset" id="resetFilters">Limpiar Filtros</button>
        </div>

        <!-- Table Container -->
        <div id="restaurantesContainer">
            @include('admin.partials.restaurantes-table', ['restaurantes' => $restaurantes])
        </div>
    </div>

    <!-- Modales -->
    <div id="modalOverlay" class="modal-overlay modal-hidden">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Modal</h2>
                <button type="button" class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Contenido del modal se carga aquí -->
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentFilters = {
            buscar: '{{ request('buscar', '') }}',
            tipo_comida: '{{ request('tipo_comida', '') }}',
            valoracion: '{{ request('valoracion', '') }}',
            precio: '{{ request('precio', '') }}',
            page: {{ $restaurantes->currentPage() }}
        };

        let searchTimeout = null;

        // Inicialización
        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        // Event listeners
        function setupEventListeners() {
            // Filtros
            document.getElementById('filterBuscar').addEventListener('input', handleSearchInput);
            document.getElementById('filterTipoComida').addEventListener('change', handleFilterChange);
            document.getElementById('filterValoracion').addEventListener('change', handleFilterChange);
            document.getElementById('filterPrecio').addEventListener('change', handleFilterChange);
            document.getElementById('resetFilters').addEventListener('click', resetFilters);

            // Paginación (delegación de eventos)
            document.addEventListener('click', function(e) {
                if (e.target.matches('.page-link') && !e.target.classList.contains('active')) {
                    e.preventDefault();
                    const url = new URL(e.target.href || window.location);
                    const page = url.searchParams.get('page') || 1;
                    loadRestaurantesPage(page);
                }
            });
        }

        // Manejo de búsqueda con debounce
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

        // Manejo de filtros
        function handleFilterChange(e) {
            const filterName = e.target.name;
            const filterValue = e.target.value;
            
            currentFilters[filterName] = filterValue;
            currentFilters.page = 1; // Resetear a página 1
            
            loadRestaurantes();
        }

        // Resetear filtros
        function resetFilters() {
            currentFilters = {
                buscar: '',
                tipo_comida: '',
                valoracion: '',
                precio: '',
                page: 1
            };
            
            // Actualizar campos
            document.getElementById('filterBuscar').value = '';
            document.getElementById('filterTipoComida').value = '';
            document.getElementById('filterValoracion').value = '';
            document.getElementById('filterPrecio').value = '';
            
            loadRestaurantes();
        }

        // Cargar restaurantes con filtros
        function loadRestaurantes() {
            const params = new URLSearchParams();
            
            Object.keys(currentFilters).forEach(key => {
                if (currentFilters[key]) {
                    params.append(key, currentFilters[key]);
                }
            });

            // Mostrar loading
            document.getElementById('restaurantesContainer').innerHTML = '<div class="text-center p-40"><div class="loading-spinner"></div><p>Cargando restaurantes...</p></div>';

            fetch(`{{ route('admin.index') }}?${params.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('restaurantesContainer').innerHTML = html;
                setupEventListeners(); // Re-establecer listeners
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al cargar los restaurantes', 'error');
            });
        }

        // Cargar página específica
        function loadRestaurantesPage(page) {
            currentFilters.page = page;
            loadRestaurantes();
        }

        // Función para eliminar restaurante con AJAX
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

        // Logout con AJAX
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
                    fetch('{{ route('logout') }}', {
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

        // Modales
        function openCreateModal() {
            document.getElementById('modalTitle').textContent = 'Crear Nuevo Restaurante';
            
            fetch('{{ route('admin.create') }}', {
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
                
                document.getElementById('modalBody').innerHTML = form.outerHTML;
                document.getElementById('modalOverlay').classList.remove('modal-hidden');
                setupCreateFormHandler();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al cargar el formulario', 'error');
            });
        }

        function openEditModal(id) {
            document.getElementById('modalTitle').textContent = 'Editar Restaurante';
            
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
                
                document.getElementById('modalBody').innerHTML = form.outerHTML;
                document.getElementById('modalOverlay').classList.remove('modal-hidden');
                setupEditFormHandler();
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error al cargar el formulario', 'error');
            });
        }

        function closeModal() {
            document.getElementById('modalOverlay').classList.add('modal-hidden');
            document.getElementById('modalBody').innerHTML = '';
        }

        // Setup form handlers para modales
        function setupCreateFormHandler() {
            const form = document.getElementById('createRestauranteForm');
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitFormAjax(form, 'Creando...', 'Crear Restaurante');
            });
        }

        function setupEditFormHandler() {
            const form = document.getElementById('editRestauranteForm');
            if (!form) return;
            
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                submitFormAjax(form, 'Actualizando...', 'Actualizar Restaurante');
            });
        }

        // Submit formulario via AJAX
        function submitFormAjax(form, loadingText, originalText) {
            const submitBtn = form.querySelector('button[type="submit"]');
            const formData = new FormData(form);
            
            // Limpiar errores previos
            form.querySelectorAll('.error').forEach(el => el.remove());
            
            // Mostrar loading
            submitBtn.textContent = loadingText;
            submitBtn.disabled = true;
            
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
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
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
    </script>

    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
        }

        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #e74c3c;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</body>
</html>
