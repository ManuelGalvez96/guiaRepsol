// JavaScript para crear restaurantes
// Manejo del formulario, preview de imagen, validación, etc.

let csrfToken;

// Al cargar la página
document.addEventListener('DOMContentLoaded', function () {
    console.log('Inicializando formulario de crear...');
    initializeCreateForm();
});

// Configurar el formulario
function initializeCreateForm() {
    // Obtener token CSRF desde PHP
    if (typeof window.createConfig !== 'undefined') {
        csrfToken = window.createConfig.csrfToken;
    } else {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        } else {
            console.error('No se pudo obtener el token CSRF');
            return;
        }
    }

    const form = document.getElementById('createRestauranteForm');
    if (!form) {
        console.log('No se encontró el formulario');
        return;
    }

    console.log('Configurando form de crear...');
    setupCreateFormHandler();
}

// Configurar el submit del formulario
function setupCreateFormHandler() {
    const form = document.getElementById('createRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');
    const alertContainer = document.getElementById('alertContainer');

    if (!form) return;

    // Cuando se envíe el form
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log('Enviando formulario...');

        // Limpiar errores anteriores
        document.querySelectorAll('.error').forEach(el => el.remove());
        if (alertContainer) {
            alertContainer.innerHTML = '';
        }

        // Cambiar botón a "Creando..."
        if (submitBtn) {
            submitBtn.textContent = 'Creando...';
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
                    console.log('Restaurante creado!');

                    // Mostrar mensaje bonito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Limpiar form
                    form.reset();

                    // Quitar preview de imagen si hay
                    const imagePreview = document.getElementById('imagePreview');
                    if (imagePreview) {
                        imagePreview.classList.remove('active');
                    }

                    // Volver al índice después de 1.5 seg
                    setTimeout(() => {
                        const adminIndexUrl = window.createConfig?.adminIndexRoute || '/admin';
                        window.location.href = adminIndexUrl;
                    }, 1500);
                }
            })
            .catch(error => {
                console.error('Error creando restaurante:', error);

                // Si hay errores de validación del servidor
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

                // Restaurar el botón
                if (submitBtn) {
                    submitBtn.textContent = 'Crear Restaurante';
                    submitBtn.disabled = false;
                }
                form.classList.remove('loading');
            });
    });
}

// Preview de la imagen antes de subir
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        console.log('Archivo seleccionado:', file.name);
        const reader = new FileReader();
        reader.onload = function (e) {
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

// Hacer disponible para el HTML
window.previewImage = previewImage;

// TODO: agregar validación de tamaño de archivo antes de subir

// Validación del form (opcional, el servidor también valida)
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

// Mostrar error en un campo
function showFieldError(field, message) {
    // Quitar error anterior si existe
    const existingError = field.parentNode.querySelector('.error');
    if (existingError) {
        existingError.remove();
    }

    // Crear div de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error';
    errorDiv.textContent = message;
    field.parentNode.appendChild(errorDiv);

    // Hacer focus en el campo
    field.focus();
}
