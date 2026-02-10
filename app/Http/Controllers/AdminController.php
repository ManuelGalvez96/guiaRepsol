<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Categoria;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurante::with(['categoria', 'ubicacion', 'imagenes']);

        // Filtros
        if ($request->filled('tipo_cocina')) {
            $query->where('categoria_id', $request->tipo_cocina);
        }

        if ($request->filled('valoracion')) {
            $query->where('valoracion_promedio', '>=', $request->valoracion);
        }

        if ($request->filled('precio')) {
            $query->where('precio', '<=', $request->precio);
        }

        $restaurantes = $query->paginate(10);
        $categorias = Categoria::all();

        return view('admin.index', compact('restaurantes', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        return view('admin.create', compact('categorias', 'ubicaciones'));
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
        ]);

        $restaurante = Restaurante::create($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante creado exitosamente',
                'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes'])
            ], 201);
        }

        return Redirect::route('admin.index')->with('success', 'Restaurante creado exitosamente');
    }

    public function edit(Restaurante $restaurante)
    {
        $categorias = Categoria::all();
        $ubicaciones = Ubicacion::all();
        return view('admin.edit', compact('restaurante', 'categorias', 'ubicaciones'));
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
        ]);

        $restaurante->update($validated);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante actualizado exitosamente',
                'restaurante' => $restaurante->load(['categoria', 'ubicacion', 'imagenes'])
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
