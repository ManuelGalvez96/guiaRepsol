/**
 * Funcionalidades para reportar valoraciones
 */

// Log para confirmar que el script se ha cargado
console.log('========================================');
console.log('REPORTES.JS VERSIÓN: 2026-02-18-18:00');
console.log('========================================');

/**
 * Abrir modal de reportar valoración
 */
function abrirModalReportar(valoracionId) {
    console.log('========================================');
    console.log('ABRIENDO MODAL DE REPORTE');
    console.log('Valoración ID:', valoracionId);
    console.log('========================================');
    
    const modalId = `modalReportarValoracion${valoracionId}`;
    console.log('Buscando modal con ID:', modalId);
    
    const modalElement = document.getElementById(modalId);
    
    console.log('Modal encontrado:', modalElement);
    
    if (!modalElement) {
        console.error(`No se encontró el modal: ${modalId}`);
        
        // Buscar todos los modales disponibles
        const todosLosModales = document.querySelectorAll('[id^="modalReportar"]');
        console.log('Modales encontrados en la página:', todosLosModales.length);
        todosLosModales.forEach(modal => {
            console.log('  - ID:', modal.id);
        });
        
        alert('Error: El modal de reporte no está disponible. Por favor, recarga la página.');
        return;
    }
    
    console.log('Modal encontrado exitosamente');
    
    // Verificar permisos desde los data attributes
    const usuarioId = modalElement.getAttribute('data-usuario-id');
    const gerenteId = modalElement.getAttribute('data-gerente-id');
    const authId = modalElement.getAttribute('data-auth-id');
    
    console.log('Usuario valoración:', usuarioId);
    console.log('Gerente restaurante:', gerenteId);
    console.log('Usuario autenticado:', authId);
    
    // Validar que el usuario puede reportar
    if (authId === '0' || !authId) {
        alert('Debes iniciar sesión para reportar una valoración');
        return;
    }
    
    if (usuarioId === authId) {
        alert('No puedes reportar tu propia valoración');
        return;
    }
    
    if (gerenteId === authId) {
        alert('No puedes reportar valoraciones de tu propio restaurante');
        return;
    }
    
    try {
        // Verificar si Bootstrap está disponible
        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap no está disponible');
            alert('Error: Bootstrap no está cargado');
            return;
        }
        
        // Crear o obtener instancia del modal
        let modal = bootstrap.Modal.getInstance(modalElement);
        if (!modal) {
            console.log('Creando nueva instancia de modal');
            modal = new bootstrap.Modal(modalElement);
        }
        
        console.log('Mostrando modal...');
        modal.show();
        console.log('Modal mostrado exitosamente');
        
    } catch (error) {
        console.error('Error al abrir modal:', error);
        alert('Error al abrir modal: ' + error.message);
    }
}

function reportarValoracion(valoracionId) {
    console.log('========================================');
    console.log('FUNCIÓN reportarValoracion EJECUTADA');
    console.log('Valoración ID:', valoracionId);
    console.log('========================================');
    
    const razonElement = document.getElementById(`razon-reporte-${valoracionId}`);
    console.log('Elemento textarea encontrado:', razonElement ? 'SÍ' : 'NO');


    
    if (!razonElement) {
        console.error(`No se encontró el elemento razon-reporte-${valoracionId}`);
        
        // Verificar si SweetAlert2 está disponible
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al procesar el reporte. Por favor, recarga la página.'
            });
        } else {
            alert('Error al procesar el reporte. SweetAlert2 no está cargado.');
        }
        return;
    }
    
    const razon = razonElement.value.trim();
    console.log('Razón del reporte:', razon);

    if (!razon) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor, proporciona una razón para el reporte'
            });
        } else {
            alert('Por favor, proporciona una razón para el reporte');
        }
        razonElement.focus();
        return;
    }

    if (razon.length < 10) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Razón muy corta',
                text: 'La razón debe tener al menos 10 caracteres'
            });
        } else {
            alert('La razón debe tener al menos 10 caracteres');
        }
        razonElement.focus();
        return;
    }

    if (razon.length > 500) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Razón muy larga',
                text: 'La razón no puede exceder 500 caracteres'
            });
        } else {
            alert('La razón no puede exceder 500 caracteres');
        }
        razonElement.focus();
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('No se encontró el token CSRF');
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error de seguridad. Por favor, recarga la página.'
            });
        } else {
            alert('Error de seguridad. Por favor, recarga la página.');
        }
        return;
    }

    console.log('Enviando reporte para valoración ID:', valoracionId);

    // Mostrar indicador de carga
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Enviando reporte...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }

    fetch(`/valoracion/${valoracionId}/reportar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            razon: razon
        })
    })
    .then(response => {
        console.log('Respuesta recibida:', response);
        if (!response.ok) {
            return response.json().then(data => { throw data; });
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        if (data.success) {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: '¡Reporte enviado!',
                    text: 'Los administradores revisarán tu reporte pronto.',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                alert('¡Reporte enviado! Los administradores lo revisarán pronto.');
            }
            
            // Cerrar el modal de forma segura
            const modalElement = document.getElementById(`modalReportarValoracion${valoracionId}`);
            if (modalElement) {
                try {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    } else {
                        // Si no hay instancia, crear una y cerrarla
                        const newModal = new bootstrap.Modal(modalElement);
                        newModal.hide();
                    }
                } catch (e) {
                    console.error('Error al cerrar modal:', e);
                    // Cerrar con jQuery si Bootstrap falla
                    if (typeof $ !== 'undefined') {
                        $(modalElement).modal('hide');
                    }
                }
            }
            
            // Limpiar el formulario
            razonElement.value = '';
        }
    })
    .catch(error => {
        console.error('Error completo:', error);
        
        let errorMessage = 'Error al enviar el reporte';
        
        if (error.error) {
            errorMessage = error.error;
        } else if (error.message) {
            errorMessage = error.message;
        } else if (error.errors) {
            // Errores de validación de Laravel
            errorMessage = Object.values(error.errors).flat().join('\n');
        }
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        } else {
            alert(errorMessage);
        }
    });
}


/**
 * Funcionalidades para solicitar eliminación de restaurante
 */

function abrirModalSolicitudEliminacion() {
    const modalElement = document.getElementById('modalSolicitudEliminacionRestaurante');
    if (!modalElement) {
        console.error('No se encontró el modal de solicitud de eliminación');
        return;
    }
    
    try {
        let modal = bootstrap.Modal.getInstance(modalElement);
        if (!modal) {
            modal = new bootstrap.Modal(modalElement);
        }
        modal.show();
    } catch (e) {
        console.error('Error al abrir modal:', e);
        if (typeof $ !== 'undefined') {
            $(modalElement).modal('show');
        }
    }
}

function solicitarEliminacionRestaurante() {
    const modalElement = document.getElementById('modalSolicitudEliminacionRestaurante');
    
    if (!modalElement) {
        console.error('No se encontró el modal de solicitud de eliminación');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al procesar la solicitud. Por favor, recarga la página.'
        });
        return;
    }
    
    const restauranteId = modalElement.dataset.restauranteId;
    const razonElement = document.getElementById('razon-solicitud-eliminacion');
    const razon = razonElement ? razonElement.value.trim() : '';

    if (razon && razon.length > 500) {
        Swal.fire({
            icon: 'warning',
            title: 'Razón muy larga',
            text: 'La razón no puede exceder 500 caracteres'
        });
        razonElement.focus();
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('No se encontró el token CSRF');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de seguridad. Por favor, recarga la página.'
        });
        return;
    }

    // Mostrar indicador de carga
    Swal.fire({
        title: 'Enviando solicitud...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch(`/restaurante/${restauranteId}/solicitar-eliminacion`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken.content,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            razon: razon || null
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => { throw data; });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Solicitud enviada!',
                text: 'Los administradores revisarán tu solicitud pronto.',
                confirmButtonText: 'Aceptar'
            });
            
            // Cerrar el modal de forma segura
            if (modalElement) {
                try {
                    const modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    } else {
                        // Si no hay instancia, crear una y cerrarla
                        const newModal = new bootstrap.Modal(modalElement);
                        newModal.hide();
                    }
                } catch (e) {
                    console.error('Error al cerrar modal:', e);
                    // Cerrar con jQuery si Bootstrap falla
                    if (typeof $ !== 'undefined') {
                        $(modalElement).modal('hide');
                    }
                }
            }
            
            // Limpiar el formulario
            if (razonElement) {
                razonElement.value = '';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        let errorMessage = 'Error al enviar la solicitud';
        
        if (error.error) {
            errorMessage = error.error;
        } else if (error.message) {
            errorMessage = error.message;
        } else if (error.errors) {
            // Errores de validación de Laravel
            errorMessage = Object.values(error.errors).flat().join('\n');
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: errorMessage
        });
    });
}
