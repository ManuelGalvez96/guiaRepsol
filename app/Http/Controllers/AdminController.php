<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurante::with(['categoria', 'ubicacion', 'imagenes', 'tiposComida']);

        // Filtros
        if ($request->filled('tipo_comida')) {
            $query->whereHas('tiposComida', function($q) use ($request) {
                $q->where('tipo_comida.id', $request->tipo_comida);
            });
        }

        if ($request->filled('valoracion')) {
            $query->where('valoracion_promedio', '>=', $request->valoracion);
        }

        if ($request->filled('precio')) {
            $query->where('precio', '<=', $request->precio);
        }

        $restaurantes = $query->paginate(10);
        $categorias = Categoria::all();
        $tiposComida = TipoComida::all();

        return view('admin.index', compact('restaurantes', 'categorias', 'tiposComida'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        $tiposComida = TipoComida::all();
        return view('admin.create', compact('categorias', 'ubicaciones', 'tiposComida'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
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
        ]);

        $restaurante = Restaurante::create($validated);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
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

    public function edit(Restaurante $restaurante)
    {
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        $tiposComida = TipoComida::all();
        return view('admin.edit', compact('restaurante', 'categorias', 'ubicaciones', 'tiposComida'));
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
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
        ]);

        $restaurante->update($validated);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        } else {
            $restaurante->tiposComida()->detach();
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
