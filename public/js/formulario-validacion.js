// Validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const descripcion = document.querySelector('textarea[name="descripcion"]');
    const fotoPrincipal = document.getElementById('foto_principal');
    const fotosAdicionales = document.getElementById('fotos_adicionales');
    
    // Actualizar texto de archivo seleccionado
    fotoPrincipal.addEventListener('change', function() {
        if (this.files.length > 0) {
            const container = this.closest('.file-upload');
            const textDiv = container.querySelector('.file-upload-text strong');
            textDiv.textContent = '✓ ' + this.files[0].name;
        }
    });
    
    fotosAdicionales.addEventListener('change', function() {
        if (this.files.length > 0) {
            const container = this.closest('.file-upload');
            const textDiv = container.querySelector('.file-upload-text strong');
            textDiv.textContent = '✓ ' + this.files.length + ' archivo(s) seleccionado(s)';
        }
    });
    
    // Validación al enviar
    form.addEventListener('submit', function(e) {
        let errores = [];
        
        // Validar nombre
        const nombre = document.querySelector('input[name="nombre"]');
        if (!nombre.value.trim()) {
            errores.push('El nombre del negocio es obligatorio');
            nombre.style.borderColor = 'red';
        } else {
            nombre.style.borderColor = '';
        }
        
        // Validar categoría
        const categoria = document.querySelector('select[name="categoria_id"]');
        if (!categoria.value) {
            errores.push('Debe seleccionar una categoría');
            categoria.style.borderColor = 'red';
        } else {
            categoria.style.borderColor = '';
        }
        
        // Validar precio
        const precio = document.querySelector('input[name="precio"]');
        if (!precio.value || parseFloat(precio.value) <= 0) {
            errores.push('El precio debe ser mayor a 0');
            precio.style.borderColor = 'red';
        } else {
            precio.style.borderColor = '';
        }
        
        // Validar descripción (mínimo 100 caracteres)
        if (!descripcion.value.trim() || descripcion.value.trim().length < 100) {
            errores.push('La descripción debe tener al menos 100 caracteres (actualmente: ' + descripcion.value.trim().length + ')');
            descripcion.style.borderColor = 'red';
        } else {
            descripcion.style.borderColor = '';
        }
        
        // Validar dirección
        const direccion = document.querySelector('input[name="direccion"]');
        if (!direccion.value.trim()) {
            errores.push('La dirección es obligatoria');
            direccion.style.borderColor = 'red';
        } else {
            direccion.style.borderColor = '';
        }
        
        // Validar ciudad
        const ciudad = document.querySelector('input[name="ciudad"]');
        if (!ciudad.value.trim()) {
            errores.push('La ciudad es obligatoria');
            ciudad.style.borderColor = 'red';
        } else {
            ciudad.style.borderColor = '';
        }
        
        // Validar provincia
        const provincia = document.querySelector('input[name="provincia"]');
        if (!provincia.value.trim()) {
            errores.push('La provincia es obligatoria');
            provincia.style.borderColor = 'red';
        } else {
            provincia.style.borderColor = '';
        }
        
        // Validar código postal
        const codigoPostal = document.querySelector('input[name="codigo_postal"]');
        if (!codigoPostal.value.trim() || !/^\d{5}$/.test(codigoPostal.value.trim())) {
            errores.push('El código postal debe tener 5 dígitos');
            codigoPostal.style.borderColor = 'red';
        } else {
            codigoPostal.style.borderColor = '';
        }
        
        // Validar comunidad autónoma
        const comunidad = document.querySelector('input[name="comunidad_autonoma"]');
        if (!comunidad.value.trim()) {
            errores.push('La comunidad autónoma es obligatoria');
            comunidad.style.borderColor = 'red';
        } else {
            comunidad.style.borderColor = '';
        }
        
        // Validar email
        const email = document.querySelector('input[name="email"]');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim() || !emailRegex.test(email.value.trim())) {
            errores.push('El email no es válido');
            email.style.borderColor = 'red';
        } else {
            email.style.borderColor = '';
        }
        
        // Validar URL del sitio web (si se proporciona)
        const web = document.querySelector('input[name="web"]');
        if (web.value.trim()) {
            try {
                new URL(web.value.trim());
                web.style.borderColor = '';
            } catch (_) {
                errores.push('La URL del sitio web no es válida');
                web.style.borderColor = 'red';
            }
        }
        
        // Validar foto principal
        if (!fotoPrincipal.files.length) {
            errores.push('Debe subir una foto principal');
            fotoPrincipal.closest('.file-upload').style.borderColor = 'red';
        } else {
            // Validar tamaño (5MB = 5120KB)
            if (fotoPrincipal.files[0].size > 5120 * 1024) {
                errores.push('La foto principal no debe superar los 5MB');
                fotoPrincipal.closest('.file-upload').style.borderColor = 'red';
            } else {
                fotoPrincipal.closest('.file-upload').style.borderColor = '';
            }
        }
        
        // Validar fotos adicionales (máximo 5)
        if (fotosAdicionales.files.length > 5) {
            errores.push('Puede subir máximo 5 fotos adicionales');
            fotosAdicionales.closest('.file-upload').style.borderColor = 'red';
        } else {
            fotosAdicionales.closest('.file-upload').style.borderColor = '';
            // Validar tamaño de cada foto adicional
            for (let i = 0; i < fotosAdicionales.files.length; i++) {
                if (fotosAdicionales.files[i].size > 5120 * 1024) {
                    errores.push('Las fotos adicionales no deben superar los 5MB cada una');
                    fotosAdicionales.closest('.file-upload').style.borderColor = 'red';
                    break;
                }
            }
        }
        
        // Si hay errores, prevenir el envío y mostrar alertas
        if (errores.length > 0) {
            e.preventDefault();
            alert('Por favor, corrija los siguientes errores:\n\n' + errores.join('\n'));
            // Scroll al primer campo con error
            const primerError = document.querySelector('[style*="border-color: red"]');
            if (primerError) {
                primerError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
    
    // Contador de caracteres para la descripción
    descripcion.addEventListener('input', function() {
        const small = this.nextElementSibling;
        const length = this.value.trim().length;
        if (length < 100) {
            small.textContent = 'Mínimo 100 caracteres (' + length + '/100)';
            small.style.color = '#e74c3c';
        } else {
            small.textContent = length + ' caracteres';
            small.style.color = '#27ae60';
        }
    });
});
