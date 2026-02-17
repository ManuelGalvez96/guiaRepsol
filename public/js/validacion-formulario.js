window.onload = function () {
    // Elementos de error
    const eNombre = document.getElementById("error-nombre");
    const eCategoria = document.getElementById("error-categoria");
    const ePrecio = document.getElementById("error-precio");
    const eDescripcion = document.getElementById("error-descripcion");
    const eDireccion = document.getElementById("error-direccion");
    const eCiudad = document.getElementById("error-ciudad");
    const eProvincia = document.getElementById("error-provincia");
    const eCodigoPostal = document.getElementById("error-codigo-postal");
    const eComunidad = document.getElementById("error-comunidad");
    const eEmail = document.getElementById("error-email");
    const eTelefono = document.getElementById("error-telefono");
    const eWeb = document.getElementById("error-web");
    const eFotoPrincipal = document.getElementById("error-foto-principal");

    // Inputs del formulario
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
    const botonEnviar = document.getElementById('btnEnviarFormulario');

    // Contador de descripción
    const contadorDescripcion = document.createElement('small');
    contadorDescripcion.style.cssText = 'display: block; margin-top: 5px; color: #666;';
    if (descripcionTextarea) {
        descripcionTextarea.parentNode.appendChild(contadorDescripcion);
        actualizarContador();
    }

    comprobarBoton();

    // Event listeners onblur
    if (nombreInput) nombreInput.onblur = comprobarNombre;
    if (categoriaSelect) categoriaSelect.onblur = comprobarCategoria;
    if (precioInput) precioInput.onblur = comprobarPrecio;
    if (descripcionTextarea) descripcionTextarea.onblur = comprobarDescripcion;
    if (direccionInput) direccionInput.onblur = comprobarDireccion;
    if (ciudadInput) ciudadInput.onblur = comprobarCiudad;
    if (provinciaInput) provinciaInput.onblur = comprobarProvincia;
    if (codigoPostalInput) codigoPostalInput.onblur = comprobarCodigoPostal;
    if (comunidadInput) comunidadInput.onblur = comprobarComunidad;
    if (emailInput) emailInput.onblur = comprobarEmail;
    if (telefonoInput) telefonoInput.onblur = comprobarTelefono;
    if (webInput) webInput.onblur = comprobarWeb;
    if (fotoPrincipalInput) fotoPrincipalInput.onchange = comprobarFotoPrincipal;

    // Event listeners oninput
    if (nombreInput) {
        nombreInput.oninput = function() {
            comprobarNombre();
        };
    }
    if (categoriaSelect) {
        categoriaSelect.onchange = function() {
            comprobarCategoria();
        };
    }
    if (precioInput) {
        precioInput.oninput = function() {
            comprobarPrecio();
        };
    }
    if (descripcionTextarea) {
        descripcionTextarea.oninput = function() {
            comprobarDescripcion();
            actualizarContador();
        };
    }
    if (direccionInput) {
        direccionInput.oninput = function() {
            comprobarDireccion();
        };
    }
    if (ciudadInput) {
        ciudadInput.oninput = function() {
            comprobarCiudad();
        };
    }
    if (provinciaInput) {
        provinciaInput.oninput = function() {
            comprobarProvincia();
        };
    }
    if (codigoPostalInput) {
        codigoPostalInput.oninput = function() {
            comprobarCodigoPostal();
        };
    }
    if (comunidadInput) {
        comunidadInput.oninput = function() {
            comprobarComunidad();
        };
    }
    if (emailInput) {
        emailInput.oninput = function() {
            comprobarEmail();
        };
    }
    if (telefonoInput) {
        telefonoInput.oninput = function() {
            comprobarTelefono();
        };
    }
    if (webInput) {
        webInput.oninput = function() {
            comprobarWeb();
        };
    }

    function comprobarBoton() {
        // Verificar que no haya errores mostrados (trim para eliminar espacios)
        const hayErrores = (eNombre && eNombre.innerText.trim() !== '') || 
                          (eCategoria && eCategoria.innerText.trim() !== '') || 
                          (ePrecio && ePrecio.innerText.trim() !== '') || 
                          (eDescripcion && eDescripcion.innerText.trim() !== '') || 
                          (eDireccion && eDireccion.innerText.trim() !== '') || 
                          (eCiudad && eCiudad.innerText.trim() !== '') || 
                          (eProvincia && eProvincia.innerText.trim() !== '') || 
                          (eCodigoPostal && eCodigoPostal.innerText.trim() !== '') || 
                          (eComunidad && eComunidad.innerText.trim() !== '') || 
                          (eEmail && eEmail.innerText.trim() !== '') || 
                          (eTelefono && eTelefono.innerText.trim() !== '') || 
                          (eWeb && eWeb.innerText.trim() !== '') || 
                          (eFotoPrincipal && eFotoPrincipal.innerText.trim() !== '');

        // Verificar que todos los campos obligatorios estén llenos
        const nombre = nombreInput ? nombreInput.value.trim() : '';
        const categoria = categoriaSelect ? categoriaSelect.value : '';
        const precio = precioInput ? precioInput.value.trim() : '';
        const descripcion = descripcionTextarea ? descripcionTextarea.value.trim() : '';
        const direccion = direccionInput ? direccionInput.value.trim() : '';
        const ciudad = ciudadInput ? ciudadInput.value.trim() : '';
        const provincia = provinciaInput ? provinciaInput.value.trim() : '';
        const codigoPostal = codigoPostalInput ? codigoPostalInput.value.trim() : '';
        const comunidad = comunidadInput ? comunidadInput.value.trim() : '';
        const email = emailInput ? emailInput.value.trim() : '';
        const fotoPrincipal = fotoPrincipalInput ? fotoPrincipalInput.files.length > 0 : false;

        const todoRellenado = nombre !== '' && 
                             categoria !== '' && categoria !== '0' &&
                             precio !== '' && 
                             descripcion !== '' && 
                             direccion !== '' && 
                             ciudad !== '' && 
                             provincia !== '' && 
                             codigoPostal !== '' && 
                             comunidad !== '' && 
                             email !== '' && 
                             fotoPrincipal;

        // Habilitar el botón solo si todo está rellenado y no hay errores
        if (todoRellenado && !hayErrores) {
            botonEnviar.disabled = false;
            botonEnviar.removeAttribute('style'); // Quitar estilos inline
        } else {
            botonEnviar.disabled = true;
            botonEnviar.style.cssText = 'opacity: 0.5; cursor: not-allowed;'; // Aplicar estilos de deshabilitado
        }
    }

    function comprobarNombre() {
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            eNombre.innerText = 'El nombre del negocio es obligatorio.';
        } else if (nombre.length < 3) {
            eNombre.innerText = 'El nombre debe tener al menos 3 caracteres.';
        } else if (nombre.length > 255) {
            eNombre.innerText = 'El nombre no puede exceder 255 caracteres.';
        } else {
            eNombre.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarCategoria() {
        const categoria = categoriaSelect.value;

        if (categoria === '' || categoria === '0') {
            eCategoria.innerText = 'Debes seleccionar una categoría.';
        } else {
            eCategoria.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPrecio() {
        const precio = precioInput.value.trim();

        if (precio === '') {
            ePrecio.innerText = 'El precio es obligatorio.';
        } else if (isNaN(precio) || parseFloat(precio) <= 0) {
            ePrecio.innerText = 'El precio debe ser mayor que 0.';
        } else if (parseFloat(precio) > 9999.99) {
            ePrecio.innerText = 'El precio no puede exceder 9999.99€.';
        } else {
            ePrecio.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarDescripcion() {
        const descripcion = descripcionTextarea.value.trim();

        if (descripcion === '') {
            eDescripcion.innerText = 'La descripción es obligatoria.';
        } else if (descripcion.length < 100) {
            eDescripcion.innerText = 'La descripción debe tener al menos 100 caracteres.';
        } else if (descripcion.length > 1000) {
            eDescripcion.innerText = 'La descripción no puede exceder 1000 caracteres.';
        } else {
            eDescripcion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarDireccion() {
        const direccion = direccionInput.value.trim();

        if (direccion === '') {
            eDireccion.innerText = 'La dirección es obligatoria.';
        } else if (direccion.length < 5) {
            eDireccion.innerText = 'La dirección debe tener al menos 5 caracteres.';
        } else {
            eDireccion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarCiudad() {
        const ciudad = ciudadInput.value.trim();

        if (ciudad === '') {
            eCiudad.innerText = 'La ciudad es obligatoria.';
        } else {
            eCiudad.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarProvincia() {
        const provincia = provinciaInput.value.trim();

        if (provincia === '') {
            eProvincia.innerText = 'La provincia es obligatoria.';
        } else {
            eProvincia.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarCodigoPostal() {
        const codigoPostal = codigoPostalInput.value.trim();
        const codigoPostalFormato = /^\d{5}$/;

        if (codigoPostal === '') {
            eCodigoPostal.innerText = 'El código postal es obligatorio.';
        } else if (!codigoPostalFormato.test(codigoPostal)) {
            eCodigoPostal.innerText = 'El código postal debe tener 5 dígitos.';
        } else {
            eCodigoPostal.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarComunidad() {
        const comunidad = comunidadInput.value.trim();

        if (comunidad === '') {
            eComunidad.innerText = 'La comunidad autónoma es obligatoria.';
        } else {
            eComunidad.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarEmail() {
        const email = emailInput.value.trim();
        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            eEmail.innerText = 'El email es obligatorio.';
        } else if (!emailFormato.test(email)) {
            eEmail.innerText = 'El email no es válido.';
        } else {
            eEmail.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarTelefono() {
        const telefono = telefonoInput.value.trim();
        const telefonoFormato = /^[0-9+\-\s()]{9,}$/;

        if (telefono === '') {
            eTelefono.innerText = '';
        } else if (!telefonoFormato.test(telefono)) {
            eTelefono.innerText = 'El teléfono debe tener al menos 9 dígitos.';
        } else {
            eTelefono.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarWeb() {
        const web = webInput.value.trim();
        const webFormato = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;

        if (web === '') {
            eWeb.innerText = '';
        } else if (!webFormato.test(web)) {
            eWeb.innerText = 'La URL no es válida (ej: https://ejemplo.com).';
        } else {
            eWeb.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarFotoPrincipal() {
        if (!fotoPrincipalInput.files || fotoPrincipalInput.files.length === 0) {
            eFotoPrincipal.innerText = 'La foto principal es obligatoria.';
            comprobarBoton();
            return;
        }

        const archivo = fotoPrincipalInput.files[0];
        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        
        if (!tiposPermitidos.includes(archivo.type)) {
            eFotoPrincipal.innerText = 'Solo se permiten imágenes JPG, PNG, GIF o WEBP.';
        } else if (archivo.size > 5 * 1024 * 1024) {
            eFotoPrincipal.innerText = 'La imagen no puede superar 5MB.';
        } else {
            eFotoPrincipal.innerText = '';
        }
        comprobarBoton();
    }

    function actualizarContador() {
        const longitud = descripcionTextarea.value.length;
        contadorDescripcion.textContent = `${longitud} / 1000 caracteres (mínimo 100)`;
        contadorDescripcion.style.color = longitud >= 100 ? '#28a745' : '#666';
    }
};

// Inicializar menú móvil
initializeMobileMenu();
