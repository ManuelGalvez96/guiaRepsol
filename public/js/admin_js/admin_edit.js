// JavaScript para editar restaurantes 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;
let selectedFiles = []; // Array para mantener archivos seleccionados

// Usar el array global si existe, sino crear uno nuevo
if (typeof window.imagenesAEliminar === 'undefined') {
    window.imagenesAEliminar = [];
}

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    initEditForm();
});

// También ejecutar en window.onload por compatibilidad
window.onload = () => {
    initEditForm();
}

// Función de inicialización
function initEditForm() {
    console.log('Iniciando formulario de editar...');
    
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
        form.onsubmit = function(e) {
            e.preventDefault();
            console.log('Actualizando restaurante...');
            actualizarRestaurante();
        }
    }
    
    // Configurar event listeners para botones de eliminar imágenes existentes
    setupExistingImageDeleteButtons();
    
    console.log('Form de editar cargado');
}

// Hacer funciones disponibles globalmente para que puedan ser llamadas desde el modal
window.initEditForm = initEditForm;
window.setupExistingImageDeleteButtons = setupExistingImageDeleteButtons;
window.removeExistingImage = removeExistingImage;
window.previewImages = previewImages;

// Configurar botones para eliminar imágenes existentes
function setupExistingImageDeleteButtons() {
    console.log('=== Configurando botones de eliminación de imágenes existentes ===');
    const removeButtons = document.querySelectorAll('.btn-eliminar-imagen-existente');
    console.log(`Botones encontrados: ${removeButtons.length}`);
    
    removeButtons.forEach((button, index) => {
        const imagenId = button.getAttribute('data-imagen-id');
        console.log(`Configurando botón ${index + 1}, Imagen ID: ${imagenId}`);
        
        // Remover listeners previos si existen
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        // Añadir event listener de click
        newButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const id = this.getAttribute('data-imagen-id');
            console.log('>>> CLICK en botón X, eliminando imagen ID:', id);
            removeExistingImage(id);
        });
        
        // Añadir eventos de hover
        newButton.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.15)';
            this.style.background = '#c0392b';
        });
        
        newButton.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.background = '#e74c3c';
        });
    });
    
    console.log('=== Configuración de botones completada ===');
}

// Función para eliminar imagen existente
function removeExistingImage(imagenId) {
    console.log('removeExistingImage llamada con ID:', imagenId);
    
    // Confirmar eliminación
    if (confirm('¿Estás seguro de que quieres eliminar esta imagen?\n\nSe eliminará permanentemente al guardar el formulario.')) {
        // Añadir a lista de imágenes a eliminar
        if (!window.imagenesAEliminar.includes(imagenId)) {
            window.imagenesAEliminar.push(imagenId);
            console.log('Imágenes a eliminar:', window.imagenesAEliminar);
            
            // Actualizar input oculto
            const hiddenInput = document.getElementById('imagenes_eliminar');
            if (hiddenInput) {
                hiddenInput.value = window.imagenesAEliminar.join(',');
                console.log('Hidden input actualizado:', hiddenInput.value);
            }
            
            // Ocultar visualmente la imagen
            const imageItem = document.querySelector('.current-image-item[data-imagen-id="' + imagenId + '"]');
            if (imageItem) {
                imageItem.style.opacity = '0.3';
                imageItem.style.transition = 'all 0.3s';
                imageItem.style.filter = 'grayscale(100%)';
                
                // Añadir indicador de eliminación
                const deleteIndicator = document.createElement('div');
                deleteIndicator.style.cssText = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(231, 76, 60, 0.95); color: white; padding: 8px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 15; box-shadow: 0 2px 8px rgba(0,0,0,0.3);';
                deleteIndicator.textContent = 'ELIMINADA';
                imageItem.appendChild(deleteIndicator);
                
                // Deshabilitar botón de eliminación de imagen existente
                const removeBtn = imageItem.querySelector('.btn-eliminar-imagen-existente');
                if (removeBtn) {
                    removeBtn.style.display = 'none';
                }
            }
            
            alert('Imagen marcada para eliminar. Se borrará definitivamente al guardar el formulario.');
            console.log('Imagen marcada para eliminar:', imagenId);
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
            removeBtn.onmouseenter = function() {
                this.style.background = '#c0392b';
                this.style.transform = 'scale(1.15)';
            };
            removeBtn.onmouseleave = function() {
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
window.removeImage = removeImage;
window.renderImagePreviews = renderImagePreviews;
window.updateFileInput = updateFileInput;
window.removeExistingImage = removeExistingImage;
window.setupExistingImageDeleteButtons = setupExistingImageDeleteButtons;