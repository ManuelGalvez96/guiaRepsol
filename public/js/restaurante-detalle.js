import '../css/restaurante-detalle.css';

// Función para el horario desplegable
function toggleHorario() {
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
}

// Inicialización automática cuando se carga el DOM
window.onload = function() {
    // Inicializar todos los modales
    const modales = document.querySelectorAll('.modal');
    modales.forEach(function(modalElement) {
        new bootstrap.Modal(modalElement);
    });

    // Asignar eventos a los botones de modal automáticamente
    const botonesModal = document.querySelectorAll('[data-bs-toggle="modal"]');
    botonesModal.forEach(function(boton) {
        boton.onclick = function() {
            const targetId = boton.getAttribute('data-bs-target');
            const modalElement = document.querySelector(targetId);
            if (modalElement) {
                const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modal.show();
            }
        };
    });

    // Asignar evento al toggle del horario si existe
    const horarioToggle = document.querySelector('.horario-toggle');
    if (horarioToggle) {
        horarioToggle.onclick = toggleHorario;
    }

    console.log('Modales inicializados:', modales.length);
};

