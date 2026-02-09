<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite(['resources/js/app.js'])
    <title>Document</title>
</head>

<body>
    <h1>Accede con tu cuenta</h1>
    <p>Accede con tu correo electrónico y contraseña o mediante redes sociales. Recuerda que puedes utilizar la misma
        cuenta que empleas para
        <a href="#" data-bs-toggle="modal" data-bs-target="#modalRepsol" style="cursor: pointer;">las webs y apps
            de Repsol.</a>
    </p>

    <!-- MODAL -->
    <div class="modal fade" id="modalRepsol" tabindex="-1" aria-labelledby="modalRepsolLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRepsolLabel">¿Cuáles son las webs y apps de Repsol?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <p>Si tienes una cuenta en cualquiera de ellas, tienes una cuenta única de Repsol. Así, podrás acceder a todas con el mismo correo electrónico y contraseña.</p><br>
                    </div>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Waylet, App de pagos</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Repsol Vivit y Yrea Cliente de Luz y Gas</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Pide tu Bombona y Pide tu Gasoleo</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Box Repsol</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Guía Repsol</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Repsol.es y Tienda Online</li>
                        <li style="margin-bottom: 12px;"><span class="icono_modal">✓</span> Yrea profesional Mi Solred</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #008B8B; color: white;" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</html>
