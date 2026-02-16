// Validación del formulario de dar a conocer negocio
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formCrearNegocio');
    if (!form) return;

    // Campos del formulario
    const nombreInput = document.querySelector('[name="nombre"]');
    const categoriaSelect = document.querySelector('[name="categoria_id"]');
    const precioInput = document.querySelector('[name="precio"]');
    const descripcionTextarea = document.querySelector('[name="descripcion"]');
    const direccionInput = document.querySelector('[name="direccion"]');
    const ciudadInput = document.querySelector('[name="ciudad"]');
    const provinciaInput = document.querySelector('[name="provincia"]');
    const codigoPostalInput = document.querySelector('[name="codigo_postal"]');
    const comunidadInput = document.querySelector('[name="comunidad_autonoma"]');
    const emailInput = document.querySelector('[name="email"]');
    const telefonoInput = document.querySelector('[name="telefono"]');
    const webInput = document.querySelector('[name="web"]');
    const fotoPrincipalInput = document.querySelector('[name="foto_principal"]');
    const btnSubmit = document.querySelector('button[type="submit"]');

    // Contador de caracteres para descripción
    const contadorDescripcion = document.createElement('small');
    contadorDescripcion.style.cssText = 'display: block; margin-top: 5px; color: #666;';
    if (descripcionTextarea) {
        descripcionTextarea.parentNode.appendChild(contadorDescripcion);
        actualizarContador();
    }

    // Event listeners
    if (nombreInput) nombreInput.addEventListener('blur', validarNombre);
    if (categoriaSelect) categoriaSelect.addEventListener('change', validarCategoria);
    if (precioInput) precioInput.addEventListener('blur', validarPrecio);
    if (descripcionTextarea) {
        descripcionTextarea.addEventListener('blur', validarDescripcion);
        descripcionTextarea.addEventListener('input', actualizarContador);
    }
    if (direccionInput) direccionInput.addEventListener('blur', validarDireccion);
    if (ciudadInput) ciudadInput.addEventListener('blur', validarCiudad);
    if (provinciaInput) provinciaInput.addEventListener('blur', validarProvincia);
    if (codigoPostalInput) codigoPostalInput.addEventListener('blur', validarCodigoPostal);
    if (comunidadInput) comunidadInput.addEventListener('blur', validarComunidad);
    if (emailInput) emailInput.addEventListener('blur', validarEmail);
    if (telefonoInput) telefonoInput.addEventListener('blur', validarTelefono);
    if (webInput) webInput.addEventListener('blur', validarWeb);
    if (fotoPrincipalInput) fotoPrincipalInput.addEventListener('change', validarFotoPrincipal);

    // Validar al enviar
    form.addEventListener('submit', function(e) {
        let esValido = true;
        
        esValido = validarNombre() && esValido;
        esValido = validarCategoria() && esValido;
        esValido = validarPrecio() && esValido;
        esValido = validarDescripcion() && esValido;
        esValido = validarDireccion() && esValido;
        esValido = validarCiudad() && esValido;
        esValido = validarProvincia() && esValido;
        esValido = validarCodigoPostal() && esValido;
        esValido = validarComunidad() && esValido;
        esValido = validarEmail() && esValido;
        esValido = validarTelefono() && esValido;
        esValido = validarWeb() && esValido;
        esValido = validarFotoPrincipal() && esValido;

        if (!esValido) {
            e.preventDefault();
            mostrarAlerta('Por favor, corrige los errores antes de enviar el formulario.');
        }
    });

    // Funciones de validación
    function validarNombre() {
        const valor = nombreInput.value.trim();
        if (valor === '') {
            mostrarError(nombreInput, 'El nombre del negocio es obligatorio');
            return false;
        }
        if (valor.length < 3) {
            mostrarError(nombreInput, 'El nombre debe tener al menos 3 caracteres');
            return false;
        }
        if (valor.length > 255) {
            mostrarError(nombreInput, 'El nombre no puede exceder 255 caracteres');
            return false;
        }
        limpiarError(nombreInput);
        return true;
    }

    function validarCategoria() {
        const valor = categoriaSelect.value;
        if (valor === '' || valor === '0') {
            mostrarError(categoriaSelect, 'Debes seleccionar una categoría');
            return false;
        }
        limpiarError(categoriaSelect);
        return true;
    }

    function validarPrecio() {
        const valor = precioInput.value.trim();
        if (valor === '') {
            mostrarError(precioInput, 'El precio es obligatorio');
            return false;
        }
        const precio = parseFloat(valor);
        if (isNaN(precio) || precio <= 0) {
            mostrarError(precioInput, 'El precio debe ser mayor que 0');
            return false;
        }
        if (precio > 9999.99) {
            mostrarError(precioInput, 'El precio no puede exceder 9999.99€');
            return false;
        }
        limpiarError(precioInput);
        return true;
    }

    function validarDescripcion() {
        const valor = descripcionTextarea.value.trim();
        if (valor === '') {
            mostrarError(descripcionTextarea, 'La descripción es obligatoria');
            return false;
        }
        if (valor.length < 100) {
            mostrarError(descripcionTextarea, 'La descripción debe tener al menos 100 caracteres');
            return false;
        }
        if (valor.length > 1000) {
            mostrarError(descripcionTextarea, 'La descripción no puede exceder 1000 caracteres');
            return false;
        }
        limpiarError(descripcionTextarea);
        return true;
    }

    function validarDireccion() {
        const valor = direccionInput.value.trim();
        if (valor === '') {
            mostrarError(direccionInput, 'La dirección es obligatoria');
            return false;
        }
        if (valor.length < 5) {
            mostrarError(direccionInput, 'La dirección debe tener al menos 5 caracteres');
            return false;
        }
        limpiarError(direccionInput);
        return true;
    }

    function validarCiudad() {
        const valor = ciudadInput.value.trim();
        if (valor === '') {
            mostrarError(ciudadInput, 'La ciudad es obligatoria');
            return false;
        }
        limpiarError(ciudadInput);
        return true;
    }

    function validarProvincia() {
        const valor = provinciaInput.value.trim();
        if (valor === '') {
            mostrarError(provinciaInput, 'La provincia es obligatoria');
            return false;
        }
        limpiarError(provinciaInput);
        return true;
    }

    function validarCodigoPostal() {
        const valor = codigoPostalInput.value.trim();
        if (valor === '') {
            mostrarError(codigoPostalInput, 'El código postal es obligatorio');
            return false;
        }
        const regex = /^\d{5}$/;
        if (!regex.test(valor)) {
            mostrarError(codigoPostalInput, 'El código postal debe tener 5 dígitos');
            return false;
        }
        limpiarError(codigoPostalInput);
        return true;
    }

    function validarComunidad() {
        const valor = comunidadInput.value.trim();
        if (valor === '') {
            mostrarError(comunidadInput, 'La comunidad autónoma es obligatoria');
            return false;
        }
        limpiarError(comunidadInput);
        return true;
    }

    function validarEmail() {
        const valor = emailInput.value.trim();
        if (valor === '') {
            mostrarError(emailInput, 'El email es obligatorio');
            return false;
        }
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(valor)) {
            mostrarError(emailInput, 'El email no es válido');
            return false;
        }
        limpiarError(emailInput);
        return true;
    }

    function validarTelefono() {
        const valor = telefonoInput.value.trim();
        // El teléfono es opcional
        if (valor === '') {
            limpiarError(telefonoInput);
            return true;
        }
        const regex = /^[0-9+\-\s()]{9,}$/;
        if (!regex.test(valor)) {
            mostrarError(telefonoInput, 'El teléfono debe tener al menos 9 dígitos');
            return false;
        }
        limpiarError(telefonoInput);
        return true;
    }

    function validarWeb() {
        const valor = webInput.value.trim();
        // La web es opcional
        if (valor === '') {
            limpiarError(webInput);
            return true;
        }
        const regex = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
        if (!regex.test(valor)) {
            mostrarError(webInput, 'La URL no es válida (ej: https://ejemplo.com)');
            return false;
        }
        limpiarError(webInput);
        return true;
    }

    function validarFotoPrincipal() {
        if (!fotoPrincipalInput.files || fotoPrincipalInput.files.length === 0) {
            mostrarError(fotoPrincipalInput, 'La foto principal es obligatoria');
            return false;
        }
        const archivo = fotoPrincipalInput.files[0];
        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!tiposPermitidos.includes(archivo.type)) {
            mostrarError(fotoPrincipalInput, 'Solo se permiten imágenes JPG, PNG, GIF o WEBP');
            return false;
        }
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (archivo.size > maxSize) {
            mostrarError(fotoPrincipalInput, 'La imagen no puede superar 5MB');
            return false;
        }
        limpiarError(fotoPrincipalInput);
        return true;
    }

    function actualizarContador() {
        const longitud = descripcionTextarea.value.length;
        contadorDescripcion.textContent = `${longitud} caracteres (mínimo 100)`;
        contadorDescripcion.style.color = longitud >= 100 ? '#28a745' : '#666';
    }

    function mostrarError(elemento, mensaje) {
        limpiarError(elemento);
        elemento.classList.add('error');
        const errorDiv = document.createElement('small');
        errorDiv.className = 'error-message';
        errorDiv.style.cssText = 'color: #e74c3c; display: block; margin-top: 5px; font-size: 13px;';
        errorDiv.textContent = mensaje;
        elemento.parentNode.appendChild(errorDiv);
    }

    function limpiarError(elemento) {
        elemento.classList.remove('error');
        const errorExistente = elemento.parentNode.querySelector('.error-message');
        if (errorExistente) {
            errorExistente.remove();
        }
    }

    function mostrarAlerta(mensaje) {
        alert(mensaje);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});
