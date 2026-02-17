// Estado global para sincronización
let restaurantState = {
    liked: null,
    saved: null,
    totalLikes: null
};

// Función para sincronizar todos los botones
function syncAllButtons() {
    syncLikeButtons();
    syncSaveButtons();
}

// Sincronizar botones de Like
function syncLikeButtons() {
    const btnFavoritoDesktop = document.getElementById('btn-favorito');
    const btnFavoritoMobile = document.getElementById('btn-favorito-mobile');
    const likeCountDesktop = document.getElementById('like-count');
    const likeCountMobile = document.getElementById('like-count-mobile');

    const updateButton = (btn, likeCount) => {
        if (!btn) return;
        const icon = btn.querySelector('i');

        if (restaurantState.liked) {
            btn.classList.add('active');
            icon.classList.remove('bi-heart');
            icon.classList.add('bi-heart-fill');
        } else {
            btn.classList.remove('active');
            icon.classList.remove('bi-heart-fill');
            icon.classList.add('bi-heart');
        }

        if (likeCount && restaurantState.totalLikes !== null) {
            likeCount.textContent = restaurantState.totalLikes;
        }
    };

    updateButton(btnFavoritoDesktop, likeCountDesktop);
    updateButton(btnFavoritoMobile, likeCountMobile);
}

// Sincronizar botones de Save
function syncSaveButtons() {
    const btnGuardarDesktop = document.getElementById('btn-guardar');
    const btnGuardarMobile = document.getElementById('btn-guardar-mobile');

    const updateButton = (btn) => {
        if (!btn) return;
        const icon = btn.querySelector('i');

        if (restaurantState.saved) {
            btn.classList.add('active');
            icon.classList.remove('bi-bookmark');
            icon.classList.add('bi-bookmark-fill');
        } else {
            btn.classList.remove('active');
            icon.classList.remove('bi-bookmark-fill');
            icon.classList.add('bi-bookmark');
        }
    };

    updateButton(btnGuardarDesktop);
    updateButton(btnGuardarMobile);
}

// Función para dar like/unlike
function likeRestaurant(restauranteId, origin) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/restaurante/${restauranteId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            restaurantState.liked = data.liked;
            restaurantState.totalLikes = data.totalLikes;
            syncAllButtons();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para guardar/quitar de guardados
function saveRestaurant(restauranteId, origin) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/restaurante/${restauranteId}/guardar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            restaurantState.saved = data.saved;
            syncAllButtons();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Función para editar restaurante
function editRestaurant(restauranteId) {
    const modal = new bootstrap.Modal(document.getElementById('modalEditarRestaurante'));
    modal.show();
}

// Inicializar estado global basado en valores del servidor
function initializeRestaurantState() {
    // Los datos se pasan desde el blade en variables globales
    // Usa los atributos data de los botones si los tienes disponibles
    const btnFavorito = document.getElementById('btn-favorito');
    if (btnFavorito && !restaurantState.liked) {
        restaurantState.liked = btnFavorito.classList.contains('active');
        const likeCount = document.getElementById('like-count');
        if (likeCount) {
            restaurantState.totalLikes = parseInt(likeCount.textContent);
        }
    }
    
    const btnGuardar = document.getElementById('btn-guardar');
    if (btnGuardar && restaurantState.saved === null) {
        restaurantState.saved = btnGuardar.classList.contains('active');
    }
}

// Función para el horario desplegable

window.onload = function() {
    // Menú hamburguesa para móvil
    const btnMenu = document.querySelector('.btn-menu-detalle');
    const mobileMenu = document.getElementById('mobileMenu');
    
    if (btnMenu && mobileMenu) {
        btnMenu.onclick = function() {
            if (typeof toggleMobileMenu === 'function') {
                toggleMobileMenu();
            } else {
                mobileMenu.classList.toggle('active');
            }
            btnMenu.classList.toggle('active');
        };
        
        // Cerrar el menú al hacer clic en un enlace
        const navLinks = mobileMenu.querySelectorAll('a');
        navLinks.forEach(function(link) {
            link.onclick = function() {
                if (window.innerWidth <= 768) {
                    mobileMenu.classList.remove('active');
                    btnMenu.classList.remove('active');
                }
            };
        });
        
        // Cerrar el menú al hacer clic fuera de él
        document.onclick = function(event) {
            if (window.innerWidth <= 768) {
                const isClickInsideMenu = mobileMenu.contains(event.target);
                const isClickOnButton = btnMenu.contains(event.target);
                
                if (!isClickInsideMenu && !isClickOnButton && mobileMenu.classList.contains('active')) {
                    mobileMenu.classList.remove('active');
                    btnMenu.classList.remove('active');
                }
            }
        };
    }

    // Horario desplegable
    const horarioToggle = document.querySelector('.horario-toggle');
    if (horarioToggle) {
        horarioToggle.onclick = function() {
            const detalle = document.getElementById('horarioDetalle');
            const icon = document.querySelector('.horario-icon');
            
            if (detalle.style.display === 'none') {
                detalle.style.display = 'block';
                icon.classList.remove('bi-chevron-down');
                icon.classList.add('bi-chevron-up');
            } else {
                detalle.style.display = 'none';
                icon.classList.remove('bi-chevron-up');
                icon.classList.add('bi-chevron-down');
            }
        };
    }

    // Sistema de calificación con estrellas
    const ratingContainers = document.querySelectorAll('.rating-stars');
    
    ratingContainers.forEach(container => {
        const stars = container.querySelectorAll('.star');
        const modalId = container.getAttribute('data-modal-id');
        const puntuacionInput = modalId 
            ? document.getElementById(`puntuacion-edit-${modalId}`)
            : document.getElementById('puntuacion');
        
        let selectedRating = parseInt(container.getAttribute('data-current-rating')) || 0;
        
        // Inicializar con la puntuación actual si existe
        if (selectedRating > 0) {
            highlightStars(stars, selectedRating);
        }

        stars.forEach(star => {
            // Efecto hover
            star.onmouseenter = function() {
                const value = parseInt(this.getAttribute('data-value'));
                highlightStars(stars, value);
            };

            // Al hacer clic
            star.onclick = function() {
                selectedRating = parseInt(this.getAttribute('data-value'));
                if (puntuacionInput) {
                    puntuacionInput.value = selectedRating;
                }
                highlightStars(stars, selectedRating);
            };
        });

        // Restaurar selección al salir del hover
        container.onmouseleave = function() {
            if (selectedRating > 0) {
                highlightStars(stars, selectedRating);
            } else {
                clearStars(stars);
            }
        };
    });

    function highlightStars(stars, count) {
        stars.forEach(star => {
            const value = parseInt(star.getAttribute('data-value'));
            if (value <= count) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }

    function clearStars(stars) {
        stars.forEach(star => {
            star.classList.remove('active');
        });
    }

    // Configurar CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        window.csrfToken = csrfToken.getAttribute('content');
    }

    // Manejar botones de guardar valoración
    const botonesGuardar = document.querySelectorAll('.btn-guardar-valoracion');
    botonesGuardar.forEach(boton => {
        boton.onclick = function() {
            const valoracionId = this.getAttribute('data-valoracion-id');
            const restauranteId = this.getAttribute('data-restaurante-id');
            const form = document.getElementById(`form-editar-valoracion-${valoracionId}`);
            const puntuacion = form.querySelector('[name="puntuacion"]').value;
            const comentario = form.querySelector('[name="comentario"]').value;
            
            if (!puntuacion) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Puntuación requerida',
                    text: 'Por favor selecciona una puntuación',
                    confirmButtonColor: '#00a3e0'
                });
                return;
            }
            
            // Cerrar modal
            const modalElement = document.getElementById(`modalEditarValoracion${valoracionId}`);
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide();
            
            // Mostrar loading
            Swal.fire({
                title: 'Actualizando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            fetch(`/valoracion/${valoracionId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    puntuacion: parseInt(puntuacion),
                    comentario: comentario
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Actualizado!',
                    text: 'Tu reseña ha sido actualizada correctamente',
                    confirmButtonColor: '#00a3e0'
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar la reseña',
                    confirmButtonColor: '#00a3e0'
                });
            });
        };
    });

    // Manejar botones de eliminar valoración
    const botonesEliminar = document.querySelectorAll('.btn-eliminar-valoracion');
    botonesEliminar.forEach(boton => {
        boton.onclick = function() {
            const valoracionId = this.getAttribute('data-valoracion-id');
            
            Swal.fire({
                title: '¿Eliminar reseña?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Cerrar modal
                    const modalElement = document.getElementById(`modalEditarValoracion${valoracionId}`);
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) modal.hide();
                    
                    // Mostrar loading
                    Swal.fire({
                        title: 'Eliminando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch(`/valoracion/${valoracionId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Eliminada!',
                            text: 'Tu reseña ha sido eliminada correctamente',
                            confirmButtonColor: '#00a3e0'
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo eliminar la reseña',
                            confirmButtonColor: '#00a3e0'
                        });
                    });
                }
            });
        };
    });

    // Manejar botón de favorito (like)
    const btnFavorito = document.getElementById('btn-favorito');
    if (btnFavorito) {
        // El onclick ya está definido en el HTML, no necesita modificación aquí
    }

    // Manejar botón de guardar
    const btnGuardar = document.getElementById('btn-guardar');
    if (btnGuardar) {
        // El onclick ya está definido en el HTML, no necesita modificación aquí
    }

    // Slider de miniaturas
    const thumbnailsWrapper = document.getElementById('thumbnailsWrapper');
    const thumbnailPrev = document.getElementById('thumbnailPrev');
    const thumbnailNext = document.getElementById('thumbnailNext');
    const imagenPrincipalDisplay = document.getElementById('imagenPrincipalDisplay');

    if (thumbnailsWrapper && thumbnailPrev && thumbnailNext) {
        let currentIndex = 0;
        const thumbnails = thumbnailsWrapper.querySelectorAll('.thumbnail-item');
        const itemsPerView = 4;
        const totalItems = thumbnails.length;
        const maxIndex = Math.max(0, totalItems - itemsPerView);

        // Función para actualizar el slider
        function updateSlider() {
            const offset = -(currentIndex * (100 / itemsPerView));
            thumbnailsWrapper.style.transform = `translateX(${offset}%)`;
            
            // Actualizar estado de botones
            thumbnailPrev.disabled = currentIndex === 0;
            thumbnailNext.disabled = currentIndex >= maxIndex;
        }

        // Botón anterior
        thumbnailPrev.onclick = function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        };

        // Botón siguiente
        thumbnailNext.onclick = function() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSlider();
            }
        };

        // Click en miniatura
        thumbnails.forEach(thumbnail => {
            thumbnail.onclick = function() {
                // Remover clase active de todas las miniaturas
                thumbnails.forEach(t => t.classList.remove('active'));
                
                // Agregar clase active a la miniatura clickeada
                this.classList.add('active');
                
                // Cambiar imagen principal
                const imageUrl = this.getAttribute('data-image');
                if (imagenPrincipalDisplay) {
                    imagenPrincipalDisplay.src = imageUrl;
                }
            };
        });

        // Inicializar
        updateSlider();
    }

    // Manejar botón de editar restaurante (para gerentes)
    const btnEditarRestaurante = document.getElementById('btn-editar-restaurante');
    if (btnEditarRestaurante) {
        // El onclick ya está definido en el HTML, no necesita modificación aquí
    }

    // Manejar guardar edición de restaurante
    const btnGuardarEdicion = document.getElementById('btnGuardarEdicion');
    if (btnGuardarEdicion) {
        btnGuardarEdicion.onclick = function() {
            const restauranteId = document.getElementById('btn-editar-restaurante').getAttribute('data-restaurante-id');
            const form = document.getElementById('formEditarRestaurante');
            const formData = new FormData(form);
            
            // Validaciones básicas
            const nombre = document.getElementById('edit_nombre').value.trim();
            const email = document.getElementById('edit_email').value.trim();
            const direccion = document.getElementById('edit_direccion').value.trim();
            const precio = document.getElementById('edit_precio').value;
            
            if (!nombre || !email || !direccion || !precio) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    text: 'Por favor completa todos los campos obligatorios',
                    confirmButtonColor: '#00a3e0'
                });
                return;
            }

            // Cerrar modal
            const modalElement = document.getElementById('modalEditarRestaurante');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) modal.hide();

            // Mostrar loading
            Swal.fire({
                title: 'Actualizando...',
                text: 'Por favor espera',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enviar con fetch
            fetch(`/restaurante/${restauranteId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: data.message || 'Restaurante actualizado exitosamente',
                        confirmButtonColor: '#00a3e0'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Error al actualizar');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'No se pudo actualizar el restaurante',
                    confirmButtonColor: '#00a3e0'
                });
            });
        };
    }

    // Manejar eliminación de imágenes del slider
    const botonesEliminarImagenSlider = document.querySelectorAll('.btn-eliminar-imagen-slider');
    botonesEliminarImagenSlider.forEach(boton => {
        boton.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const imagenId = this.getAttribute('data-imagen-id');
            
            Swal.fire({
                title: '¿Eliminar imagen?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Eliminando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    fetch(`/imagen-slider/${imagenId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar visualmente el elemento
                            const imagenItem = document.querySelector(`.imagen-actual-item[data-imagen-id="${imagenId}"]`);
                            if (imagenItem) {
                                imagenItem.remove();
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminada!',
                                text: data.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error(data.message || 'Error al eliminar');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.message || 'No se pudo eliminar la imagen',
                            confirmButtonColor: '#00a3e0'
                        });
                    });
                }
            });
        };
    });

    // Inicializar estado global al cargar la página
    initializeRestaurantState();
};

