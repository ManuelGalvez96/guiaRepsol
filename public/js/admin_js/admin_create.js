// JavaScript para crear restaurantes 
let csrfToken;
let ajaxObj;
const READY_STATE_COMPLETE = 4;
let selectedFiles = []; // Array para mantener archivos seleccionados

window.onload = () => {
    console.log('Inicializando formulario de crear...');
<<<<<<< HEAD

=======
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
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
<<<<<<< HEAD
        form.onsubmit = function (e) {
=======
        form.onsubmit = function(e) {
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
            e.preventDefault();
            console.log('Enviando formulario...');
            crearRestaurante();
        }
    }
<<<<<<< HEAD

=======
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    console.log('Form de crear cargado');
}

// Función AJAX 
function peticionAjax(url, metodo, funcionCallback, datos) {
    ajaxObj = new XMLHttpRequest();
    ajaxObj.open(metodo, url);
<<<<<<< HEAD

=======
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    if (metodo === 'POST') {
        ajaxObj.setRequestHeader('Accept', 'application/json');
        ajaxObj.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    }
<<<<<<< HEAD

    ajaxObj.onreadystatechange = funcionCallback;

=======
    
    ajaxObj.onreadystatechange = funcionCallback;
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    if (metodo === 'POST' && datos) {
        ajaxObj.send(datos);
    } else {
        ajaxObj.send();
    }
}

function crearRestaurante() {
    const form = document.getElementById('createRestauranteForm');
    const submitBtn = document.getElementById('submitBtn');
<<<<<<< HEAD

    // Limpiar errores anteriores
    document.querySelectorAll('.error').forEach(el => el.remove());

=======
    
    // Limpiar errores anteriores
    document.querySelectorAll('.error').forEach(el => el.remove());
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    // Cambiar botón
    if (submitBtn) {
        submitBtn.textContent = 'Creando...';
        submitBtn.disabled = true;
    }
<<<<<<< HEAD

    // Preparar datos
    const formData = new FormData(form);

=======
    
    // Preparar datos
    const formData = new FormData(form);
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    // AJAX con patrón 
    peticionAjax(form.action, 'POST', manejarCrear, formData);
}

function manejarCrear() {
    if (ajaxObj.readyState == READY_STATE_COMPLETE) {
        const submitBtn = document.getElementById('submitBtn');
<<<<<<< HEAD

=======
        
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
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
<<<<<<< HEAD

=======
            
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
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
<<<<<<< HEAD

=======
            
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
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
<<<<<<< HEAD

    if (!imagesPreview) return;

    // Limpiar previews anteriores y resetear array
    imagesPreview.innerHTML = '';
    selectedFiles = [];

=======
    
    if (!imagesPreview) return;
    
    // Limpiar previews anteriores y resetear array
    imagesPreview.innerHTML = '';
    selectedFiles = [];
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    if (files && files.length > 0) {
        // Validar cada archivo y añadir a selectedFiles
        for (let i = 0; i < files.length; i++) {
            if (validateImageFile(files[i])) {
                selectedFiles.push(files[i]);
            }
        }
<<<<<<< HEAD

        if (selectedFiles.length === 0) {
            imagesPreview.innerHTML = '<p id="noImagesMessage" style="width: 100%; text-align: center; color: #999; margin: 20px 0;">No se seleccionaron imágenes válidas. Intenta de nuevo.</p>';
            return;
        }

        // Renderizar previews
        renderImagePreviews();
    } else {
        imagesPreview.innerHTML = '<p id="noImagesMessage" style="width: 100%; text-align: center; color: #999; margin: 20px 0;">Selecciona imágenes para añadir.</p>';
=======
        
        if (selectedFiles.length === 0) {
            imagesPreview.innerHTML = '<small style="color: #e74c3c; width: 100%; text-align: center; margin: 20px 0;">No se seleccionaron imágenes válidas</small>';
            return;
        }
        
        // Renderizar previews
        renderImagePreviews();
    } else {
        imagesPreview.innerHTML = '<small style="color: #666; width: 100%; text-align: center; margin: 20px 0;">Las imágenes seleccionadas aparecerán aquí</small>';
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    }
}

// Función para renderizar los previews de las imágenes
function renderImagePreviews() {
    const imagesPreview = document.getElementById('imagesPreview');
    if (!imagesPreview) return;
<<<<<<< HEAD

    imagesPreview.innerHTML = '';

=======
    
    imagesPreview.innerHTML = '';
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const previewDiv = document.createElement('div');
<<<<<<< HEAD
            previewDiv.className = 'new-image-item';
            previewDiv.style.cssText = 'position: relative; text-align: center; border: 3px solid #ffc107; border-radius: 8px; padding: 5px; background: #fffbf0; max-width: 170px; box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);';

            // Botón X para eliminar
            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '×';
            removeBtn.className = 'btn-eliminar-imagen-nueva';
            removeBtn.style.cssText = 'position: absolute; top: 3px; right: 3px; background: #e74c3c; color: white; border: none; border-radius: 50%; width: 28px; height: 28px; cursor: pointer; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; z-index: 10; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.3);';
            removeBtn.title = 'Quitar imagen seleccionada';

            // Efectos hover
            removeBtn.onmouseenter = function () {
                this.style.background = '#c0392b';
                this.style.transform = 'scale(1.15)';
            };

            removeBtn.onmouseleave = function () {
                this.style.background = '#e74c3c';
                this.style.transform = 'scale(1)';
            };

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
            badge.style.cssText = 'display: inline-block; background: #ffc107; color: #000; padding: 2px 8px; border-radius: 3px; font-size: 9px; font-weight: bold; margin-top: 3px;';

            previewDiv.appendChild(removeBtn);
            previewDiv.appendChild(img);
            previewDiv.appendChild(fileName);
            previewDiv.appendChild(badge);
=======
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
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
            imagesPreview.appendChild(previewDiv);
        }
        reader.readAsDataURL(file);
    });
<<<<<<< HEAD

=======
    
    // Añadir mensaje de resumen
    const summary = document.createElement('div');
    summary.style.cssText = 'width: 100%; text-align: center; margin: 10px 0; font-weight: 500; color: #28a745;';
    summary.textContent = `✓ ${selectedFiles.length} imagen(es) seleccionada(s)`;
    imagesPreview.appendChild(summary);
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    console.log(`${selectedFiles.length} imágenes seleccionadas`);
}

// Función para eliminar una imagen específica
function removeImage(index) {
    if (index >= 0 && index < selectedFiles.length) {
<<<<<<< HEAD
        const fileName = selectedFiles[index].name;
        selectedFiles.splice(index, 1);

        // Actualizar el input file con los archivos restantes
        updateFileInput();

        // Si quedan archivos, renderizar de nuevo
        if (selectedFiles.length > 0) {
            renderImagePreviews();
            console.log(`Imagen "${fileName}" eliminada. Quedan ${selectedFiles.length} imagen(es)`);
=======
        selectedFiles.splice(index, 1);
        
        // Actualizar el input file con los archivos restantes
        updateFileInput();
        
        // Si quedan archivos, renderizar de nuevo
        if (selectedFiles.length > 0) {
            renderImagePreviews();
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
        } else {
            // Si no quedan archivos, mostrar mensaje por defecto
            const imagesPreview = document.getElementById('imagesPreview');
            if (imagesPreview) {
<<<<<<< HEAD
                imagesPreview.innerHTML = '<p id="noImagesMessage" style="width: 100%; text-align: center; color: #999; margin: 20px 0;">Selecciona imágenes para añadir.</p>';
            }
            console.log(`Imagen "${fileName}" eliminada. No quedan más imágenes seleccionadas`);
        }
    } else {
        console.error('Índice de imagen no válido:', index);
        alert('Error al eliminar la imagen');
=======
                imagesPreview.innerHTML = '<small style="color: #666; width: 100%; text-align: center; margin: 20px 0;">Las imágenes seleccionadas aparecerán aquí</small>';
            }
        }
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    }
}

// Función para actualizar el input file con los archivos restantes
function updateFileInput() {
    const fileInput = document.getElementById('imagenes');
    if (!fileInput) return;
<<<<<<< HEAD

    // Crear un nuevo DataTransfer object para reconstruir la lista de archivos
    const dataTransfer = new DataTransfer();

    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });

=======
    
    // Crear un nuevo DataTransfer object para reconstruir la lista de archivos
    const dataTransfer = new DataTransfer();
    
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    fileInput.files = dataTransfer.files;
}

// Función para validar cada imagen
function validateImageFile(file) {
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    const maxSize = 5 * 1024 * 1024; // 5MB
<<<<<<< HEAD

=======
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    if (!validTypes.includes(file.type)) {
        alert(`Archivo ${file.name}: Formato no válido. Use JPG, PNG, GIF o WebP`);
        return false;
    }
<<<<<<< HEAD

    if (file.size > maxSize) {
        alert(`Archivo ${file.name}: Muy grande. Máximo 5MB`);
        return false;
    }

<<<<<<<< HEAD:public/js/admin_js/admin_create.js
    // Hacer focus en el campo
    field.focus();
}
========
=======
    
    if (file.size > maxSize) {
        alert(`Archivo ${file.name}: Muy grande. Máximo 5MB`);
        return false; 
    }
    
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
    return true;
}

// Hacer disponibles globalmente
window.previewImages = previewImages;
window.validateImageFile = validateImageFile;
window.removeImage = removeImage;
window.renderImagePreviews = renderImagePreviews;
<<<<<<< HEAD
window.updateFileInput = updateFileInput;
>>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9:resources/js/admin_js/admin_create.js
=======
window.updateFileInput = updateFileInput;
>>>>>>> b32b0ac3d2fa568778eca30420923a206074bee9
