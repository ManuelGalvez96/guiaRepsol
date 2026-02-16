window.onload = function () {
    const eNombre = document.getElementById("error-nombre");
    const eApellidos = document.getElementById("error-apellidos");
    const eEmail = document.getElementById("error-email");
    const ePassword = document.getElementById("error-password");
    const ePasswordConfirmation = document.getElementById("error-password-confirmation");

    const nombreInput = document.getElementById("name");
    const apellidosInput = document.getElementById("apellidos");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const passwordConfirmationInput = document.getElementById("password_confirmation");
    const botonEnviar = document.getElementById("boton_enviar");

    comprobarBoton();

    nombreInput.onblur = comprobarNombre;
    apellidosInput.onblur = comprobarApellidos;
    emailInput.onblur = comprobarEmail;
    passwordInput.onblur = comprobarPassword;
    passwordConfirmationInput.onblur = comprobarPasswordConfirmation;

    nombreInput.oninput = function() {
        comprobarNombre();
    };
    apellidosInput.oninput = function() {
        comprobarApellidos();
    };
    emailInput.oninput = function() {
        comprobarEmail();
    };
    passwordInput.oninput = function() {
        comprobarPassword();
        if (passwordConfirmationInput.value.trim() !== '') {
            comprobarPasswordConfirmation();
        }
    };
    passwordConfirmationInput.oninput = function() {
        comprobarPasswordConfirmation();
    };

    function comprobarBoton() {
        const nombre = nombreInput.value.trim();
        const apellidos = apellidosInput.value.trim();
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();
        const passwordConfirmation = passwordConfirmationInput.value.trim();
        const emailFormato = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        let nombreValido = nombre !== '' && nombre.length >= 2;
        
        let apellidosValidos = false;
        if (apellidos !== '') {
            const apellidosArray = apellidos.split(' ').filter(a => a !== '');
            if (apellidosArray.length >= 2) {
                apellidosValidos = apellidosArray.every(apellido => apellido.length >= 2);
            } else {
                apellidosValidos = apellidos.length >= 2;
            }
        }
        
        let emailValido = email !== '' && emailFormato.test(email);
        let passwordValido = password !== '' && password.length >= 6;
        let passwordConfirmationValido = passwordConfirmation !== '' && password === passwordConfirmation;

        if (nombreValido && apellidosValidos && emailValido && passwordValido && passwordConfirmationValido) {
            botonEnviar.disabled = false;
            botonEnviar.classList.remove("btn-login-desabilitado");
        } else {
            botonEnviar.disabled = true;
            botonEnviar.classList.add("btn-login-desabilitado");
        }
    }

    function comprobarNombre() {
        const nombre = nombreInput.value.trim();

        if (nombre === '') {
            eNombre.innerText = 'El nombre no puede estar vacío.';
        } else if (nombre.length < 2) {
            eNombre.innerText = 'El nombre debe tener al menos 2 caracteres.';
        } else {
            eNombre.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarApellidos() {
        const apellidos = apellidosInput.value.trim();

        if (apellidos === '') {
            eApellidos.innerText = 'Los apellidos no pueden estar vacíos.';
        } else {
            const apellidosArray = apellidos.trim().split(" ");
            
            if (apellidosArray.length >= 2) {
                const todosValidos = apellidosArray.every(apellido => apellido.length >= 2);
                if (!todosValidos) {
                    eApellidos.innerText = 'Cada apellido debe tener al menos 2 caracteres.';
                } else {
                    eApellidos.innerText = '';
                }
            } else if (apellidos.length < 2) {
                eApellidos.innerText = 'Los apellidos deben tener al menos 2 caracteres.';
            } else {
                eApellidos.innerText = '';
            }
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

    function comprobarPassword() {
        const password = passwordInput.value.trim();

        if (password === '') {
            ePassword.innerText = 'La contraseña no puede estar vacía.';
        } else if (password.length < 6) {
            ePassword.innerText = 'La contraseña debe tener al menos 6 caracteres.';
        } else {
            ePassword.innerText = '';
        }
        comprobarBoton();
    }

    function comprobarPasswordConfirmation() {
        const password = passwordInput.value.trim();
        const passwordConfirmation = passwordConfirmationInput.value.trim();

        if (passwordConfirmation === '') {
            ePasswordConfirmation.innerText = 'Debes confirmar la contraseña.';
        } else if (password !== passwordConfirmation) {
            ePasswordConfirmation.innerText = 'Las contraseñas no coinciden.';
        } else {
            ePasswordConfirmation.innerText = '';
        }
        comprobarBoton();
    }
};
