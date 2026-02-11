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
});

