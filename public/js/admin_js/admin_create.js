// JavaScript para crear restaurantes 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;
let selectedFiles = []; // Array para mantener archivos seleccionados

window.onload = () => {
    console.log('Inicializando formulario de crear...');
    
    // Obtener token CSRF
    if (typeof window.createConfig !== 'undefined') {
        csrfToken = window.createConfig.csrfToken;
    } else {
        const metaToken = document.querySelector('meta[name="csrf-token"]');
        if (metaToken) {
            csrfToken = metaToken.getAttribute('content');
        }
    }

    const form = document.getElementById('createRestauranteForm');
    if (form) {
        form.onsubmit = function(e) {
            e.preventDefault();
            console.log('Enviando formulario...');
            crearRestaurante();
        }
    }
    
    console.log('Form de crear cargado');
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

function crearRestaurante() {
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
    
    // AJAX con patrón 
    peticionAjax(form.action, 'POST', manejarCrear, formData);
}

function manejarCrear() {
    if (ajaxObj.readyState == READY_STATE_COMPLETE) {
        const submitBtn = document.getElementById('submitBtn');
        
        if (ajaxObj.status == 200) {
            const data = JSON.parse(ajaxObj.responseText);
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    const adminIndexUrl = window.createConfig?.adminIndexRoute || '/admin';
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
                submitBtn.textContent = 'Crear Restaurante';
                submitBtn.disabled = false;
            }
        } else {
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
        }
    }
}

// Preview de múltiples imágenes con opción de eliminar
function previewImages(event) {
    const files = event.target.files;
    const imagesPreview = document.getElementById('imagesPreview');
    
    if (!imagesPreview) return;
    
    // Limpiar previews anteriores y resetear array
    imagesPreview.innerHTML = '';
    selectedFiles = [];
    
    if (files && files.length > 0) {
        // Validar cada archivo y añadir a selectedFiles
        for (let i = 0; i < files.length; i++) {
            if (validateImageFile(files[i])) {
                selectedFiles.push(files[i]);
            }
        }
        
        if (selectedFiles.length === 0) {
            imagesPreview.innerHTML = '<small style="color: #e74c3c; width: 100%; text-align: center; margin: 20px 0;">No se seleccionaron imágenes válidas</small>';
            return;
        }
        
        // Renderizar previews
        renderImagePreviews();
    } else {
        imagesPreview.innerHTML = '<small style="color: #666; width: 100%; text-align: center; margin: 20px 0;">Las imágenes seleccionadas aparecerán aquí</small>';
    }
}

// Función para renderizar los previews de las imágenes
function renderImagePreviews() {
    const imagesPreview = document.getElementById('imagesPreview');
    if (!imagesPreview) return;
    
    imagesPreview.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewDiv = document.createElement('div');
            previewDiv.style.cssText = 'position: relative; display: flex; flex-direction: column; align-items: center; padding: 10px; background: #fff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 170px;';
            
            // Botón X para eliminar
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.style.cssText = 'position: absolute; top: 5px; right: 5px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer; font-size: 18px; font-weight: bold; display: flex; align-items: center; justify-content: center; z-index: 10;';
            removeBtn.title = 'Eliminar imagen';
            removeBtn.onclick = (e) => {
                e.preventDefault();
                removeImage(index);
            };
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = `Vista previa ${index + 1}`;
            img.style.cssText = 'width: 150px; height: 100px; object-fit: cover; border: 2px solid #28a745; border-radius: 5px;';
            
            const fileName = document.createElement('small');
            fileName.textContent = file.name;
            fileName.style.cssText = 'margin-top: 8px; color: #666; text-align: center; word-break: break-all; line-height: 1.3; max-width: 150px;';
            
            previewDiv.appendChild(removeBtn);
            previewDiv.appendChild(img);
            previewDiv.appendChild(fileName);
            imagesPreview.appendChild(previewDiv);
        }
        reader.readAsDataURL(file);
    });
    
    // Añadir mensaje de resumen
    const summary = document.createElement('div');
    summary.style.cssText = 'width: 100%; text-align: center; margin: 10px 0; font-weight: 500; color: #28a745;';
    summary.textContent = `✓ ${selectedFiles.length} imagen(es) seleccionada(s)`;
    imagesPreview.appendChild(summary);
    
    console.log(`${selectedFiles.length} imágenes seleccionadas`);
}

// Función para eliminar una imagen específica
function removeImage(index) {
    if (index >= 0 && index < selectedFiles.length) {
        selectedFiles.splice(index, 1);
        
        // Actualizar el input file con los archivos restantes
        updateFileInput();
        
        // Si quedan archivos, renderizar de nuevo
        if (selectedFiles.length > 0) {
            renderImagePreviews();
        } else {
            // Si no quedan archivos, mostrar mensaje por defecto
            const imagesPreview = document.getElementById('imagesPreview');
            if (imagesPreview) {
                imagesPreview.innerHTML = '<small style="color: #666; width: 100%; text-align: center; margin: 20px 0;">Las imágenes seleccionadas aparecerán aquí</small>';
            }
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