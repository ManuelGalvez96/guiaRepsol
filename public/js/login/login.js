window.onload = function () {
    const eUsuario = document.getElementById("error-usuario");
    const ePassword = document.getElementById("error-contrasena");

    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const botonEnviar = document.getElementById("boton_enviar");

    comprobarBoton(); 

    emailInput.onblur = comprobarEmail;
    passwordInput.onblur = comprobarPassword;
    emailInput.oninput = function() {
        comprobarEmail();
    };
    passwordInput.oninput = function() {
        comprobarPassword();
    };

    function comprobarBoton() {
        const email = emailInput.value.trim();
        const contrasena = passwordInput.value.trim();
        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        let emailValido = email !== '' && emailFormato.test(email);
        let contrasenaValida = contrasena !== '' && contrasena.length >= 6;

        if (emailValido && contrasenaValida) {
            botonEnviar.disabled = false;
            botonEnviar.classList.remove("btn-login-desabilitado");
        } else {
            botonEnviar.disabled = true;
            botonEnviar.classList.add("btn-login-desabilitado");
        }
    }

    function comprobarEmail() {
        const email = emailInput.value.trim();
        const emailformato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '') {
            eUsuario.innerText = 'El correo electrónico no puede estar vacío.';
        } else if (!emailformato.test(email)) {
            eUsuario.innerText = 'Por favor, introduce un correo electrónico válido.';
        } else {
            eUsuario.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPassword() {
        const contrasena = passwordInput.value.trim();
        
        if (contrasena === '') {
            ePassword.innerText = 'La contraseña no puede estar vacía.';
        } else if (contrasena.length < 6) {
            ePassword.innerText = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            ePassword.innerText = ''; 
        }
        comprobarBoton();
    }
};
