// JavaScript para editar restaurantes 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;
let selectedFiles = []; // Array para mantener archivos seleccionados

// Usar el array global si existe, sino crear uno nuevo
if (typeof window.imagenesAEliminar === 'undefined') {
    window.imagenesAEliminar = [];
}

// Ejecutar cuando el DOM esté listo (solo una vez)
let formInitialized = false;
document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM Content Loaded - Iniciando configuración...');
    if (!formInitialized) {
        formInitialized = true;
        initEditForm();
    }
});

// Función de inicialización
function initEditForm() {
    console.log('Iniciando formulario de editar...');

    // Resetear array de imágenes a eliminar
    window.imagenesAEliminar = [];

    // Obtener token CSRF
    if (typeof window.editConfig !== 'undefined') {
        csrfToken = window.editConfig.csrfToken;
    } else {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
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
    // setupImageDelegation();

    console.log('Form de editar cargado completamente');
}

// Hacer funciones disponibles globalmente
window.initEditForm = initEditForm;
window.setupExistingImageDeleteButtons = setupImageDelegation;
window.removeExistingImage = removeExistingImage;
window.previewImages = previewImages;

// Delegación de eventos: un solo listener en el contenedor maneja todos los clicks
function setupImageDelegation() {
    const container = document.getElementById('allImagesContainer');
    if (!container) {
        console.error('No se encontró el contenedor de imágenes');
        return;
    }
    
    // Evitar duplicar el listener usando un flag en el propio elemento
    if (container._delegationSetup) return;
    container._delegationSetup = true;
    
    console.log('=== Delegación de eventos configurada en #allImagesContainer ===');

    container.addEventListener('click', function (e) {
        // Buscar si se hizo click en un botón de eliminar imagen existente
        if (e.target.classList.contains('btn-eliminar-imagen-existente')) {
            e.preventDefault();
            e.stopPropagation();
            const id = e.target.getAttribute('data-imagen-id');
            console.log('>>> CLICK en botón X, eliminando imagen ID:', id);
            removeExistingImage(id);
        }
    });
}

// Función para eliminar imagen existente
function removeExistingImage(imagenId) {
    const id = String(imagenId);
    console.log('removeExistingImage llamado con ID:', id);
    
    const isAlreadyMarked = window.imagenesAEliminar.some(existingId => String(existingId) === id);

    if (!isAlreadyMarked) {
        window.imagenesAEliminar.push(id);

        const hiddenInput = document.getElementById('imagenes_eliminar');
        if (hiddenInput) {
            hiddenInput.value = window.imagenesAEliminar.join(',');
            console.log('imagenes_eliminar actualizado a:', hiddenInput.value);
        }

        const imageItem = document.querySelector('.current-image-item[data-imagen-id="' + id + '"]');
        console.log('Elemento encontrado:', imageItem);
        
        if (imageItem) {
            // Asegurar que el contenedor tiene posición relativa
            imageItem.style.position = 'relative';
            imageItem.style.opacity = '0.4';
            imageItem.style.backgroundColor = '#f0f0f0';
            
            // Buscar y ocultar el botón X
            const removeBtn = imageItem.querySelector('.btn-eliminar-imagen-existente');
            if (removeBtn) {
                removeBtn.style.opacity = '0.3';
                removeBtn.style.pointerEvents = 'none';
                console.log('Botón X ocultado');
            }

            // Crear indicador "ELIMINADA"
            const deleteIndicator = document.createElement('div');
            deleteIndicator.className = 'delete-indicator';
            deleteIndicator.textContent = 'ELIMINADA';
            deleteIndicator.style.cssText = `
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(231, 76, 60, 0.9);
                color: white;
                padding: 10px 15px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: bold;
                z-index: 100;
                box-shadow: 0 2px 8px rgba(0,0,0,0.3);
                white-space: nowrap;
            `;
            imageItem.appendChild(deleteIndicator);
            console.log('Indicador ELIMINADA añadido');
        } else {
            console.error('No se encontró el elemento con data-imagen-id=' + id);
        }
    } else {
        console.log('Imagen ya marcada para eliminar:', id);
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
                    const adminIndexUrl = window.editConfig?.adminIndexRoute || '/admin';
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
            previewDiv.className = 'new-image-item'; // Clase para identificar imágenes nuevas
            previewDiv.style.cssText = 'position: relative; text-align: center; border: 3px solid #ffc107; border-radius: 8px; padding: 5px; background: #fffbf0; max-width: 170px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);';

            // Botón X para eliminar imagen NUEVA/SELECCIONADA (no guardada aún)
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'btn-eliminar-imagen-nueva';
            removeBtn.style.cssText = 'position: absolute; top: 3px; right: 3px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; z-index: 10; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.3);';
            removeBtn.title = 'Quitar imagen seleccionada';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                e.stopPropagation();
                removeSelectedImage(index);
            };

            // Añadir efectos hover
            removeBtn.onmouseenter = function () {
                this.style.background = '#c0392b';
                this.style.transform = 'scale(1.15)';
            };
            removeBtn.onmouseleave = function () {
                this.style.background = '#e74c3c';
                this.style.transform = 'scale(1)';
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
            badge.style.cssText = 'display: inline-block; background: #ffc107; color: #000; padding: 2px 8px; border-radius: 3px; font-size: 9px; font-weight: bold; margin-top: 3px;';

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

// Hacer disponibles globalmente
window.previewImages = previewImages;
window.validateImageFile = validateImageFile;
window.renderImagePreviews = renderImagePreviews;
window.updateFileInput = updateFileInput;
window.removeExistingImage = removeExistingImage;
window.setupExistingImageDeleteButtons = setupImageDelegation;