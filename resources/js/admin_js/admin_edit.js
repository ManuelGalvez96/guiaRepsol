// JavaScript para editar restaurantes 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;
let selectedFiles = []; // Array para mantener archivos seleccionados

// Usar el array global si existe, sino crear uno nuevo
if (typeof window.imagenesAEliminar === 'undefined') {
    window.imagenesAEliminar = [];
}

// Ejecutar cuando la página esté lista (solo una vez)
let formInitialized = false;
window.onload = function () {
    console.log('Página cargada - Iniciando configuración...');
    if (!formInitialized) {
        formInitialized = true;
        initEditForm();
    }
};

// Función de inicialización
function initEditForm() {
    console.log('Iniciando formulario de editar...');

    // Resetear array de imágenes a eliminar
    window.imagenesAEliminar = [];

    // Obtener token CSRF del atributo data-csrf del body
    csrfToken = document.body.getAttribute('data-csrf');
    if (!csrfToken) {
        var metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }

    const form = document.getElementById('editRestauranteForm');
    if (form) {
        form.onsubmit = function (e) {
            e.preventDefault();
            console.log('Actualizando restaurante...');
            actualizarRestaurante();
        }
    }

    // Usar delegación de eventos para botones de eliminar imágenes existentes
    setupImageDelegation();

    console.log('Form de editar cargado completamente');
}

// Hacer funciones disponibles globalmente
window.initEditForm = initEditForm;
window.setupExistingImageDeleteButtons = setupImageDelegation;
window.removeExistingImage = removeExistingImage;
window.previewImages = previewImages;

// Delegación de eventos: asignar onclick al contenedor para manejar todos los clicks
function setupImageDelegation() {
    var container = document.getElementById('allImagesContainer');
    if (!container) {
        console.error('No se encontró el contenedor de imágenes');
        return;
    }
    
    // Evitar duplicar usando un flag en el propio elemento
    if (container._delegationSetup) return;
    container._delegationSetup = true;
    
    console.log('=== Delegación de eventos configurada en #allImagesContainer ===');

    container.onclick = function (e) {
        // Buscar si se hizo click en un botón de eliminar imagen existente (o dentro de él)
        var btn = e.target.closest('.btn-eliminar-imagen-existente');
        if (btn) {
            e.preventDefault();
            e.stopPropagation();
            var id = btn.getAttribute('data-imagen-id');
            console.log('>>> CLICK delegado en botón X, eliminando imagen ID:', id);
            removeExistingImage(id);
        }
    };
}

// Función para eliminar imagen existente
function removeExistingImage(imagenId) {
    const id = String(imagenId);
    const isAlreadyMarked = window.imagenesAEliminar.some(existingId => String(existingId) === id);

    if (!isAlreadyMarked) {
        window.imagenesAEliminar.push(id);

        const hiddenInput = document.getElementById('imagenes_eliminar');
        if (hiddenInput) {
            hiddenInput.value = window.imagenesAEliminar.join(',');
        }

        const imageItem = document.querySelector('.current-image-item[data-imagen-id="' + id + '"]');
        if (imageItem) {
            imageItem.className = 'current-image-item image-marked-delete';

            const deleteIndicator = document.createElement('div');
            deleteIndicator.className = 'delete-indicator';
            deleteIndicator.textContent = 'ELIMINADA';
            imageItem.appendChild(deleteIndicator);

            const removeBtn = imageItem.querySelector('.btn-eliminar-imagen-existente');
            if (removeBtn) {
                removeBtn.style.display = 'none';
            }
        }
    }
}

// Función AJAX 
function peticionAjax(url, metodo, funcionCallback, datos) {
    ajaxObj = new XMLHttpRequest();
    ajaxObj.open(metodo, url);

    if (metodo === 'POST') {
        ajaxObj.setRequestHeader('Accept', 'application/json');
        ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    }

    ajaxObj.onreadystatechange = funcionCallback;

    if (metodo === 'POST' && datos) {
        ajaxObj.send(datos);
    } else {
        ajaxObj.send();
    }
}

function actualizarRestaurante() {
    const form = document.getElementById('editRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');

    // Limpiar errores anteriores
    document.querySelectorAll('.error').forEach(el => el.remove());

    // Cambiar botón
    if (submitBtn) {
        submitBtn.textContent = 'Actualizando...';
        submitBtn.disabled = true;
    }

    // Preparar datos
    const formData = new FormData(form);

    // AJAX con patrón 
    peticionAjax(form.action, 'POST', manejarActualizar, formData);
}

function manejarActualizar() {
    if (ajaxObj.readyState == READY_STATE_COMPLETE) {
        const submitBtn = document.getElementById('submitBtn');

        if (ajaxObj.status == 200) {
            const data = JSON.parse(ajaxObj.responseText);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    const adminIndexUrl = document.body.getAttribute('data-route-index') || '/admin';
                    window.location.href = adminIndexUrl;
                });
            }
        } else if (ajaxObj.status == 422) {
            // Errores de validación
            const error = JSON.parse(ajaxObj.responseText);
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
                submitBtn.textContent = 'Actualizar Restaurante';
                submitBtn.disabled = false;
            }
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al actualizar el restaurante'
            });

            // Restaurar botón
            if (submitBtn) {
                submitBtn.textContent = 'Actualizar Restaurante';
                submitBtn.disabled = false;
            }
        }
    }
}

// Preview de múltiples imágenes con opción de eliminar
function previewImages(event) {
    const files = event.target.files;
    const container = document.getElementById('allImagesContainer');

    if (!container) return;

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

        console.log(`${selectedFiles.length} nuevas imágenes agregadas al contenedor`);
    }
}

// Función para renderizar los previews de las imágenes
function renderImagePreviews() {
    const container = document.getElementById('allImagesContainer');
    if (!container) return;

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'new-image-item';

            // Botón X para eliminar imagen NUEVA/SELECCIONADA (no guardada aún)
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'btn-eliminar-imagen-nueva';
            removeBtn.title = 'Quitar imagen seleccionada';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                removeSelectedImage(index);
            };

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = `Vista previa ${index + 1}`;

            const fileName = document.createElement('small');
            fileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;

            const badge = document.createElement('span');
            badge.textContent = 'NUEVA';
            badge.className = 'new-image-badge';

            previewDiv.appendChild(removeBtn);
            previewDiv.appendChild(img);
            previewDiv.appendChild(fileName);
            previewDiv.appendChild(badge);
            container.appendChild(previewDiv);
        }
        reader.readAsDataURL(file);
    });

    console.log(`${selectedFiles.length} imágenes seleccionadas renderizadas`);
}

// Función para eliminar una imagen SELECCIONADA/NUEVA (no guardada aún)
function removeSelectedImage(index) {
    console.log('Eliminando imagen seleccionada en índice:', index);

    if (index >= 0 && index < selectedFiles.length) {
        selectedFiles.splice(index, 1);
        console.log('Imágenes restantes:', selectedFiles.length);

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
            console.log('No quedan imágenes seleccionadas');
        }
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

// Función para cancelar edición y volver al index
function cancelEdit() {
    const adminIndexUrl = document.body.getAttribute('data-route-index') || '/admin';
    window.location.href = adminIndexUrl;
}

// Hacer disponibles globalmente
window.previewImages = previewImages;
window.validateImageFile = validateImageFile;
window.renderImagePreviews = renderImagePreviews;
window.updateFileInput = updateFileInput;
window.removeExistingImage = removeExistingImage;
window.setupExistingImageDeleteButtons = setupImageDelegation;
window.cancelEdit = cancelEdit;