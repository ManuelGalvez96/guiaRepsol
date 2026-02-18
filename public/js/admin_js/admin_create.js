// JavaScript para crear restaurantes 
var csrfToken;
var selectedFiles = []; // Array para mantener archivos seleccionados

console.log('admin_create.js cargado. document.readyState:', document.readyState);

// Intentar ejecutar cuando esté listo el documento
function initializeCreateForm() {
    console.log('=== initializeCreateForm() ===');
    
    // Obtener token CSRF del atributo data-csrf del body
    csrfToken = document.body.getAttribute('data-csrf');
    if (!csrfToken) {
        var metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }
    console.log('✓ CSRF Token obtenido:', !!csrfToken);

    const form = document.getElementById('createRestauranteForm');
    console.log('✓ Formulario encontrado:', !!form);
    
    if (form) {
        form.onsubmit = function (e) {
            e.preventDefault();
            crearRestaurante();
        }
    }
}

// Usar DOMContentLoaded si aún está disponible
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        console.log('admin_create.js - DOMContentLoaded');
        setTimeout(function() {
            initializeCreateForm();
        }, 100);
    });
} else {
    // Sheet ya cargado, llamar directamente
    console.log('admin_create.js - Documento ya cargado, inicializando directamente');
    setTimeout(function() {
        initializeCreateForm();
    }, 50);
}

// Fallback con window.onload para compatibilidad
const prevOnloadCreate = window.onload;
window.onload = function(event) {
    if (typeof prevOnloadCreate === 'function') {
        prevOnloadCreate(event);
    }
    console.log('admin_create.js - window.onload fallback');
    initializeCreateForm();
};



function crearRestaurante() {
    console.log('=== crearRestaurante() ===');
    
    const form = document.getElementById('createRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');

    // Limpiar errores anteriores
    document.querySelectorAll('.error').forEach(el => el.remove());

    // Cambiar botón
    if (submitBtn) {
        submitBtn.textContent = 'Creando...';
        submitBtn.disabled = true;
    }

    // Preparar datos
    const formData = new FormData(form);

    // Fetch
    fetch(form.action, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: formData
    })
    .then(response => {
        const submitBtn = document.getElementById('submitBtn');
        
        if (response.status === 200) {
            return response.json().then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        const adminIndexUrl = document.body.getAttribute('data-route-index') || '/admin';
                        window.location.href = adminIndexUrl;
                    });
                }
            });
        } else if (response.status === 422) {
            // Errores de validación
            return response.json().then(error => {
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
                        text: 'Por favor corrige los errores en el formulario'
                    });
                }

                // Restaurar botón
                if (submitBtn) {
                    submitBtn.textContent = 'Crear Restaurante';
                    submitBtn.disabled = false;
                }
            });
        } else {
            throw new Error('Error desconocido');
        }
    })
    .catch(error => {
        const submitBtn = document.getElementById('submitBtn');
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al crear el restaurante'
        });

        // Restaurar botón
        if (submitBtn) {
            submitBtn.textContent = 'Crear Restaurante';
            submitBtn.disabled = false;
        }
    });
}

// Preview de múltiples imágenes con opción de eliminar
function previewImages(event) {
    const files = event.target.files;
    const container = document.getElementById('allImagesContainer');

    if (!container) {
        console.error('No se encontró el contenedor allImagesContainer');
        return;
    }

    // Eliminar previews anteriores de nuevas imágenes (solo las que tienen la clase new-image-item)
    const previousNewImages = container.querySelectorAll('.new-image-item');
    previousNewImages.forEach(img => img.remove());

    // Resetear array de archivos seleccionados
    selectedFiles = [];

    if (files && files.length > 0) {
        // Validar cada archivo y añadir a selectedFiles
        for (let i = 0; i < files.length; i++) {
            if (validateImageFile(files[i])) {
                selectedFiles.push(files[i]);
            }
        }

        if (selectedFiles.length === 0) {
            return;
        }

        // Eliminar mensaje "no hay imágenes" si existe
        const noImagesMsg = document.getElementById('noImagesMessage');
        if (noImagesMsg) {
            noImagesMsg.remove();
        }

        // Renderizar previews en el mismo contenedor
        renderImagePreviews();

    } else {
        // Si no hay archivos, mostrar mensaje
        if (!document.getElementById('noImagesMessage')) {
            const emptyMsg = document.createElement('p');
            emptyMsg.id = 'noImagesMessage';
            emptyMsg.style.cssText = 'width: 100%; text-align: center; color: #999; margin: 20px 0;';
            emptyMsg.textContent = 'Selecciona imágenes para añadir.';
            container.appendChild(emptyMsg);
        }
    }
}

// Función para renderizar los previews de las imágenes
function renderImagePreviews() {
    const container = document.getElementById('allImagesContainer');
    if (!container) {
        console.error('No se encontró el contenedor allImagesContainer en renderImagePreviews');
        return;
    }

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'new-image-item';
            previewDiv.style.cssText = 'position: relative; text-align: center; border: 3px solid #ffc107; border-radius: 8px; padding: 5px; background: #fffbf0; max-width: 170px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3); display: flex; flex-direction: column; align-items: center;';

            // Botón X para eliminar imagen NUEVA/SELECCIONADA (no guardada aún)
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'btn-eliminar-imagen-nueva';
            removeBtn.title = 'Quitar imagen seleccionada';
            removeBtn.type = 'button';
            removeBtn.style.cssText = 'position: absolute; top: 3px; right: 3px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; z-index: 1000; box-shadow: 0 2px 6px rgba(0,0,0,0.3); transition: all 0.2s ease;';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                removeImage(index);
            };

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = `Vista previa ${index + 1}`;
            img.style.cssText = 'width: 150px; height: 100px; object-fit: cover; border-radius: 5px; display: block;';

            const fileName = document.createElement('small');
            fileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
            fileName.style.cssText = 'display: block; margin-top: 5px; color: #856404; text-align: center; font-size: 11px; font-weight: 600;';

            const badge = document.createElement('span');
            badge.textContent = 'NUEVA';
            badge.className = 'new-image-badge';
            badge.style.cssText = 'display: inline-block; background: #ffc107; color: #000; padding: 2px 8px; border-radius: 12px; font-size: 10px; font-weight: 700; margin-top: 5px; text-transform: uppercase;';

            previewDiv.appendChild(removeBtn);
            previewDiv.appendChild(img);
            previewDiv.appendChild(fileName);
            previewDiv.appendChild(badge);

            container.appendChild(previewDiv);
        }
        reader.readAsDataURL(file);
    });
}

// Función para eliminar una imagen específica
function removeImage(index) {
    if (index >= 0 && index < selectedFiles.length) {
        const fileName = selectedFiles[index].name;
        selectedFiles.splice(index, 1);

        // Actualizar el input file con los archivos restantes
        updateFileInput();

        // Limpiar imágenes nuevas del contenedor
        const container = document.getElementById('allImagesContainer');
        if (container) {
            const newImages = container.querySelectorAll('.new-image-item');
            newImages.forEach(img => img.remove());
        }

        // Si quedan archivos, renderizar de nuevo
        if (selectedFiles.length > 0) {
            renderImagePreviews();
        } else {
            // Si no quedan archivos, mostrar mensaje
            const noImagesMsg = document.createElement('p');
            noImagesMsg.id = 'noImagesMessage';
            noImagesMsg.style.cssText = 'width: 100%; text-align: center; color: #999; margin: 20px 0;';
            noImagesMsg.textContent = 'Selecciona imágenes para añadir.';
            if (container && !container.querySelector('#noImagesMessage')) {
                container.appendChild(noImagesMsg);
            }
        }
    } else {
        console.error('Índice de imagen no válido:', index);
        alert('Error al eliminar la imagen');
    }
}

// Función para actualizar el input file con los archivos restantes
function updateFileInput() {
    const fileInput = document.getElementById('imagenes');
    if (!fileInput) return;

    // Crear un nuevo DataTransfer object para reconstruir la lista de archivos
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

    fileInput.files = dataTransfer.files;
}

// Función para validar cada imagen
function validateImageFile(file) {
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (!validTypes.includes(file.type)) {
        alert(`Archivo ${file.name}: Formato no válido. Use JPG, PNG, GIF o WebP`);
        return false;
    }

    if (file.size > maxSize) {
        alert(`Archivo ${file.name}: Muy grande. Máximo 5MB`);
        return false;
    }

    return true;
}

// Hacer disponibles globalmente
window.previewImages = previewImages;
window.validateImageFile = validateImageFile;
window.removeImage = removeImage;
window.renderImagePreviews = renderImagePreviews;
window.updateFileInput = updateFileInput;