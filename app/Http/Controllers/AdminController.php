<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Restaurante::query();

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

        return view('admin.index', compact('restaurantes'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email',
            'precio' => 'required|numeric',
            'valoracion_promedio' => 'nullable|numeric|min:0|max:5',
            'imagen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('restaurantes', 'public');
        }

        Restaurante::create($validated);

        return redirect()->route('admin.index')->with('success', 'Restaurante creado exitosamente');
    }

    public function edit(Restaurante $restaurante)
    {
        return view('admin.edit', compact('restaurante'));
    }

    public function update(Request $request, Restaurante $restaurante)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email,' . $restaurante->id,
            'precio' => 'required|numeric',
            'valoracion_promedio' => 'nullable|numeric|min:0|max:5',
            'imagen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('restaurantes', 'public');
        }

        $restaurante->update($validated);

        return redirect()->route('admin.index')->with('success', 'Restaurante actualizado exitosamente');
    }

    public function destroy(Restaurante $restaurante)
    {
        $restaurante->delete();

        return redirect()->route('admin.index')->with('success', 'Restaurante eliminado exitosamente');
    }
}
