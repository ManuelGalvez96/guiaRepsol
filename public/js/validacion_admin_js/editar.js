function initValidacionEditar() {
    console.log('=== initValidacionEditar() ===');
    
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
    const imagenesInput = document.getElementById("imagenes");
    const botonEnviar = document.getElementById("submitBtn");

    console.log('Elementos del formulario encontrados:', {
        nombreInput: !!nombreInput,
        botonEnviar: !!botonEnviar,
        descripcionInput: !!descripcionInput,
        emailInput: !!emailInput
    });

    // Verificar que los elementos existen antes de continuar
    if (!nombreInput || !botonEnviar) {
        console.warn('⚠ Formulario de edición incompleto, saltando validaciones');
        return; // No inicializar si no están los elementos del formulario
    }

    try {
        // Comprobar botón al cargar
        if (typeof comprobarBoton === 'function') comprobarBoton();
        if (typeof comprobarImagenes === 'function') comprobarImagenes();

        // Eventos blur para validación al salir del campo
        if (nombreInput) nombreInput.onblur = comprobarNombre;
        if (descripcionInput) descripcionInput.onblur = comprobarDescripcion;
        if (categoriaInput) categoriaInput.onblur = comprobarCategoria;
        if (ubicacionInput) ubicacionInput.onblur = comprobarUbicacion;
        if (gerenteInput) gerenteInput.onblur = comprobarGerente;
        if (direccionInput) direccionInput.onblur = comprobarDireccion;
        if (telefonoInput) telefonoInput.onblur = comprobarTelefono;
        if (emailInput) emailInput.onblur = comprobarEmail;
        if (webInput) webInput.onblur = comprobarWeb;
        if (precioInput) precioInput.onblur = comprobarPrecio;
        if (solesInput) solesInput.onblur = comprobarSoles;

        // Eventos input para validación en tiempo real
        if (nombreInput) {
            nombreInput.oninput = function() {
                comprobarNombre();
            };
        }
        if (descripcionInput) {
            descripcionInput.oninput = function() {
                comprobarDescripcion();
            };
        }
        if (categoriaInput) {
            categoriaInput.onchange = function() {
                comprobarCategoria();
            };
        }
        if (ubicacionInput) {
            ubicacionInput.onchange = function() {
                comprobarUbicacion();
            };
        }
        if (gerenteInput) {
            gerenteInput.onchange = function() {
                comprobarGerente();
            };
        }
        if (direccionInput) {
            direccionInput.oninput = function() {
                comprobarDireccion();
            };
        }
        if (telefonoInput) {
            telefonoInput.oninput = function() {
                comprobarTelefono();
            };
        }
        if (emailInput) {
            emailInput.oninput = function() {
                comprobarEmail();
            };
        }
        if (webInput) {
            webInput.oninput = function() {
                comprobarWeb();
            };
        }
        if (precioInput) {
            precioInput.oninput = function() {
                comprobarPrecio();
            };
        }
        if (solesInput) {
            solesInput.oninput = function() {
                comprobarSoles();
            };
        }
        console.log('✓ Validaciones de edición inicializadas correctamente');
    } catch (e) {
        console.error('✗ Error al inicializar validaciones:', e);
    }


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

        const camposObligatoriosCompletos = 
            nombre !== '' &&
            descripcion !== '' &&
            categoria !== '' &&
            ubicacion !== '' &&
            gerente !== '' &&
            direccion !== '' &&
            email !== '' &&
            precio !== '';

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
            eNombre.innerText = 'El nombre del restaurante es obligatorio.';
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
            eCategoria.innerText = 'Debes seleccionar una categoría.';
        } else {
            eCategoria.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarUbicacion() {
        const ubicacion = ubicacionInput.value.trim();

        if (ubicacion === '') {
            eUbicacion.innerText = 'Debes seleccionar una ubicación.';
        } else {
            eUbicacion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarGerente() {
        const gerente = gerenteInput.value.trim();

        if (gerente === '') {
            eGerente.innerText = 'Debes seleccionar un gerente.';
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
        } else if (direccion.length > 255) {
            eDireccion.innerText = 'La dirección no puede exceder 255 caracteres.';
        } else {
            eDireccion.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarTelefono() {
        const telefono = telefonoInput.value.trim();
        const telefonoFormato = /^[0-9]{9,15}$/;

        // El teléfono es opcional, pero si se llena debe ser válido
        if (telefono !== '' && !telefonoFormato.test(telefono)) {
            eTelefono.innerText = 'El teléfono debe tener entre 9 y 15 dígitos.';
        } else {
            eTelefono.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarEmail() {
        const email = emailInput.value.trim();
        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email === '') {
            eEmail.innerText = 'El correo electrónico es obligatorio.';
        } else if (!emailFormato.test(email)) {
            eEmail.innerText = 'Por favor, introduce un correo electrónico válido.';
        } else {
            eEmail.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarWeb() {
        const web = webInput.value.trim();
        const webFormato = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;

        // La web es opcional, pero si se llena debe ser válida
        if (web !== '' && !webFormato.test(web)) {
            eWeb.innerText = 'Por favor, introduce una URL válida.';
        } else {
            eWeb.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPrecio() {
        const precio = precioInput.value.trim();
        const precioNum = parseFloat(precio);

        if (precio === '') {
            ePrecio.innerText = 'El precio promedio es obligatorio.';
        } else if (isNaN(precioNum)) {
            ePrecio.innerText = 'El precio debe ser un número válido.';
        } else if (precioNum < 0.01) {
            ePrecio.innerText = 'El precio debe ser mayor a 0.';
        } else if (precioNum > 9999.99) {
            ePrecio.innerText = 'El precio no puede exceder 9999.99€.';
        } else {
            ePrecio.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarSoles() {
        const soles = solesInput.value.trim();
        const solesNum = parseInt(soles);

        // Los soles son opcionales, pero si se llenan deben estar entre 0 y 3
        if (soles !== '' && (isNaN(solesNum) || solesNum < 0 || solesNum > 3)) {
            eSoles.innerText = 'Los soles Repsol deben estar entre 0 y 3.';
        } else {
            eSoles.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarImagenes() {
        // Contar imágenes existentes en el DOM
        const imagenesExistentes = document.querySelectorAll('.current-image-item').length;
        
        // Contar imágenes marcadas para eliminar
        const imagenesAEliminar = (window.imagenesAEliminar || []).length;
        
        // Contar nuevas imágenes seleccionadas
        const nuevasImagenes = imagenesInput && imagenesInput.files ? imagenesInput.files.length : 0;
        
        // Calcular total de imágenes que quedarán
        const totalImagenes = (imagenesExistentes - imagenesAEliminar) + nuevasImagenes;
        
        if (totalImagenes === 0) {
            eImagenes.innerText = 'Debe haber al menos una imagen del restaurante.';
        } else {
            eImagenes.innerText = '';
        }
        comprobarBoton();
    }

    // Hacer la función global para que pueda ser llamada desde admin_edit.js
    window.comprobarImagenes = comprobarImagenes;
}

// Exportar la función globalmente para uso en modales
window.initValidacionEditar = initValidacionEditar;

// Ejecutar automáticamente en window.onload para páginas completas (edit.blade.php)
window.onload = initValidacionEditar;
