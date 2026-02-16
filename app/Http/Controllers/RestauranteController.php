<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\RestaurantePendiente;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use App\Models\UbicacionRestaurantePendiente;
use App\Models\ImagenRestaurante;
use App\Models\LikeRestaurante;
use App\Models\GuardarRestaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\ImagenRestaurantePendiente;
use Illuminate\Support\Facades\DB;

class RestauranteController extends Controller
{
    public function index(Request $request)
    {
        $stopwords = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'the', 'restaurante', 'restaurant', 'l'];
        $normalizeRestauranteName = function (string $value) use ($stopwords): string {
            $asciiValue = Str::ascii($value);
            $cleanValue = preg_replace('/[^a-zA-Z0-9]+/', ' ', $asciiValue) ?? '';
            $tokens = array_filter(explode(' ', strtolower($cleanValue)));
            $tokens = array_values(array_filter($tokens, fn ($token) => !in_array($token, $stopwords, true)));

            return implode('', $tokens);
        };

        $restauranteImageMap = [];
        foreach (File::files(public_path('img/restaurantes')) as $file) {
            $baseName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $key = $normalizeRestauranteName($baseName);
            if ($key !== '') {
                $restauranteImageMap[$key] = 'img/restaurantes/' . $file->getFilename();
            }
        }

        $resolveRestauranteImage = function (string $nombre) use ($normalizeRestauranteName, $restauranteImageMap): string {
            $key = $normalizeRestauranteName($nombre);

            return $restauranteImageMap[$key] ?? 'img/restaurantes/emigrante.webp';
        };

        $query = Restaurante::with(['categoria', 'ubicacion', 'tiposComida']);

        // Obtener restaurantes del gerente si está autenticado y es gerente
        $restaurantesGerente = null;
        if (Auth::check() && Auth::user()->rol === 'gerente') {
            $restaurantesGerente = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes'])
                ->where('user_id', Auth::id())
                ->where('activo', true)
                ->paginate(4, ['*'], 'gerente_page');
        }

        // Obtener restaurantes patrocinados
        $patrocinadosQuery = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes'])
            ->where('patrocinados', true)
            ->where('activo', true);
        $totalPatrocinados = (clone $patrocinadosQuery)->count();
        $ordenarPatrocinados = $request->get('ordenar_patrocinados', 'nombre');

        switch ($ordenarPatrocinados) {
            case 'valoracion':
                $patrocinadosQuery->orderBy('valoracion_promedio', 'desc');
                break;
            case 'precio_asc':
                $patrocinadosQuery->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $patrocinadosQuery->orderBy('precio', 'desc');
                break;
            case 'soles':
                $patrocinadosQuery->orderBy('soles', 'desc');
                break;
            case 'nombre':
            default:
                $patrocinadosQuery->orderBy('nombre', 'asc');
                break;
        }

        $restaurantesPatrocinados = $patrocinadosQuery->paginate(5, ['*'], 'patrocinados_page');

        // Aplicar ordenamiento
        $ordenar = $request->get('ordenar', 'nombre');
        $buscar = trim((string) $request->get('buscar', ''));

        switch ($ordenar) {
            case 'valoracion':
                $query->orderBy('valoracion_promedio', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'soles':
                $query->orderBy('soles', 'desc');
                break;
            case 'nombre':
            default:
                $query->orderBy('nombre', 'asc');
                break;
        }

        if ($buscar !== '') {
            $buscarLower = Str::lower($buscar);
            $query->whereRaw('LOWER(nombre) LIKE ?', [$buscarLower . '%']);
        }

        $restaurantes = $query->where('activo', true)->paginate(6);

        if ($request->ajax()) {
            $items = $restaurantes->getCollection()->map(function ($restaurante) use ($resolveRestauranteImage) {
                return [
                    'id' => $restaurante->id,
                    'nombre' => $restaurante->nombre,
                    'categoria' => $restaurante->categoria->nombre,
                    'ciudad' => $restaurante->ubicacion->ciudad,
                    'provincia' => $restaurante->ubicacion->provincia,
                    'soles' => $restaurante->soles,
                    'valoracion' => number_format($restaurante->valoracion_promedio, 1),
                    'precio' => $restaurante->precio,
                    'imagen' => asset($resolveRestauranteImage($restaurante->nombre)),
                    'detalle_url' => route('restaurante.detalle', $restaurante->id),
                ];
            })->values();

            return response()->json([
                'items' => $items,
                'total' => $restaurantes->total(),
                'term' => $buscar,
                'current_page' => $restaurantes->currentPage(),
                'last_page' => $restaurantes->lastPage(),
                'per_page' => $restaurantes->perPage(),
                'from' => $restaurantes->firstItem(),
                'to' => $restaurantes->lastItem(),
            ]);
        }

        return view('restaurantes', compact('restaurantes', 'restaurantesPatrocinados', 'restaurantesGerente', 'totalPatrocinados'));
    }

    public function show($id)
    {
        $restaurante = Restaurante::with([
            'categoria', 
            'ubicacion', 
            'tiposComida', 
            'valoraciones.usuario',
            'imagenes' => function($query) {
                $query->orderBy('principal', 'desc')->orderBy('orden', 'asc');
            }
        ])->findOrFail($id);

        // Obtener imagen principal
        $imagenPrincipal = $restaurante->imagenes->where('principal', true)->first();
        
        // Obtener imágenes adicionales
        $imagenesAdicionales = $restaurante->imagenes->where('principal', false);

        // Verificar si el usuario ha dado like o guardado el restaurante
        $userHasLiked = Auth::check() && LikeRestaurante::where('user_id', Auth::id())
            ->where('restaurante_id', $id)
            ->exists();
            
        $userHasSaved = Auth::check() && GuardarRestaurante::where('user_id', Auth::id())
            ->where('restaurante_id', $id)
            ->exists();
            
        $totalLikes = LikeRestaurante::where('restaurante_id', $id)->count();

        return view('restaurante-detalle', compact('restaurante', 'imagenPrincipal', 'imagenesAdicionales', 'userHasLiked', 'userHasSaved', 'totalLikes'));
    }

    public function update(Request $request, $id)
    {
        $restaurante = Restaurante::findOrFail($id);
        
        // Verificar que el usuario autenticado es el gerente del restaurante
        if (!Auth::check() || Auth::id() !== $restaurante->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para editar este restaurante'
            ], 403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email,' . $restaurante->id,
            'web' => 'nullable|url',
            'precio' => 'required|numeric',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'fotos_adicionales' => 'nullable|array|max:8',
            'fotos_adicionales.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
        ]);

        // Actualizar datos básicos del restaurante
        $restaurante->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'] ?? null,
            'categoria_id' => $validated['categoria_id'],
            'direccion' => $validated['direccion'],
            'telefono' => $validated['telefono'] ?? null,
            'email' => $validated['email'],
            'web' => $validated['web'] ?? null,
            'precio' => $validated['precio'],
        ]);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        } else {
            $restaurante->tiposComida()->detach();
        }

        // Actualizar imagen si se subió una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            $imagenAnterior = $restaurante->imagenes()->where('principal', true)->first();
            if ($imagenAnterior) {
                $rutaAnterior = $imagenAnterior->url;
                // Si la imagen está en storage, eliminarla
                if (str_starts_with($rutaAnterior, 'restaurantes/')) {
                    Storage::disk('public')->delete($rutaAnterior);
                } elseif (str_starts_with($rutaAnterior, 'img/restaurantes/')) {
                    // Si está en public/img, eliminarla también
                    $rutaPublica = public_path($rutaAnterior);
                    if (file_exists($rutaPublica)) {
                        unlink($rutaPublica);
                    }
                }
                $imagenAnterior->delete();
            }

            // Guardar nueva imagen
            $imagen = $request->file('imagen');
            $nombreArchivo = time() . '_' . $imagen->getClientOriginalName();
            $imagen->move(public_path('img/restaurantes'), $nombreArchivo);
            
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => 'img/restaurantes/' . $nombreArchivo,
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0
            ]);
        }

        // Agregar fotos adicionales si se subieron
        if ($request->hasFile('fotos_adicionales')) {
            // Obtener el último orden de las imágenes adicionales actuales
            $ultimoOrden = $restaurante->imagenes()->where('principal', false)->max('orden') ?? 0;
            
            foreach ($request->file('fotos_adicionales') as $foto) {
                $ultimoOrden++;
                $nombreArchivo = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('img/restaurantes'), $nombreArchivo);
                
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => 'img/restaurantes/' . $nombreArchivo,
                    'alt' => $restaurante->nombre . ' - Foto ' . $ultimoOrden,
                    'principal' => false,
                    'orden' => $ultimoOrden
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Restaurante actualizado exitosamente',
            'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes', 'tiposComida'])
        ]);
    }

    public function eliminarImagenSlider(Request $request, $id)
    {
        $imagen = ImagenRestaurante::findOrFail($id);
        $restaurante = $imagen->restaurante;
        
        // Verificar que el usuario autenticado es el gerente del restaurante
        if (!Auth::check() || Auth::id() !== $restaurante->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para eliminar esta imagen'
            ], 403);
        }

        // No permitir eliminar la imagen principal
        if ($imagen->principal) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar la imagen principal desde aquí'
            ], 400);
        }

        // Eliminar el archivo físico
        $rutaImagen = $imagen->url;
        if (str_starts_with($rutaImagen, 'restaurantes/')) {
            Storage::disk('public')->delete($rutaImagen);
        } elseif (str_starts_with($rutaImagen, 'img/restaurantes/')) {
            $rutaPublica = public_path($rutaImagen);
            if (file_exists($rutaPublica)) {
                unlink($rutaPublica);
            }
        }

        // Eliminar el registro de la base de datos
        $imagen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Imagen eliminada exitosamente'
        ]);
    }

    public function create()
    {
        $categorias = Categoria::all();
        $tiposComida = TipoComida::all();
        
        return view('formulario', compact('categorias', 'tiposComida'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|min:100|max:1000',
            'categoria_id' => 'required|exists:categorias,id',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'codigo_postal' => 'required|string|size:5|regex:/^[0-9]{5}$/',
            'comunidad_autonoma' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:restaurante_pendiente,email',
            'web' => 'nullable|url',
            'precio' => 'required|numeric|min:0.01|max:9999.99',
            'foto_principal' => 'required|image|mimes:jpeg,jpg,png,webp|max:5120',
            'fotos_adicionales' => 'nullable|array|max:8',
            'fotos_adicionales.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id'
        ], [
            'nombre.required' => 'El nombre del negocio es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 100 caracteres',
            'descripcion.max' => 'La descripción no puede exceder 1000 caracteres',
            'categoria_id.required' => 'Debe seleccionar una categoría',
            'categoria_id.exists' => 'La categoría seleccionada no es válida',
            'direccion.required' => 'La dirección es obligatoria',
            'ciudad.required' => 'La ciudad es obligatoria',
            'provincia.required' => 'La provincia es obligatoria',
            'codigo_postal.required' => 'El código postal es obligatorio',
            'codigo_postal.size' => 'El código postal debe tener exactamente 5 dígitos',
            'codigo_postal.regex' => 'El código postal debe contener solo números',
            'comunidad_autonoma.required' => 'La comunidad autónoma es obligatoria',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser una dirección válida',
            'email.unique' => 'Este email ya está registrado',
            'web.url' => 'La dirección web debe ser una URL válida',
            'precio.required' => 'El precio es obligatorio',
            'precio.min' => 'El precio debe ser mayor a 0',
            'precio.max' => 'El precio no puede superar los 9999.99€',
            'foto_principal.required' => 'Debe subir una foto principal',
            'foto_principal.image' => 'El archivo debe ser una imagen',
            'foto_principal.mimes' => 'La foto debe ser formato JPG, PNG o WEBP',
            'foto_principal.max' => 'La foto principal no puede superar los 5MB',
            'fotos_adicionales.max' => 'Puede subir máximo 8 fotos adicionales',
            'fotos_adicionales.*.image' => 'Todos los archivos deben ser imágenes',
            'fotos_adicionales.*.mimes' => 'Las fotos deben ser formato JPG, PNG o WEBP',
            'fotos_adicionales.*.max' => 'Cada foto adicional no puede superar los 5MB',
            'tipos_comida.*.exists' => 'Uno o más tipos de comida seleccionados no son válidos',
        ]);

        // Crear ubicación pendiente
        $ubicacionPendiente = UbicacionRestaurantePendiente::create([
            'comunidad_autonoma' => $request->comunidad_autonoma,
            'provincia' => $request->provincia,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
        ]);

        // Crear el restaurante pendiente
        $restaurantePendiente = RestaurantePendiente::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id() ?? 1, // Si no hay usuario autenticado, usar ID 1
            'categoria_id' => $request->categoria_id,
            'ubicacion_pendiente_id' => $ubicacionPendiente->id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'web' => $request->web,
            'precio' => $request->precio,
            'activo' => true, // En tabla pendiente, activo = true indica que está pendiente
        ]);

        // Subir foto principal
        if ($request->hasFile('foto_principal')) {
            $file = $request->file('foto_principal');
            $directory = public_path('img/restaurantes/pendiente');

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $filename = uniqid('rest_p_') . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $path = 'img/restaurantes/pendiente/' . $filename;

            ImagenRestaurantePendiente::create([
                'restaurante_pendiente_id' => $restaurantePendiente->id,
                'url' => $path,
                'principal' => true,
                'orden' => 0
            ]);
        }

        // Subir fotos adicionales
        if ($request->hasFile('fotos_adicionales')) {
            $orden = 1;
            $directory = public_path('img/restaurantes/pendiente');

            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            foreach ($request->file('fotos_adicionales') as $foto) {
                $filename = uniqid('rest_p_') . '.' . $foto->getClientOriginalExtension();
                $foto->move($directory, $filename);
                $path = 'img/restaurantes/pendiente/' . $filename;

                ImagenRestaurantePendiente::create([
                    'restaurante_pendiente_id' => $restaurantePendiente->id,
                    'url' => $path,
                    'principal' => false,
                    'orden' => $orden++
                ]);
            }
        }

        // Asociar tipos de comida (guardar en tabla tipo_comida_restaurante_pendiente)
        if ($request->has('tipos_comida')) {
            foreach ($request->tipos_comida as $tipoComidaId) {
                DB::table('tipo_comida_restaurante_pendiente')->insert([
                    'restaurante_pendiente_id' => $restaurantePendiente->id,
                    'tipo_comida_id' => $tipoComidaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Redirigir según si el usuario está autenticado o no
        if (Auth::check()) {
            return redirect()->route('restaurantes')->with('success', '¡Solicitud enviada! Tu restaurante será revisado pronto.');
        }
        
        return redirect('/')->with('success', '¡Solicitud enviada! Tu restaurante será revisado pronto.');
    }

    // Toggle like (dar/quitar like a un restaurante)
    public function toggleLike($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        $userId = Auth::id();

        $like = \App\Models\LikeRestaurante::where('user_id', $userId)
            ->where('restaurante_id', $id)
            ->first();

        if ($like) {
            // Ya tiene like, se quita
            $like->delete();
            $liked = false;
        } else {
            // No tiene like, se agrega
            \App\Models\LikeRestaurante::create([
                'user_id' => $userId,
                'restaurante_id' => $id,
            ]);
            $liked = true;
        }

        $totalLikes = \App\Models\LikeRestaurante::where('restaurante_id', $id)->count();

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'totalLikes' => $totalLikes,
        ]);
    }

    // Toggle guardar (guardar/quitar guardado de un restaurante)
    public function toggleGuardar($id)
    {
        $restaurante = Restaurante::findOrFail($id);
        $userId = Auth::id();

        $guardado = \App\Models\GuardarRestaurante::where('user_id', $userId)
            ->where('restaurante_id', $id)
            ->first();

        if ($guardado) {
            // Ya está guardado, se quita
            $guardado->delete();
            $saved = false;
            $message = 'Restaurante eliminado de guardados';
        } else {
            // No está guardado, se agrega
            \App\Models\GuardarRestaurante::create([
                'user_id' => $userId,
                'restaurante_id' => $id,
            ]);
            $saved = true;
            $message = 'Restaurante guardado correctamente';
        }

        return response()->json([
            'success' => true,
            'saved' => $saved,
            'message' => $message,
        ]);
    }

    // Vista de restaurantes guardados
    public function guardados(Request $request)
    {
        $stopwords = ['el', 'la', 'los', 'las', 'de', 'del', 'y', 'the', 'restaurante', 'restaurant', 'l'];
        $normalizeRestauranteName = function (string $value) use ($stopwords): string {
            $asciiValue = Str::ascii($value);
            $cleanValue = preg_replace('/[^a-zA-Z0-9]+/', ' ', $asciiValue) ?? '';
            $tokens = array_filter(explode(' ', strtolower($cleanValue)));
            $tokens = array_values(array_filter($tokens, fn ($token) => !in_array($token, $stopwords, true)));

            return implode('', $tokens);
        };

        $restauranteImageMap = [];
        foreach (File::files(public_path('img/restaurantes')) as $file) {
            $baseName = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $key = $normalizeRestauranteName($baseName);
            if ($key !== '') {
                $restauranteImageMap[$key] = 'img/restaurantes/' . $file->getFilename();
            }
        }

        $resolveRestauranteImage = function (string $nombre) use ($normalizeRestauranteName, $restauranteImageMap): string {
            $key = $normalizeRestauranteName($nombre);

            return $restauranteImageMap[$key] ?? 'img/restaurantes/emigrante.webp';
        };

        $userId = Auth::id();
        
        $query = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes'])
            ->whereHas('guardados', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });

        // Aplicar ordenamiento
        $ordenar = $request->get('ordenar', 'nombre');
        
        switch ($ordenar) {
            case 'valoracion':
                $query->orderBy('valoracion_promedio', 'desc');
                break;
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'soles':
                $query->orderBy('soles', 'desc');
                break;
            case 'nombre':
            default:
                $query->orderBy('nombre', 'asc');
                break;
        }

        $restaurantes = $query->paginate(12);

        return view('restaurantes-guardados', compact('restaurantes'));
    }
}
