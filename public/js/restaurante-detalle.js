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

// Inicialización cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function() {
    // Horario desplegable
    const horarioToggle = document.querySelector('.horario-toggle');
    if (horarioToggle) {
        horarioToggle.addEventListener('click', toggleHorario);
    }

    // Verificar que Bootstrap esté cargado
    if (typeof bootstrap !== 'undefined') {
        console.log('Bootstrap cargado correctamente');
        
        // Inicializar todos los botones de modal manualmente
        const botonesModal = document.querySelectorAll('[data-bs-toggle="modal"]');
        console.log('Botones de modal encontrados:', botonesModal.length);
        
        botonesModal.forEach(function(boton) {
            boton.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-bs-target');
                console.log('Intentando abrir modal:', targetId);
                const modalElement = document.querySelector(targetId);
                
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                    console.log('Modal abierto:', targetId);
                } else {
                    console.error('Modal no encontrado:', targetId);
                }
            });
        });
    } else {
        console.error('Bootstrap no está cargado');
    }
    
    console.log('Página de restaurante cargada correctamente');
});

