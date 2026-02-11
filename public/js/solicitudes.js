// Configurar CSRF token para todas las peticiones AJAX
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Función para mostrar modal con detalles
function verDetalles(id) {
    const modal = document.getElementById('detallesModal');
    const data = window.solicitudesData[id];
    
    if (!data) {
        console.error('No se encontraron datos para la solicitud ID:', id);
        return;
    }
    
    // Rellenar el modal con los datos
    document.getElementById('modalImagen').src = data.imagen;
    
    // Mostrar imágenes adicionales si existen
    const imagenesAdicionalesContainer = document.getElementById('imagenesAdicionalesContainer');
    const imagenesAdicionalesDiv = document.getElementById('imagenesAdicionales');
    
    if (data.imagenes_adicionales && data.imagenes_adicionales.length > 0) {
        imagenesAdicionalesDiv.innerHTML = '';
        data.imagenes_adicionales.forEach(function(url) {
            const img = document.createElement('img');
            img.src = url;
            img.alt = 'Imagen adicional';
            img.onclick = function() {
                document.getElementById('modalImagen').src = url;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            };
            imagenesAdicionalesDiv.appendChild(img);
        });
        imagenesAdicionalesContainer.style.display = 'block';
    } else {
        imagenesAdicionalesContainer.style.display = 'none';
    }
    
    document.getElementById('modalNombre').textContent = data.nombre;
    document.getElementById('modalCategoria').textContent = data.categoria;
    document.getElementById('modalDescripcion').textContent = data.descripcion;
    document.getElementById('modalDireccion').textContent = data.direccion;
    document.getElementById('modalCiudad').textContent = data.ciudad;
    document.getElementById('modalProvincia').textContent = data.provincia;
    document.getElementById('modalCodigoPostal').textContent = data.codigo_postal;
    document.getElementById('modalComunidad').textContent = data.comunidad;
    document.getElementById('modalTelefono').textContent = data.telefono || '-';
    document.getElementById('modalEmail').textContent = data.email;
    document.getElementById('modalWeb').textContent = data.web || '-';
    document.getElementById('modalPrecio').textContent = data.precio;
    document.getElementById('modalTiposComida').textContent = data.tipos_comida;
    document.getElementById('modalUsuario').textContent = data.usuario;
    document.getElementById('modalFecha').textContent = data.fecha;
    
    // Mostrar el modal
    modal.style.display = 'block';
}

// Función para cerrar modal
function cerrarModal() {
    const modal = document.getElementById('detallesModal');
    modal.style.display = 'none';
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    const modal = document.getElementById('detallesModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Función para aprobar solicitud
function aprobarSolicitud(id) {
    Swal.fire({
        title: '¿Aprobar esta solicitud?',
        text: "El restaurante será visible para todos los usuarios",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#27ae60',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, aprobar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Aprobando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/solicitudes/${id}/aprobar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Aprobado!',
                        text: 'La solicitud ha sido aprobada',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo aprobar la solicitud'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al aprobar la solicitud'
                });
            });
        }
    });
}

// Función para rechazar solicitud
function rechazarSolicitud(id) {
    Swal.fire({
        title: '¿Rechazar esta solicitud?',
        text: "El restaurante será eliminado de la base de datos",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Sí, rechazar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Mostrar loading
            Swal.fire({
                title: 'Rechazando...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/solicitudes/${id}/rechazar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Rechazado!',
                        text: 'La solicitud ha sido rechazada',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'No se pudo rechazar la solicitud'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al rechazar la solicitud'
                });
            });
        }
    });
}
