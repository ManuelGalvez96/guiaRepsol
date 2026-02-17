// JavaScript para editar restaurantes 
var csrfToken;
var selectedFiles = []; // Array para mantener archivos seleccionados
var processingClick = false; // Flag para evitar clics múltiples

// Usar el array global si existe, sino crear uno nuevo
if (typeof window.imagenesAEliminar === 'undefined') {
    window.imagenesAEliminar = [];
}

// Al cargar la pagina
window.onload = function () {
    // Pequeño delay para asegurar que el DOM esté listo
    setTimeout(function() {
        initializeEditForm();
    }, 100);
};

function initializeEditForm() {
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
            actualizarRestaurante();
        }
    }

    // Usar delegación de eventos para botones de eliminar imágenes existentes
    setupImageDelegation();

}

// Delegación de eventos: un solo listener en el contenedor maneja todos los clicks
function setupImageDelegation() {
    var container = document.getElementById('allImagesContainer');
    if (!container) {
        console.error('No se encontró el contenedor de imágenes');
        return;
    }
    
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
                if (!response.ok) {
                    return response.json().then(data => {
                        throw data;
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
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
    }
}

// Función para configurar efectos hover en los botones
function setupHoverEffects() {
    const buttons = document.querySelectorAll('.btn-eliminar-imagen-existente');
    buttons.forEach(btn => {
        const action = btn.getAttribute('data-action') || 'delete';
        
        btn.onmouseenter = function() {
            if (this.getAttribute('data-action') === 'restore') {
                this.style.backgroundColor = '#229954';
            } else {
                this.style.backgroundColor = '#c0392b';
            }
            this.style.transform = 'scale(1.15)';
        };
        
        btn.onmouseleave = function() {
            if (this.getAttribute('data-action') === 'restore') {
                this.style.backgroundColor = '#27ae60';
            } else {
                this.style.backgroundColor = '#e74c3c';
            }
            this.style.transform = 'scale(1)';
        };
    });
}

// Función para eliminar/restaurar imagen existente (toggle)
function removeExistingImage(imagenId) {
    // Evitar procesamiento múltiple en rápida sucesión
    if (processingClick) {
        return;
    }
    
    processingClick = true;
    
    const id = String(imagenId);
    const isAlreadyMarked = window.imagenesAEliminar.some(existingId => String(existingId) === id);

    if (!isAlreadyMarked) {
        // MARCAR PARA ELIMINAR
        window.imagenesAEliminar.push(id);

        const hiddenInput = document.getElementById('imagenes_eliminar');
        if (hiddenInput) {
            hiddenInput.value = window.imagenesAEliminar.join(',');
        }

        const imageItem = document.querySelector('.current-image-item[data-imagen-id="' + id + '"]');
        
        if (imageItem) {
            imageItem.style.opacity = '0.3';
            imageItem.style.transition = 'all 0.3s';
            imageItem.style.filter = 'grayscale(100%)';
            imageItem.classList.add('marked-for-deletion');

            const deleteIndicator = document.createElement('div');
            deleteIndicator.className = 'delete-indicator';
            deleteIndicator.style.cssText = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgba(231, 76, 60, 0.95); color: white; padding: 8px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; z-index: 15; box-shadow: 0 2px 8px rgba(0,0,0,0.3);';
            deleteIndicator.textContent = 'ELIMINADA';
            imageItem.appendChild(deleteIndicator);

            // Cambiar botón X por botón +
            const btn = imageItem.querySelector('.btn-eliminar-imagen-existente');
            
            if (btn) {
                // Agregar clase para modo restaurar
                btn.classList.add('btn-restore');
                
                // Aplicar estilos directamente
                btn.style.position = 'absolute';
                btn.style.top = '3px';
                btn.style.right = '3px';
                btn.style.backgroundColor = '#27ae60';
                btn.style.color = 'white';
                btn.style.border = 'none';
                btn.style.borderRadius = '50%';
                btn.style.width = '28px';
                btn.style.height = '28px';
                btn.style.cursor = 'pointer';
                btn.style.fontSize = '22px';
                btn.style.fontWeight = 'bold';
                btn.style.display = 'flex';
                btn.style.alignItems = 'center';
                btn.style.justifyContent = 'center';
                btn.style.zIndex = '1000';
                btn.style.boxShadow = '0 2px 6px rgba(0,0,0,0.3)';
                btn.style.transition = 'all 0.2s ease';
                
                btn.innerHTML = '+';
                btn.title = 'Restaurar imagen';
                btn.setAttribute('data-action', 'restore');
            } else {
            }
            
            // Reconfigurar hover effects
            setupHoverEffects();
        } else {
        }
    } else {
        // RESTAURAR IMAGEN
        window.imagenesAEliminar = window.imagenesAEliminar.filter(existingId => String(existingId) !== id);

        const hiddenInput = document.getElementById('imagenes_eliminar');
        if (hiddenInput) {
            hiddenInput.value = window.imagenesAEliminar.join(',');
        }

        const imageItem = document.querySelector('.current-image-item[data-imagen-id="' + id + '"]');
        if (imageItem) {
            imageItem.style.opacity = '1';
            imageItem.style.filter = 'grayscale(0%)';
            imageItem.classList.remove('marked-for-deletion');

            const deleteIndicator = imageItem.querySelector('.delete-indicator');
            if (deleteIndicator) {
                deleteIndicator.remove();
            }

            // Cambiar botón + por botón X
            const btn = imageItem.querySelector('.btn-eliminar-imagen-existente');
            if (btn) {
                // Remover clase de modo restaurar
                btn.classList.remove('btn-restore');
                
                // Aplicar estilos para modo eliminar
                btn.style.position = 'absolute';
                btn.style.top = '3px';
                btn.style.right = '3px';
                btn.style.backgroundColor = '#e74c3c';
                btn.style.color = 'white';
                btn.style.border = 'none';
                btn.style.borderRadius = '50%';
                btn.style.width = '28px';
                btn.style.height = '28px';
                btn.style.cursor = 'pointer';
                btn.style.fontSize = '20px';
                btn.style.fontWeight = 'bold';
                btn.style.display = 'flex';
                btn.style.alignItems = 'center';
                btn.style.justifyContent = 'center';
                btn.style.zIndex = '1000';
                btn.style.boxShadow = '0 2px 6px rgba(0,0,0,0.3)';
                btn.style.transition = 'all 0.2s ease';
                
                btn.innerHTML = '×';
                btn.title = 'Eliminar imagen';
                btn.setAttribute('data-action', 'delete');
            }
            
            // Reconfigurar hover effects
            setupHoverEffects();
        }
        
    }
    
    // Llamar a la función de validación si está disponible
    if (typeof window.comprobarImagenes === 'function') {
        window.comprobarImagenes();
    }
    
    // Liberar el flag después de un breve delay
    setTimeout(() => {
        processingClick = false;
    }, 300);
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
                    if (typeof window.closeModal === 'function') {
                        window.closeModal();
                    }
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
                    submitBtn.textContent = 'Actualizar Restaurante';
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
            text: 'Error al actualizar el restaurante'
        });

        // Restaurar botón
        if (submitBtn) {
            submitBtn.textContent = 'Actualizar Restaurante';
            submitBtn.disabled = false;
        }
    });
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

}

// Función para eliminar una imagen SELECCIONADA/NUEVA (no guardada aún)
function removeSelectedImage(index) {
    if (index >= 0 && index < selectedFiles.length) {
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



// Hacer disponibles globalmente al final del archivo (después de todas las definiciones)
window.initializeEditForm = initializeEditForm;
window.previewImages = previewImages;
window.validateImageFile = validateImageFile;
window.renderImagePreviews = renderImagePreviews;
window.updateFileInput = updateFileInput;
window.removeExistingImage = removeExistingImage;
window.setupExistingImageDeleteButtons = setupImageDelegation;
window.setupHoverEffects = setupHoverEffects;
