// Función para el horario desplegable
document.addEventListener('DOMContentLoaded', function() {
    // Horario desplegable
    const horarioToggle = document.querySelector('.horario-toggle');
    if (horarioToggle) {
        horarioToggle.addEventListener('click', function() {
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
        });
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
            star.addEventListener('mouseenter', function() {
                const value = parseInt(this.getAttribute('data-value'));
                highlightStars(stars, value);
            });

            // Al hacer clic
            star.addEventListener('click', function() {
                selectedRating = parseInt(this.getAttribute('data-value'));
                if (puntuacionInput) {
                    puntuacionInput.value = selectedRating;
                }
                highlightStars(stars, selectedRating);
            });
        });

        // Restaurar selección al salir del hover
        container.addEventListener('mouseleave', function() {
            if (selectedRating > 0) {
                highlightStars(stars, selectedRating);
            } else {
                clearStars(stars);
            }
        });
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
        boton.addEventListener('click', function() {
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
        });
    });

    // Manejar botones de eliminar valoración
    const botonesEliminar = document.querySelectorAll('.btn-eliminar-valoracion');
    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function() {
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
        });
    });
});

