/**
 * Admin Create JavaScript - Funcionalidad para crear restaurantes
 * Incluye: Validación, preview de imágenes, envío AJAX
 */

// Variables globales
let csrfToken;

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeCreateForm();
});

/**
 * Inicializar formulario de creación
 */
function initializeCreateForm() {
    // Obtener configuración pasada desde PHP
    if (typeof window.createConfig !== 'undefined') {
        csrfToken = window.createConfig.csrfToken;
    } else {
        // Fallback
        csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
    
    const form = document.getElementById('createRestauranteForm');
    if (!form) return;
    
    setupCreateFormHandler();
}

/**
 * Configurar event listeners del formulario
 */
function setupCreateFormHandler() {
    const form = document.getElementById('createRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');
    
    if (!form) return;

    // Event listener para envío del formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpiar errores previos
        document.querySelectorAll('.error').forEach(el => el.remove());
        if (alertContainer) {
            alertContainer.innerHTML = '';
        }
        
        // Mostrar estado de carga
        if (submitBtn) {
            submitBtn.textContent = 'Creando...';
            submitBtn.disabled = true;
        }
        form.classList.add('loading');
        
        // Preparar datos del formulario
        const formData = new FormData(form);
        
        // Enviar petición AJAX
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
                // Mostrar mensaje con SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                // Limpiar formulario
                form.reset();
                
                // Limpiar preview de imagen
                const imagePreview = document.getElementById('imagePreview');
                if (imagePreview) {
                    imagePreview.classList.remove('active');
                }
                
                // Redirigir después de 1.5 segundos
                setTimeout(() => {
                    const adminIndexUrl = window.createConfig?.adminIndexRoute || '/admin';
                    window.location.href = adminIndexUrl;
                }, 1500);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Mostrar errores de validación
            if (error.errors) {
                Object.keys(error.errors).forEach(field => {
                    const input = document.getElementById(field);
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
                    text: 'Por favor corrige los errores en el formulario',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error al crear el restaurante'
                });
            }
            
            // Restaurar botón
            if (submitBtn) {
                submitBtn.textContent = 'Crear Restaurante';
                submitBtn.disabled = false;
            }
            form.classList.remove('loading');
        });
    });
}

/**
 * Previsualizar imagen seleccionada
 */
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');
            
            if (preview && imagePreview) {
                preview.src = e.target.result;
                imagePreview.classList.add('active');
            }
        }
        reader.readAsDataURL(file);
    }
}

// Hacer función disponible globalmente
window.previewImage = previewImage;

/**
 * Validar formulario antes de envío
 */
function validateCreateForm() {
    const form = document.getElementById('createRestauranteForm');
    if (!form) return false;
    
    let isValid = true;
    const requiredFields = ['nombre', 'categoria_id', 'ubicacion_id', 'user_id', 'direccion', 'email', 'precio'];
    
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field && !field.value.trim()) {
            showFieldError(field, 'Este campo es obligatorio');
            isValid = false;
        }
    });
    
    // Validar email
    const emailField = document.getElementById('email');
    if (emailField && emailField.value.trim()) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(emailField.value.trim())) {
            showFieldError(emailField, 'Ingresa un email válido');
            isValid = false;
        }
    }
    
    // Validar precio
    const precioField = document.getElementById('precio');
    if (precioField && precioField.value.trim()) {
        const precio = parseFloat(precioField.value);
        if (isNaN(precio) || precio < 0) {
            showFieldError(precioField, 'Ingresa un precio válido');
            isValid = false;
        }
    }
    
    return isValid;
}

/**
 * Mostrar error en campo específico
 */
function showFieldError(field, message) {
    // Remover error anterior
    const existingError = field.parentNode.querySelector('.error');
    if (existingError) {
        existingError.remove();
    }
    
    // Agregar nuevo error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);
    
    // Focus en el campo con error
    field.focus();
}