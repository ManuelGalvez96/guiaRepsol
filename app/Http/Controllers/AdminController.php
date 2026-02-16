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
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    private function checkAdmin()
    {
        if (Auth::user()->rol !== 'administrador') {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
    }

    public function index(Request $request)
    {
        $this->checkAdmin();
        $query = Restaurante::with(['categoria', 'ubicacion', 'imagenes', 'tiposComida']);

        // Filtro de búsqueda por nombre
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('descripcion', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('direccion', 'LIKE', '%' . $buscar . '%');
            });
        }

        // Filtros
        if ($request->filled('tipo_comida')) {
            $query->whereHas('tiposComida', function($q) use ($request) {
                $q->where('tipo_comida.id', $request->tipo_comida);
            });
        }

        if ($request->filled('valoracion')) {
            $valoracion = (int) $request->valoracion;
            // Filtrar por estrellas exactas (ej: 4 = entre 4.0 y 4.9)
            $query->where('valoracion_promedio', '>=', $valoracion)
                  ->where('valoracion_promedio', '<', $valoracion + 1);
        }

        if ($request->filled('precio')) {
            // El formato es "min-max" o "max+" para precios mayores
            $precioRango = $request->precio;
            
            if (strpos($precioRango, '-') !== false) {
                // Rango: "0-10", "10-20", etc.
                list($min, $max) = explode('-', $precioRango);
                $query->whereBetween('precio', [(float)$min, (float)$max]);
            } elseif (strpos($precioRango, '+') !== false) {
                // Mayor que: "50+"
                $min = (float) str_replace('+', '', $precioRango);
                $query->where('precio', '>=', $min);
            }
        }

        $restaurantes = $query->paginate(10);
        $restaurantes->appends($request->query());

        // Para peticiones AJAX, devolver solo la tabla
        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.partials.restaurantes-table', compact('restaurantes'))->render();
        }

        // Para peticiones normales, devolver la vista completa
        $perPage = $request->input('per_page', 10);
        $restaurantes = $query->paginate($perPage)->appends($request->except('page'));
        $categorias = Categoria::all();
        $tiposComida = TipoComida::all();

        return view('admin.index', compact('restaurantes', 'categorias', 'tiposComida'));
    }

    public function solicitudes(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        
        // Obtener restaurantes pendientes de aprobación de la tabla restaurante_pendiente
        $solicitudes = RestaurantePendiente::with(['categoria', 'ubicacionPendiente', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->except('page'));

        // Cargar imágenes manualmente para cada solicitud
        foreach ($solicitudes as $solicitud) {
            $solicitud->imagenes = ImagenRestaurantePendiente::where('restaurante_pendiente_id', $solicitud->id)->get();
            
            // Cargar tipos de comida
            $solicitud->tiposComida = DB::table('tipo_comida_restaurante_pendiente')
                ->join('tipo_comida', 'tipo_comida_restaurante_pendiente.tipo_comida_id', '=', 'tipo_comida.id')
                ->where('tipo_comida_restaurante_pendiente.restaurante_pendiente_id', $solicitud->id)
                ->select('tipo_comida.*')
                ->get();
        }

        return view('admin.solicitudes', compact('solicitudes'));
    }

    public function create(Request $request)
    {
        $this->checkAdmin();
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        $tiposComida = TipoComida::all();
        $gerentes = \App\Models\User::where('rol', 'gerente')->get();
        
        // Para peticiones AJAX, devolver solo el formulario
        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.partials.create-form', compact('categorias', 'ubicaciones', 'tiposComida', 'gerentes'))->render();
        }
        
        return view('admin.create', compact('categorias', 'ubicaciones', 'tiposComida', 'gerentes'));
    }

    public function store(Request $request)
    {
        $this->checkAdmin();
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'categoria_id' => 'required|exists:categorias,id',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email',
            'web' => 'nullable|url',
            'precio' => 'required|numeric',
            'soles' => 'nullable|integer|min:0|max:3',
            'valoracion_promedio' => 'nullable|numeric|min:0|max:5',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $restaurante = Restaurante::create($validated);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        }

        // Guardar imagen si se subió
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $path = $imagen->store('img/restaurantes/', 'public');
            
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => $path,
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante creado exitosamente',
                'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes', 'tiposComida'])
            ], 201);
        }

        return Redirect::route('admin.index')->with('success', 'Restaurante creado exitosamente');
    }

    public function edit(Request $request, Restaurante $restaurante)
    {
        $this->checkAdmin();
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        $tiposComida = TipoComida::all();
        $gerentes = \App\Models\User::where('rol', 'gerente')->get();
        
        // Para peticiones AJAX, devolver solo el formulario
        if ($request->ajax() || $request->wantsJson()) {
            return view('admin.partials.edit-form', compact('restaurante', 'categorias', 'ubicaciones', 'tiposComida', 'gerentes'))->render();
        }
        
        return view('admin.edit', compact('restaurante', 'categorias', 'ubicaciones', 'tiposComida', 'gerentes'));
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $this->checkAdmin();
        // Si solo se está actualizando el estado activo (aprobar solicitud)
        if ($request->has('activo') && count($request->all()) == 1) {
            $restaurante->update(['activo' => $request->activo]);
            
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente'
            ]);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'categoria_id' => 'required|exists:categorias,id',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email,' . $restaurante->id,
            'web' => 'nullable|url',
            'precio' => 'required|numeric',
            'soles' => 'nullable|integer|min:0|max:3',
            'valoracion_promedio' => 'nullable|numeric|min:0|max:5',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $restaurante->update($validated);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        } else {
            $restaurante->tiposComida()->detach();
        }

        // Actualizar imagen si se subió una nueva
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            $imagenAnterior = $restaurante->imagenes->first();
            if ($imagenAnterior) {
                Storage::disk('public')->delete($imagenAnterior->url);
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

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante actualizado exitosamente',
                'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes', 'tiposComida'])
            ]);
        }

        return Redirect::route('admin.index')->with('success', 'Restaurante actualizado exitosamente');
    }

    public function aprobarSolicitud($id)
    {
        try {
            $pendiente = RestaurantePendiente::with(['ubicacionPendiente'])->findOrFail($id);
            
            // Crear o encontrar ubicación en la tabla principal
            $ubicacion = Ubicacion::firstOrCreate([
                'comunidad_autonoma' => $pendiente->ubicacionPendiente->comunidad_autonoma,
                'provincia' => $pendiente->ubicacionPendiente->provincia,
                'ciudad' => $pendiente->ubicacionPendiente->ciudad,
                'codigo_postal' => $pendiente->ubicacionPendiente->codigo_postal,
            ]);
            
            // Crear restaurante en tabla principal
            $restaurante = Restaurante::create([
                'nombre' => $pendiente->nombre,
                'descripcion' => $pendiente->descripcion,
                'user_id' => $pendiente->user_id,
                'categoria_id' => $pendiente->categoria_id,
                'ubicacion_id' => $ubicacion->id,
                'direccion' => $pendiente->direccion,
                'telefono' => $pendiente->telefono,
                'email' => $pendiente->email,
                'web' => $pendiente->web,
                'precio' => $pendiente->precio,
                'soles' => 0,
                'valoracion_promedio' => 0,
                'activo' => true,
            ]);
            
            // Migrar imágenes
            $imagenesPendientes = ImagenRestaurantePendiente::where('restaurante_pendiente_id', $id)->get();
            foreach ($imagenesPendientes as $imagenPendiente) {
                // Copiar la imagen de restaurantes_pendientes a restaurantes
                $oldPath = $imagenPendiente->url;
                $newPath = str_replace('restaurantes_pendientes', 'restaurantes', $oldPath);
                
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->copy($oldPath, $newPath);
                }
                
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => $newPath,
                    'alt' => $imagenPendiente->alt,
                    'principal' => $imagenPendiente->principal,
                    'orden' => $imagenPendiente->orden,
                ]);
            }
            
            // Migrar tipos de comida
            $tiposComida = DB::table('tipo_comida_restaurante_pendiente')
                ->where('restaurante_pendiente_id', $id)
                ->pluck('tipo_comida_id');
            
            $restaurante->tiposComida()->attach($tiposComida);
            
            // Eliminar imágenes pendientes del storage
            foreach ($imagenesPendientes as $imagenPendiente) {
                if (Storage::disk('public')->exists($imagenPendiente->url)) {
                    Storage::disk('public')->delete($imagenPendiente->url);
                }
            }
            
            // Eliminar de tablas pendientes
            DB::table('tipo_comida_restaurante_pendiente')
                ->where('restaurante_pendiente_id', $id)
                ->delete();
            ImagenRestaurantePendiente::where('restaurante_pendiente_id', $id)->delete();
            $pendiente->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Solicitud aprobada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al aprobar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function rechazarSolicitud($id)
    {
        try {
            $pendiente = RestaurantePendiente::findOrFail($id);
            
            // Eliminar imágenes del storage
            $imagenes = ImagenRestaurantePendiente::where('restaurante_pendiente_id', $id)->get();
            foreach ($imagenes as $imagen) {
                if (Storage::disk('public')->exists($imagen->url)) {
                    Storage::disk('public')->delete($imagen->url);
                }
            }
            
            // Eliminar de tablas relacionadas
            DB::table('tipo_comida_restaurante_pendiente')
                ->where('restaurante_pendiente_id', $id)
                ->delete();
            ImagenRestaurantePendiente::where('restaurante_pendiente_id', $id)->delete();
            $pendiente->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Solicitud rechazada exitosamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al rechazar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, Restaurante $restaurante)
    {
        $this->checkAdmin();
        $restaurante->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante eliminado exitosamente'
            ]);
        }

        return Redirect::route('admin.index')->with('success', 'Restaurante eliminado exitosamente');
    }
}
