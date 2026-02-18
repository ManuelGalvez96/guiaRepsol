<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta eliminada</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.5; color: #333;">
    <h2 style="margin: 0 0 12px 0;">Tu cuenta ha sido eliminada</h2>

    <p>Hola {{ $usuario->name }},</p>

    <p>Lamentamos informarte que tu cuenta ha sido eliminada por un administrador.</p>

    @if($razon)
        <p><strong>Motivo:</strong></p>
        <p>{{ $razon }}</p>
    @endif

    <p>Si crees que esto es un error, contacta con el equipo de soporte.</p>

    <p style="margin-top: 16px;">Gracias.</p>
</body>
</html>
