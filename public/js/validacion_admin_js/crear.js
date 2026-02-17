function initValidacionCrear() {
    // Elementos de error
    const eNombre = document.getElementById("error-nombre");
    const eDescripcion = document.getElementById("error-descripcion");
    const eCategoria = document.getElementById("error-categoria");
    const eUbicacion = document.getElementById("error-ubicacion");
    const eGerente = document.getElementById("error-gerente");
    const eDireccion = document.getElementById("error-direccion");
    const eTelefono = document.getElementById("error-telefono");
    const eEmail = document.getElementById("error-email");
    const eWeb = document.getElementById("error-web");
    const ePrecio = document.getElementById("error-precio");
    const eSoles = document.getElementById("error-soles");
    const eValoracion = document.getElementById("error-valoracion");
    const eImagenes = document.getElementById("error-imagenes");

    // Inputs del formulario
    const nombreInput = document.getElementById("nombre");
    const descripcionInput = document.getElementById("descripcion");
    const categoriaInput = document.getElementById("categoria_id");
    const ubicacionInput = document.getElementById("ubicacion_id");
    const gerenteInput = document.getElementById("user_id");
    const direccionInput = document.getElementById("direccion");
    const telefonoInput = document.getElementById("telefono");
    const emailInput = document.getElementById("email");
    const webInput = document.getElementById("web");
    const precioInput = document.getElementById("precio");
    const solesInput = document.getElementById("soles");
    const valoracionInput = document.getElementById("valoracion_promedio");
    const imagenesInput = document.getElementById("imagenes");
    const botonEnviar = document.getElementById("submitBtn");

    // Verificar que los elementos existen antes de continuar
    if (!nombreInput || !botonEnviar) {
        return; // No inicializar si no están los elementos del formulario
    }

    // Comprobar botón al cargar
    comprobarBoton();

    // Eventos blur para validación al salir del campo
    nombreInput.onblur = comprobarNombre;
    descripcionInput.onblur = comprobarDescripcion;
    categoriaInput.onblur = comprobarCategoria;
    ubicacionInput.onblur = comprobarUbicacion;
    gerenteInput.onblur = comprobarGerente;
    direccionInput.onblur = comprobarDireccion;
    telefonoInput.onblur = comprobarTelefono;
    emailInput.onblur = comprobarEmail;
    webInput.onblur = comprobarWeb;
    precioInput.onblur = comprobarPrecio;
    solesInput.onblur = comprobarSoles;
    valoracionInput.onblur = comprobarValoracion;

    imagenesInput.onclick = function () {
        comprobarImagenes();
    };
    // Eventos oninput para validación en tiempo real
    nombreInput.oninput = function () {
        comprobarNombre();
    };

    descripcionInput.oninput = function () {
        comprobarDescripcion();
    };

    categoriaInput.onchange = function () {
        comprobarCategoria();
    };

    ubicacionInput.onchange = function () {
        comprobarUbicacion();
    };

    gerenteInput.onchange = function () {
        comprobarGerente();
    };

    direccionInput.oninput = function () {
        comprobarDireccion();
    };

    telefonoInput.oninput = function () {
        comprobarTelefono();
    };

    emailInput.oninput = function () {
        comprobarEmail();
    };

    webInput.oninput = function () {
        comprobarWeb();
    };

    precioInput.oninput = function () {
        comprobarPrecio();
    };

    solesInput.oninput = function () {
        comprobarSoles();
    };

    valoracionInput.oninput = function () {
        comprobarValoracion();
    };


    function comprobarBoton() {
        // Verificar que todos los spans de error estén vacíos
        const todosLosSpansVacios =
            eNombre.innerText === '' &&
            eDescripcion.innerText === '' &&
            eCategoria.innerText === '' &&
            eUbicacion.innerText === '' &&
            eGerente.innerText === '' &&
            eDireccion.innerText === '' &&
            eTelefono.innerText === '' &&
            eEmail.innerText === '' &&
            eWeb.innerText === '' &&
            ePrecio.innerText === '' &&
            eSoles.innerText === '' &&
            eValoracion.innerText === '' &&
            eImagenes.innerText === '';

        // Verificar que los campos obligatorios estén completos
        const nombre = nombreInput.value.trim();
        const descripcion = descripcionInput.value.trim();
        const categoria = categoriaInput.value.trim();
        const ubicacion = ubicacionInput.value.trim();
        const gerente = gerenteInput.value.trim();
        const direccion = direccionInput.value.trim();
        const email = emailInput.value.trim();
        const precio = precioInput.value.trim();
        const imagenes = imagenesInput.files.length;

        const camposObligatoriosCompletos =
            nombre !== '' &&
            descripcion !== '' &&
            categoria !== '' &&
            ubicacion !== '' &&
            gerente !== '' &&
            direccion !== '' &&
            email !== '' &&
            precio !== '' &&
            imagenes > 0;

        if (todosLosSpansVacios && camposObligatoriosCompletos) {
            botonEnviar.disabled = false;
            botonEnviar.removeAttribute('style');
        } else {
            botonEnviar.disabled = true;
            botonEnviar.style.cssText = 'opacity: 0.5; cursor: not-allowed;';
        }
    }

    function comprobarNombre() {
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            eNombre.innerText = 'El nombre es obligatorio.';
        } else if (nombre.length < 3) {
            eNombre.innerText = 'El nombre debe tener al menos 3 caracteres.';
        } else if (nombre.length > 255) {
            eNombre.innerText = 'El nombre no puede exceder 255 caracteres.';
        } else {
            eNombre.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarDescripcion() {
        const descripcion = descripcionInput.value.trim();

        // La descripción es obligatoria y debe tener entre 100 y 1000 caracteres
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

    function comprobarCategoria() {
        const categoria = categoriaInput.value.trim();

        if (categoria === '') {
            eCategoria.innerText = 'Debe seleccionar una categoría.';
        } else {
            eCategoria.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarUbicacion() {
        const ubicacion = ubicacionInput.value.trim();

        if (ubicacion === '') {
            eUbicacion.innerText = 'Debe seleccionar una ubicación.';
        } else {
            eUbicacion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarGerente() {
        const gerente = gerenteInput.value.trim();

        if (gerente === '') {
            eGerente.innerText = 'Debe seleccionar un gerente.';
        } else {
            eGerente.innerText = '';
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

    function comprobarTelefono() {
        const telefono = telefonoInput.value.trim();

        // El teléfono es opcional
        if (telefono !== '') {
            const soloNumeros = telefono.replace(/\D/g, ''); // Eliminar todo excepto dígitos
            if (soloNumeros.length < 9 || soloNumeros.length > 15) {
                eTelefono.innerText = 'El teléfono debe tener entre 9 y 15 dígitos.';
            } else {
                eTelefono.innerText = '';
            }
        } else {
            eTelefono.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarEmail() {
        const email = emailInput.value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            eEmail.innerText = 'El email es obligatorio.';
        } else if (!emailRegex.test(email)) {
            eEmail.innerText = 'El email debe tener un formato válido.';
        } else {
            eEmail.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarWeb() {
        const web = webInput.value.trim();

        // La web es opcional
        if (web !== '') {
            try {
                new URL(web);
                eWeb.innerText = '';
            } catch (error) {
                eWeb.innerText = 'La dirección web debe ser una URL válida (ej: https://ejemplo.com).';
            }
        } else {
            eWeb.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPrecio() {
        const precio = precioInput.value.trim();

        if (precio === '') {
            ePrecio.innerText = 'El precio es obligatorio.';
        } else {
            const precioNum = parseFloat(precio);
            if (isNaN(precioNum)) {
                ePrecio.innerText = 'El precio debe ser un número válido.';
            } else if (precioNum < 0.01) {
                ePrecio.innerText = 'El precio debe ser mayor a 0.';
            } else if (precioNum > 9999.99) {
                ePrecio.innerText = 'El precio no puede superar 9999.99€.';
            } else {
                ePrecio.innerText = '';
            }
        }
        comprobarBoton();
    }

    function comprobarSoles() {
        const soles = solesInput.value.trim();

        // Los soles son opcionales
        if (soles !== '') {
            const solesNum = parseInt(soles);
            if (isNaN(solesNum) || solesNum < 0 || solesNum > 3) {
                eSoles.innerText = 'Los soles deben estar entre 0 y 3.';
            } else {
                eSoles.innerText = '';
            }
        } else {
            eSoles.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarValoracion() {
        const valoracion = valoracionInput.value.trim();

        // La valoración es opcional
        if (valoracion !== '') {
            const valoracionNum = parseFloat(valoracion);
            if (isNaN(valoracionNum) || valoracionNum < 0 || valoracionNum > 5) {
                eValoracion.innerText = 'La valoración debe estar entre 0 y 5.';
            } else {
                eValoracion.innerText = '';
            }
        } else {
            eValoracion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarImagenes() {

        const nuevasImagenes = imagenesInput.files;

        // Calcular total de imágenes que quedarán
        const totalImagenes = nuevasImagenes;

        if (totalImagenes === 0) {
            eImagenes.innerText = 'Debe haber al menos una imagen del restaurante.';
        } else if (totalImagenes >= 9) {
            eImagenes.innerText = 'No puede haber más de 9 imágenes del restaurante.';
        } else {
            eImagenes.innerText = '';

        }
        comprobarBoton();
    }

    // Exponer para el onchange inline y otros scripts
    window.comprobarImagenes = comprobarImagenes;
}
if (document.readyState === 'loading') {
    const prevOnload = window.onload;
    window.onload = function (event) {
        if (typeof prevOnload === 'function') {
            prevOnload(event);
        }
        initValidacionCrear();
    };
} else {
    // Si el DOM ya está cargado, ejecutar inmediatamente
    initValidacionCrear();
}

// Exportar para uso en modal
window.initValidacionCrear = initValidacionCrear;
