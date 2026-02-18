/**
 * Funcionalidades para reportar valoraciones
 */

function reportarValoracion(valoracionId) {
    const razonElement = document.getElementById(`razon-reporte-${valoracionId}`);
    const razon = razonElement ? razonElement.value.trim() : '';

    if (!razon) {
        alert('Por favor, proporciona una razón para el reporte');
        return;
    }

    if (razon.length < 10) {
        alert('La razón debe tener al menos 10 caracteres');
        return;
    }

    if (razon.length > 500) {
        alert('La razón no puede exceder 500 caracteres');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/valoracion/${valoracionId}/reportar`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            razon: razon
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Reporte enviado exitosamente! Los administradores lo revisarán pronto.');
            const modal = bootstrap.Modal.getInstance(document.getElementById(`modalReportarValoracion${valoracionId}`));
            if (modal) {
                modal.hide();
            }
            // Limpiar el formulario
            if (razonElement) {
                razonElement.value = '';
            }
        } else {
            if (data.error) {
                alert(`Error: ${data.error}`);
            } else {
                alert('Error al enviar el reporte');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar el reporte');
    });
}

/**
 * Funcionalidades para solicitar eliminación de restaurante
 */

function abrirModalSolicitudEliminacion() {
    const modal = new bootstrap.Modal(document.getElementById('modalSolicitudEliminacionRestaurante'));
    modal.show();
}

function solicitarEliminacionRestaurante() {
    const restauranteId = document.getElementById('modalSolicitudEliminacionRestaurante').dataset.restauranteId;
    const razonElement = document.getElementById('razon-solicitud-eliminacion');
    const razon = razonElement ? razonElement.value.trim() : '';

    if (razon && razon.length > 500) {
        alert('La razón no puede exceder 500 caracteres');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/restaurante/${restauranteId}/solicitar-eliminacion`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            razon: razon || null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('¡Solicitud enviada exitosamente! Los administradores la revisarán pronto.');
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalSolicitudEliminacionRestaurante'));
            if (modal) {
                modal.hide();
            }
            // Limpiar el formulario
            if (razonElement) {
                razonElement.value = '';
            }
        } else {
            if (data.error) {
                alert(`Error: ${data.error}`);
            } else {
                alert('Error al enviar la solicitud');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar la solicitud');
    });
}
