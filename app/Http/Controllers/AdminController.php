<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use App\Models\ImagenRestaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


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
        $categorias = Categoria::all();
        $tiposComida = TipoComida::all();

        return view('admin.index', compact('restaurantes', 'categorias', 'tiposComida'));
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
            $path = $imagen->store('img_restaurantes', 'public');
            
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
            $path = $imagen->store('img_restaurantes', 'public');
            
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
                'message' => 'Restaurante actualizado exitosamente',
                'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes', 'tiposComida'])
            ]);
        }

        return Redirect::route('admin.index')->with('success', 'Restaurante actualizado exitosamente');
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
