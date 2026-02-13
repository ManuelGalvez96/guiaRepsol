<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\RestaurantePendiente;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use App\Models\UbicacionRestaurantePendiente;
use App\Models\ImagenRestaurante;
use App\Models\ImagenRestaurantePendiente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RestauranteController extends Controller
{
    public function index(Request $request)
    {
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
        $restaurantesPatrocinados = Restaurante::with(['categoria', 'ubicacion', 'tiposComida'])
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
            'descripcion' => 'required|string|min:100',
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
            'fotos_adicionales' => 'nullable|array|max:5',
            'fotos_adicionales.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id'
        ], [
            'nombre.required' => 'El nombre del negocio es obligatorio',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 100 caracteres',
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
            'fotos_adicionales.max' => 'Puede subir máximo 5 fotos adicionales',
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
            $path = $request->file('foto_principal')->store('restaurantes_pendientes', 'public');
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
            foreach ($request->file('fotos_adicionales') as $foto) {
                $path = $foto->store('restaurantes_pendientes', 'public');
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
                \DB::table('tipo_comida_restaurante_pendiente')->insert([
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
}
