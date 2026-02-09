<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Restaurante - Guía Repsol</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #f5f5f5;
        }

        .header {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: 500;
        }

        .logo::before {
            content: "☀️";
            font-size: 24px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-primary {
            background: #ffd500;
            color: #000;
        }

        .btn-primary:hover {
            background: #e6c000;
        }

        .btn-secondary {
            background: #fff;
            border: 1px solid #ddd;
            color: #000;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #f5f5f5;
        }

        .error {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">guia repsol</div>
    </div>

    <div class="container">
        <h1>Crear Nuevo Restaurante</h1>

        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre del Restaurante *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion') }}" required>
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono') }}">
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio">Precio Promedio (€) *</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio') }}" step="0.01" required>
                @error('precio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="valoracion_promedio">Valoración (0-5)</label>
                <input type="number" id="valoracion_promedio" name="valoracion_promedio" value="{{ old('valoracion_promedio') }}" step="0.1" min="0" max="5">
                @error('valoracion_promedio')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="imagen">Imagen del Restaurante</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
                @error('imagen')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Crear Restaurante</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
