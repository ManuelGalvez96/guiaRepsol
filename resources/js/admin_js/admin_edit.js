/**
 * Admin Edit JavaScript - Funcionalidad para editar restaurantes
 * Incluye: Validación, preview de imágenes, envío AJAX, manejo de imagen existente
 */

// Variables globales
let csrfToken;

// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeEditForm();
});

/**
 * Inicializar formulario de edición
 */
function initializeEditForm() {
    // Obtener configuración pasada desde PHP
    if (typeof window.editConfig !== 'undefined') {
        csrfToken = window.editConfig.csrfToken;
    } else {
        // Fallback
        csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    }
    
    const form = document.getElementById('editRestauranteForm');
    if (!form) return;
    
    setupEditFormHandler();
}

/**
 * Configurar event listeners del formulario
 */
function setupEditFormHandler() {
    const form = document.getElementById('editRestauranteForm');
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
            submitBtn.textContent = 'Actualizando...';
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
                // Mostrar mensaje de éxito con SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
                
                // Redirigir después de 1.5 segundos
                setTimeout(() => {
                    const adminIndexUrl = window.editConfig?.adminIndexRoute || '/admin';
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
                    text: error.message || 'Error al actualizar el restaurante'
                });
            }
            
            // Restaurar botón
            if (submitBtn) {
                submitBtn.textContent = 'Actualizar Restaurante';
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
                imagePreview.style.display = 'block';
                
                // Ocultar imagen actual si existe
                const currentImage = document.querySelector('.current-image');
                if (currentImage) {
                    currentImage.style.opacity = '0.5';
                }
            }
        }
        reader.readAsDataURL(file);
    }
}

// Hacer función disponible globalmente
window.previewImage = previewImage;

/**
 * Cancelar y volver al índice
 */
function cancelEdit() {
    // Preguntar confirmación si hay cambios sin guardar
    if (hasUnsavedChanges()) {
        Swal.fire({
            title: '¿Descartar cambios?',
            text: 'Tienes cambios sin guardar. ¿Estás seguro de que quieres salir?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#95a5a6',
            confirmButtonText: 'Sí, descartar',
            cancelButtonText: 'Continuar editando'
        }).then((result) => {
            if (result.isConfirmed) {
                const adminIndexUrl = window.editConfig?.adminIndexRoute || '/admin';
                window.location.href = adminIndexUrl;
            }
        });
    } else {
        const adminIndexUrl = window.editConfig?.adminIndexRoute || '/admin';
        window.location.href = adminIndexUrl;
    }
}

// Hacer función disponible globalmente
window.cancelEdit = cancelEdit;
/**
 * Verificar si hay cambios sin guardar
 */
function hasUnsavedChanges() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return false;
    
    const formData = new FormData(form);
    const inputs = form.querySelectorAll('input, select, textarea');
    
    for (let input of inputs) {
        if (input.type === 'file') continue; // Skip file inputs
        if (input.type === 'hidden') continue; // Skip hidden inputs like _token and _method
        
        const originalValue = input.getAttribute('data-original-value') || input.defaultValue;
        const currentValue = input.value;
        
        if (originalValue !== currentValue) {
            return true;
        }
    }
    
    return false;
}

/**
 * Validar formulario antes de envío
 */
function validateEditForm() {
    const form = document.getElementById('editRestauranteForm');
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
    
    // Validar valoración
    const valoracionField = document.getElementById('valoracion_promedio');
    if (valoracionField && valoracionField.value.trim()) {
        const valoracion = parseFloat(valoracionField.value);
        if (isNaN(valoracion) || valoracion < 0 || valoracion > 5) {
            showFieldError(valoracionField, 'La valoración debe estar entre 0 y 5');
            isValid = false;
        }
    }
    
    // Validar soles
    const solesField = document.getElementById('soles');
    if (solesField && solesField.value.trim()) {
        const soles = parseInt(solesField.value);
        if (isNaN(soles) || soles < 0 || soles > 3) {
            showFieldError(solesField, 'Los soles deben estar entre 0 y 3');
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

/**
 * Guardar valores originales para detectar cambios
 */
function saveOriginalValues() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return;
    
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        if (input.type !== 'file' && input.type !== 'hidden') {
            input.setAttribute('data-original-value', input.value);
        }
    });
}

// Guardar valores originales al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(saveOriginalValues, 100); // Pequeño delay para asegurar que los valores estén cargados
});