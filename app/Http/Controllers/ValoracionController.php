<?php

namespace App\Http\Controllers;

use App\Models\Valoracion;
use App\Models\Restaurante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValoracionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $restauranteId)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
        ]);

        // Verificar que el usuario no haya valorado ya este restaurante
        $existeValoracion = Valoracion::where('restaurante_id', $restauranteId)
            ->where('usuario_id', Auth::id())
            ->first();

        if ($existeValoracion) {
            return redirect()->back()->with('error', 'Ya has valorado este restaurante.');
        }

        Valoracion::create([
            'restaurante_id' => $restauranteId,
            'usuario_id' => Auth::id(),
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        // Actualizar la valoración promedio del restaurante
        $this->actualizarValoracionPromedio($restauranteId);

        return redirect()->back()->with('success', 'Valoración publicada correctamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'puntuacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
        ]);

        $valoracion = Valoracion::findOrFail($id);

        // Verificar que el usuario es el propietario de la valoración
        if ($valoracion->usuario_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No tienes permiso para editar esta valoración.'], 403);
            }
            return redirect()->back()->with('error', 'No tienes permiso para editar esta valoración.');
        }

        $valoracion->update([
            'puntuacion' => $request->puntuacion,
            'comentario' => $request->comentario,
        ]);

        // Actualizar la valoración promedio del restaurante
        $this->actualizarValoracionPromedio($valoracion->restaurante_id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Valoración actualizada correctamente.',
                'valoracion' => $valoracion
            ]);
        }

        return redirect()->back()->with('success', 'Valoración actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $valoracion = Valoracion::findOrFail($id);

        // Verificar que el usuario es el propietario de la valoración
        if ($valoracion->usuario_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'No tienes permiso para eliminar esta valoración.'], 403);
            }
            return redirect()->back()->with('error', 'No tienes permiso para eliminar esta valoración.');
        }

        $restauranteId = $valoracion->restaurante_id;
        $valoracion->delete();

        // Actualizar la valoración promedio del restaurante
        $this->actualizarValoracionPromedio($restauranteId);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Valoración eliminada correctamente.'
            ]);
        }

        return redirect()->back()->with('success', 'Valoración eliminada correctamente.');
    }

    /**
     * Responder a una valoración (solo para gerentes del restaurante)
     */
    public function responder(Request $request, $id)
    {
        $request->validate([
            'respuesta_gerente' => 'required|string|max:1000',
        ]);

        $valoracion = Valoracion::findOrFail($id);
        $restaurante = $valoracion->restaurante;

        // Verificar que el usuario autenticado es el gerente del restaurante
        if ($restaurante->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso para responder a esta valoración.');
        }

        $valoracion->update([
            'respuesta_gerente' => $request->respuesta_gerente,
            'fecha_respuesta' => now(),
        ]);

        return redirect()->back()->with('success', 'Respuesta publicada correctamente.');
    }

    /**
     * Eliminar la respuesta del gerente a una valoración
     */
    public function eliminarRespuesta($id)
    {
        $valoracion = Valoracion::findOrFail($id);
        $restaurante = $valoracion->restaurante;

        // Verificar que el usuario autenticado es el gerente del restaurante
        if ($restaurante->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar esta respuesta.');
        }

        $valoracion->update([
            'respuesta_gerente' => null,
            'fecha_respuesta' => null,
        ]);

        return redirect()->back()->with('success', 'Respuesta eliminada correctamente.');
    }

    /**
     * Actualizar la valoración promedio de un restaurante
     */
    private function actualizarValoracionPromedio($restauranteId)
    {
        $restaurante = Restaurante::findOrFail($restauranteId);
        $promedio = $restaurante->valoraciones()->avg('puntuacion');
        
        $restaurante->update([
            'valoracion_promedio' => $promedio ? round($promedio, 2) : 0
        ]);
    }
}
