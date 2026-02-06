# Carpeta de Imágenes

## Ubicación
Las imágenes de tu proyecto Laravel deben colocarse en esta carpeta: `public/images/`

## Estructura sugerida
```
public/images/
├── logos/           (logos de la marca, Repsol, etc.)
├── categorias/      (iconos de cafeterías, restaurantes, etc.)
├── establecimientos/ (fotos de restaurantes y locales)
├── hero/            (imágenes del hero/banner principal)
└── icons/           (iconos pequeños)
```

## Cómo usar imágenes en tus vistas Blade

### Método 1: Con asset()
```blade
<img src="{{ asset('images/logos/repsol.png') }}" alt="Logo Repsol">
```

### Método 2: Ruta directa
```blade
<img src="/images/logos/repsol.png" alt="Logo Repsol">
```

### En CSS (archivo public/css/soletes.css)
```css
.card-image {
    background-image: url('/images/hero/banner.jpg');
    background-size: cover;
}
```

## Tipos de imágenes recomendadas
- **Logos**: PNG con fondo transparente
- **Fotos de establecimientos**: JPG optimizadas (max 500KB)
- **Iconos**: SVG o PNG
- **Hero/Banners**: JPG de alta calidad (max 1MB)

## Optimización
Antes de subir imágenes, optimízalas con herramientas como:
- TinyPNG (https://tinypng.com/)
- SVGOMG (https://jakearchibald.github.io/svgomg/)
- ImageOptim
