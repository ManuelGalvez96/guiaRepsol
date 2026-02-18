<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #00a3e0;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .footer {
            background-color: #f0f0f0;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-radius: 0 0 5px 5px;
        }
        .cambios {
            background-color: #fff;
            padding: 15px;
            border-left: 4px solid #f39c12;
            margin: 15px 0;
            border-radius: 3px;
        }
        .cambios strong {
            color: #f39c12;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tu Perfil Ha Sido Modificado</h2>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $usuario->name }} {{ $usuario->apellidos }}</strong>,</p>
            
            <p>Te notificamos que un administrador ha realizado cambios en tu perfil de usuario.</p>
            
            <div class="cambios">
                <strong>Cambios realizados:</strong><br>
                {{ $cambios }}
            </div>
            
            <p>Si no autorizaste estos cambios o tienes alguna pregunta, por favor contacta con el equipo de administración.</p>
            
            <p>
                Saludos cordiales,<br>
                <strong>El equipo de Guía Repsol</strong>
            </p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Guía Repsol. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
