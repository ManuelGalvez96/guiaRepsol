<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use App\Models\ImagenRestaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

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
            $restaurantesGerente = Restaurante::with(['categoria', 'ubicacion', 'tiposComida'])
                ->where('user_id', Auth::id())
                ->where('activo', true)
                ->paginate(4, ['*'], 'gerente_page');
        }

        // Obtener restaurantes patrocinados
        $patrocinadosQuery = Restaurante::with(['categoria', 'ubicacion', 'tiposComida'])
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
            ]);
        }

        return view('restaurantes', compact('restaurantes', 'restaurantesPatrocinados', 'restaurantesGerente', 'totalPatrocinados'));
    }

    public function show($id)
    {
        $restaurante = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'valoraciones.usuario'])
            ->findOrFail($id);

        return view('restaurante-detalle', compact('restaurante'));
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
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:10',
            'comunidad_autonoma' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'required|email|unique:restaurantes,email',
            'web' => 'nullable|url',
            'precio' => 'required|numeric|min:0',
            'foto_principal' => 'required|image|max:5120',
            'fotos_adicionales.*' => 'nullable|image|max:5120',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id'
        ]);

        // Crear o encontrar la ubicación
        $ubicacion = Ubicacion::firstOrCreate([
            'comunidad_autonoma' => $request->comunidad_autonoma,
            'provincia' => $request->provincia,
            'ciudad' => $request->ciudad,
            'codigo_postal' => $request->codigo_postal,
        ]);

        // Crear el restaurante
        $restaurante = Restaurante::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => Auth::id() ?? 1, // Si no hay usuario autenticado, usar ID 1
            'categoria_id' => $request->categoria_id,
            'ubicacion_id' => $ubicacion->id,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'web' => $request->web,
            'precio' => $request->precio,
            'activo' => false, // Pendiente de aprobación
        ]);

        // Subir foto principal
        if ($request->hasFile('foto_principal')) {
<<<<<<< HEAD
            $path = $request->file('foto_principal')->store('img/restaurantes', 'public');
=======
            $nombreArchivo = time() . '_' . $request->file('foto_principal')->getClientOriginalName();
            $request->file('foto_principal')->move(public_path('img/restaurantes'), $nombreArchivo);
>>>>>>> 580cb6d51f052b49fa078817004a7f106120c719
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => 'img/restaurantes/' . $nombreArchivo,
                'principal' => true,
                'orden' => 0
            ]);
        }

        // Subir fotos adicionales
        if ($request->hasFile('fotos_adicionales')) {
            $orden = 1;
            foreach ($request->file('fotos_adicionales') as $foto) {
<<<<<<< HEAD
                $path = $foto->store('img/restaurantes', 'public');
=======
                $nombreArchivo = time() . '_' . uniqid() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('img/restaurantes'), $nombreArchivo);
>>>>>>> 580cb6d51f052b49fa078817004a7f106120c719
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => 'img/restaurantes/' . $nombreArchivo,
                    'principal' => false,
                    'orden' => $orden++
                ]);
            }
        }

        // Asociar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->attach($request->tipos_comida);
        }

        return redirect()->route('home')->with('success', '¡Solicitud enviada! Tu restaurante será revisado pronto.');
    }
}
