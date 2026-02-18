<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PerfilController extends Controller
{
    /**
     * Obtener el perfil del usuario autenticado
     */
    public function show()
    {
        $usuario = Auth::user();
        assert($usuario instanceof User);
        
        return response()->json([
            'success' => true,
            'usuario' => [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'foto_perfil' => $usuario->foto_perfil ? asset($usuario->foto_perfil) : asset('img/avatares/default-avatar.png'),
            ]
        ]);
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();
        
        // Type hint para Intellisense
        assert($usuario instanceof User);

        $request->validate([
            'name' => 'required|string|max:255|min:2',
            'apellidos' => 'required|string|max:255|min:2',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'foto_perfil' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'name.max' => 'El nombre no puede exceder 255 caracteres',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'apellidos.min' => 'Los apellidos deben tener al menos 2 caracteres',
            'apellidos.max' => 'Los apellidos no pueden exceder 255 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe ser una dirección válida',
            'email.unique' => 'Este email ya está registrado',
            'foto_perfil.image' => 'El archivo debe ser una imagen',
            'foto_perfil.mimes' => 'La imagen debe ser formato JPG, PNG o WEBP',
            'foto_perfil.max' => 'La imagen no puede exceder 2MB',
        ]);

        $usuario->name = $request->name;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;

        // Procesar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto antigua si existe
            if ($usuario->foto_perfil && file_exists(public_path($usuario->foto_perfil))) {
                unlink(public_path($usuario->foto_perfil));
            }

            // Crear directorio si no existe
            $directory = public_path('img/avatares');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // Guardar nueva foto
            $file = $request->file('foto_perfil');
            $filename = 'avatar_' . $usuario->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $usuario->foto_perfil = 'img/avatares/' . $filename;
        }

        $usuario->save();

        return response()->json([
            'success' => true,
            'message' => 'Perfil actualizado correctamente',
            'usuario' => [
                'id' => $usuario->id,
                'name' => $usuario->name,
                'apellidos' => $usuario->apellidos,
                'email' => $usuario->email,
                'rol' => $usuario->rol,
                'foto_perfil' => $usuario->foto_perfil ? asset($usuario->foto_perfil) : asset('img/avatares/default-avatar.png'),
            ]
        ]);
    }

    /**
     * Obtener notificaciones del usuario
     */
    public function obtenerNotificaciones(Request $request)
    {
        $usuario = Auth::user();
        
        $notificaciones = Notificacion::where('user_id', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'notificaciones' => $notificaciones->items(),
            'total' => $notificaciones->total(),
            'no_leidas' => Notificacion::where('user_id', $usuario->id)->where('leida', false)->count(),
        ]);
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarNotificacionLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        // Verificar que la notificación pertenece al usuario autenticado
        if ($notificacion->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para acceder a esta notificación'
            ], 403);
        }

        $notificacion->leida = true;
        $notificacion->save();

        return response()->json([
            'success' => true,
            'message' => 'Notificación marcada como leída'
        ]);
    }

    /**
     * Marcar todas las notificaciones como leídas
     */
    public function marcarTodasLeidas()
    {
        $usuario = Auth::user();

        Notificacion::where('user_id', $usuario->id)
            ->where('leida', false)
            ->update(['leida' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Todas las notificaciones marcadas como leídas'
        ]);
    }

    /**
     * Eliminar notificación
     */
    public function eliminarNotificacion($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        // Verificar que la notificación pertenece al usuario autenticado
        if ($notificacion->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permiso para eliminar esta notificación'
            ], 403);
        }

        $notificacion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notificación eliminada'
        ]);
    }
}
