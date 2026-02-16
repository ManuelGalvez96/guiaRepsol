// Validación del formulario de editar restaurante (Gerentes)
document.addEventListener('DOMContentLoaded', function () {
    const descripcionField = document.getElementById('descripcion');
    const charCountSpan = document.getElementById('charCount');

    if (descripcionField && charCountSpan) {
        // Actualizar contador al cargar la página (si hay valor previo)
        charCountSpan.textContent = descripcionField.value.length;

        // Actualizar contador en tiempo real
        descripcionField.addEventListener('input', () => {
            charCountSpan.textContent = descripcionField.value.length;
        });
    }
    
    const form = document.getElementById('formEditarRestaurante');

    // Solo ejecutar si el formulario existe (es decir, si es gerente)
    if (!form) {
        return;
    }

    const eNombre = document.getElementById("error-edit-nombre");
    const eDireccion = document.getElementById("error-edit-direccion");
    const eEmail = document.getElementById("error-edit-email");
    const eTelefono = document.getElementById("error-edit-telefono");
    const eWeb = document.getElementById("error-edit-web");
    const ePrecio = document.getElementById("error-edit-precio");

    const nombreInput = document.getElementById("edit_nombre");
    const direccionInput = document.getElementById("edit_direccion");
    const emailInput = document.getElementById("edit_email");
    const telefonoInput = document.getElementById("edit_telefono");
    const webInput = document.getElementById("edit_web");
    const precioInput = document.getElementById("edit_precio");
    const botonGuardar = document.getElementById("btnGuardarEdicion");

    comprobarBoton();

    nombreInput.onblur = comprobarNombre;
    direccionInput.onblur = comprobarDireccion;
    emailInput.onblur = comprobarEmail;
    telefonoInput.onblur = comprobarTelefono;
    webInput.onblur = comprobarWeb;
    precioInput.onblur = comprobarPrecio;

    nombreInput.oninput = function () {
        comprobarNombre();
    };
    direccionInput.oninput = function () {
        comprobarDireccion();
    };
    emailInput.oninput = function () {
        comprobarEmail();
    };
    telefonoInput.oninput = function () {
        comprobarTelefono();
    };
    webInput.oninput = function () {
        comprobarWeb();
    };
    precioInput.oninput = function () {
        comprobarPrecio();
    };

    function comprobarBoton() {
        const nombre = nombreInput.value.trim();
        const direccion = direccionInput.value.trim();
        const email = emailInput.value.trim();
        const telefono = telefonoInput.value.trim();
        const web = webInput.value.trim();
        const precio = precioInput.value.trim();

        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const urlFormato = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;
        const telefonoFormato = /^[0-9+\-\s()]{9,}$/;

        let nombreValido = nombre !== '' && nombre.length >= 3;
        let direccionValida = direccion !== '' && direccion.length >= 5;
        let emailValido = email !== '' && emailFormato.test(email);

        // Teléfono es opcional, pero si tiene contenido debe ser válido
        let telefonoValido = telefono === '' || telefonoFormato.test(telefono);

        // Web es opcional, pero si tiene contenido debe ser válida
        let webValida = web === '' || urlFormato.test(web);

        let precioValido = precio !== '' && !isNaN(precio) && parseFloat(precio) > 0;

        if (nombreValido && direccionValida && emailValido && telefonoValido && webValida && precioValido) {
            botonGuardar.disabled = false;
            botonGuardar.classList.remove("btn-deshabilitado");
        } else {
            botonGuardar.disabled = true;
            botonGuardar.classList.add("btn-deshabilitado");
        }
    }

    function comprobarNombre() {
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            eNombre.innerText = 'El nombre no puede estar vacío.';
        } else if (nombre.length < 3) {
            eNombre.innerText = 'El nombre debe tener al menos 3 caracteres.';
        } else if (nombre.length > 255) {
            eNombre.innerText = 'El nombre no puede exceder 255 caracteres.';
        } else {
            eNombre.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarDireccion() {
        const direccion = direccionInput.value.trim();

        if (direccion === '') {
            eDireccion.innerText = 'La dirección no puede estar vacía.';
        } else if (direccion.length < 5) {
            eDireccion.innerText = 'La dirección debe tener al menos 5 caracteres.';
        } else {
            eDireccion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarEmail() {
        const email = emailInput.value.trim();
        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            eEmail.innerText = 'El correo electrónico no puede estar vacío.';
        } else if (!emailFormato.test(email)) {
            eEmail.innerText = 'Por favor, introduce un correo electrónico válido.';
        } else {
            eEmail.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarTelefono() {
        const telefono = telefonoInput.value.trim();
        const telefonoFormato = /^[0-9+\-\s()]{9,}$/;

        // El teléfono es opcional
        if (telefono === '') {
            eTelefono.innerText = '';
        } else if (!telefonoFormato.test(telefono)) {
            eTelefono.innerText = 'El teléfono debe tener al menos 9 dígitos y solo puede contener números, espacios, paréntesis, + y -.';
        } else {
            eTelefono.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarWeb() {
        const web = webInput.value.trim();
        const urlFormato = /^(https?:\/\/)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)$/;

        // La web es opcional
        if (web === '') {
            eWeb.innerText = '';
        } else if (!urlFormato.test(web)) {
            eWeb.innerText = 'Por favor, introduce una URL válida (ej: https://ejemplo.com).';
        } else {
            eWeb.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPrecio() {
        const precio = precioInput.value.trim();

        if (precio === '') {
            ePrecio.innerText = 'El precio no puede estar vacío.';
        } else if (isNaN(precio)) {
            ePrecio.innerText = 'El precio debe ser un número válido.';
        } else if (parseFloat(precio) <= 0) {
            ePrecio.innerText = 'El precio debe ser mayor que 0.';
        } else if (parseFloat(precio) > 9999) {
            ePrecio.innerText = 'El precio no puede exceder 9999€.';
        } else {
            ePrecio.innerText = '';
        }
        comprobarBoton();
    }
});
