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

class RestauranteController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes']);

        // Obtener restaurantes del gerente si está autenticado y es gerente
        $restaurantesGerente = null;
        if (Auth::check() && Auth::user()->rol === 'gerente') {
            $restaurantesGerente = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes'])
                ->where('user_id', Auth::id())
                ->where('activo', true)
                ->paginate(4, ['*'], 'gerente_page');
        }

        // Obtener restaurantes patrocinados
        $restaurantesPatrocinados = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'imagenes'])
            ->where('patrocinados', true)
            ->where('activo', true)
            ->inRandomOrder()
            ->paginate(5, ['*'], 'patrocinados_page');

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

        $restaurantes = $query->where('activo', true)->paginate(6);

        return view('restaurantes', compact('restaurantes', 'restaurantesPatrocinados', 'restaurantesGerente'));
    }

    public function show($id)
    {
        $restaurante = Restaurante::with(['categoria', 'ubicacion', 'tiposComida', 'valoraciones.usuario', 'imagenes'])
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
            $path = $request->file('foto_principal')->store('restaurantes', 'public');
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => $path,
                'principal' => true,
                'orden' => 0
            ]);
        }

        // Subir fotos adicionales
        if ($request->hasFile('fotos_adicionales')) {
            $orden = 1;
            foreach ($request->file('fotos_adicionales') as $foto) {
                $path = $foto->store('restaurantes', 'public');
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => $path,
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
