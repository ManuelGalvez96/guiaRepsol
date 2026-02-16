// JavaScript para editar restaurantes
// Validacion, preview de imagen, guardar cambios...

let csrfToken;

// Al cargar la pagina
window.onload = function () {
    console.log('Iniciando formulario de editar...');
    // Pequeño delay para asegurar que el DOM esté listo
    setTimeout(function() {
        initializeEditForm();
    }, 100);
};

// Configurar formulario de edicion
function initializeEditForm() {
    // Obtener token desde PHP
    if (typeof window.editConfig !== 'undefined') {
        csrfToken = window.editConfig.csrfToken;
    } else {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        } else {
            console.error('No se pudo obtener el token CSRF');
            return;
        }
    }

    const form = document.getElementById('editRestauranteForm');
    if (!form) {
        console.log('No encuentro el form de editar');
        return;
    }

    console.log('Configurando form de editar...');
    setupEditFormHandler();
    saveOriginalValues();
}

// Configurar el submit
function setupEditFormHandler() {
    const form = document.getElementById('editRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');

    if (!form) return;

    // Cuando se envie el formulario
    form.onsubmit = function (e) {
        e.preventDefault();
        console.log('Actualizando restaurante...');

        // Quitar errores anteriores
        document.querySelectorAll('.error').forEach(el => el.remove());
        if (alertContainer) {
            alertContainer.innerHTML = '';
        }

        // Cambiar boton mientras procesa
        if (submitBtn) {
            submitBtn.textContent = 'Actualizando...';
            submitBtn.disabled = true;
        }
        form.classList.add('loading');

        // Preparar datos
        const formData = new FormData(form);

        // Enviar con AJAX
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
            .then(response => {
                console.log('Respuesta recibida:', response.status);
                if (!response.ok) {
                    return response.json().then(data => {
                        throw data;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Restaurante actualizado correctamente!');

                    // Mensaje de exito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Volver al panel después de 1.5seg
                    setTimeout(() => {
                        const adminIndexUrl = window.editConfig?.adminIndexRoute || '/admin';
                        window.location.href = adminIndexUrl;
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error al actualizar:', error);

                // Si hay errores de validacion
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

                // Restaurar boton
                if (submitBtn) {
                    submitBtn.textContent = 'Actualizar Restaurante';
                    submitBtn.disabled = false;
                }
                form.classList.remove('loading');
            });
    };
}

// Preview de imagen nueva
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        // Validar archivo antes de preview
        if (!validateImageFile(file)) {
            event.target.value = ''; // Limpiar input
            return;
        }
        
        console.log('Nueva imagen:', file.name);
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('preview');
            const imagePreview = document.getElementById('imagePreview');

            if (preview && imagePreview) {
                preview.src = e.target.result;
                imagePreview.classList.add('active');
                imagePreview.style.display = 'block';

                // Bajar opacidad de la imagen actual
                const currentImage = document.querySelector('.current-image');
                if (currentImage) {
                    currentImage.style.opacity = '0.5';
                }
            }
        }
        reader.readAsDataURL(file);
    }
}

// Hacer disponible globalmente
window.previewImage = previewImage;

// Cancelar y volver
function cancelEdit() {
    // Si hay cambios, preguntar antes
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

window.cancelEdit = cancelEdit;

// Verificar si el usuario cambió algo
function hasUnsavedChanges() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return false;

    const inputs = form.querySelectorAll('input, select, textarea');

    for (let input of inputs) {
        if (input.type === 'file') continue; // ignorar archivos
        if (input.type === 'hidden') continue; // ignorar ocultos (_token, _method)

        const originalValue = input.getAttribute('data-original-value') || input.defaultValue;
        const currentValue = input.value;

        if (originalValue !== currentValue) {
            console.log('Cambio detectado en:', input.name);
            return true;
        }
    }

    return false;
}

// Validar form antes de enviar (opcional porque el servidor valida)
function validateEditForm() {
    const form = document.getElementById('editRestauranteForm');
    if (!form) return false;

    let isValid = true;
    const requiredFields = ['nombre', 'categoria_id', 'ubicacion_id', 'user_id', 'direccion', 'email', 'precio'];

    // Verificar campos obligatorios
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
            showFieldError(emailField, 'Ingresa un correo electrónico válido');
            isValid = false;
        }
    }

    // Validar imagen si se seleccionó
    const imageField = document.getElementById('imagen');
    if (imageField && imageField.files.length > 0) {
        if (!validateImageFile(imageField.files[0])) {
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

    // Validar valoracion
    const valoracionField = document.getElementById('valoracion_promedio');
    if (valoracionField && valoracionField.value.trim()) {
        const valoracion = parseFloat(valoracionField.value);
        if (isNaN(valoracion) || valoracion < 0 || valoracion > 5) {
            showFieldError(valoracionField, 'La valoración debe estar entre 0 y 5');
            isValid = false;
        }
    }

    // Validar soles (0-3)
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

// Mostrar error en campo
function showFieldError(field, message) {
    // Quitar error anterior si existe
    const existingError = field.parentNode.querySelector('.error');
    if (existingError) {
        existingError.remove();
    }

    // Crear nuevo div de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);

    // Focus al campo con error
    field.focus();
}

// Guardar valores originales del form para detectar cambios
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

// TODO: mejorar la deteccion de cambios en checkboxes

// Validar archivo de imagen
function validateImageFile(file) {
    const imageField = document.getElementById('imagen');
    
    // Verificar tipo de archivo
    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!allowedTypes.includes(file.type)) {
        showFieldError(imageField, 'Solo se permiten imágenes (JPEG, PNG, GIF, WebP)');
        return false;
    }
    
    // Verificar tamaño (2MB máximo)
    const maxSize = 2 * 1024 * 1024; // 2MB en bytes
    if (file.size > maxSize) {
        showFieldError(imageField, 'La imagen no puede superar los 2MB de tamaño');
        return false;
    }
    
    // Limpiar errores anteriores si todo está bien
    const existingError = imageField.parentNode.querySelector('.error');
    if (existingError) {
        existingError.remove();
    }
    
    return true;
}

// TODO: mejorar la deteccion de cambios en checkboxes

// Guardar valores al cargar
// Nota: Esta función se llama desde initializeEditForm() que ya está en window.onload
