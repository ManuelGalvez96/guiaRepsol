<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private function checkAdmin()
    {
        $user = Auth::user();
        
        if (!$user) {
            redirect()->route('login')->withErrors(['error' => 'Debes iniciar sesión para acceder a esta sección.'])->send();
        }
        
        if ($user->rol !== 'administrador') {
            redirect()->route('restaurantes')->withErrors(['error' => 'No tienes permisos para acceder a esta sección.'])->send();
        }
    }

    /**
     * Mostrar listado de usuarios
     */
    public function index(Request $request)
    {
        $this->checkAdmin();
        
        $query = User::query();

        // Filtro de búsqueda
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('name', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('apellidos', 'LIKE', '%' . $buscar . '%')
                  ->orWhere('email', 'LIKE', '%' . $buscar . '%');
            });
        }

        // Filtro de rol
        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        $usuarios = $query->orderBy('created_at', 'desc')->paginate(15);

        // Si es petición AJAX, devolver JSON con HTML
        if ($request->ajax() || $request->input('ajax')) {
            $currentUserId = Auth::id();
            
            // Generar HTML de la tabla
            $tablaHtml = $this->generarTablaHtml($usuarios, $currentUserId);
            
            // Generar HTML de paginación
            $paginacionHtml = $this->generarPaginacionHtml($usuarios);
            
            return response()->json([
                'success' => true,
                'html' => $tablaHtml,
                'pagination' => $paginacionHtml,
                'total' => $usuarios->total()
            ]);
        }

        return view('admin.usuarios.index', compact('usuarios'));
    }
    
    /**
     * Generar HTML de la tabla
     */
    private function generarTablaHtml($usuarios, $currentUserId)
    {
        if ($usuarios->count() === 0) {
            return '<div style="padding: 40px; text-align: center; color: #999;"><p style="font-size: 16px;">✗ No se encontraron usuarios con los criterios de búsqueda.</p></div>';
        }
        
        $html = '<table style="width: 100%; border-collapse: collapse;">';
        $html .= '<thead style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">';
        $html .= '<tr>';
        $html .= '<th style="padding: 12px; text-align: left; font-weight: 600;">Nombre</th>';
        $html .= '<th style="padding: 12px; text-align: left; font-weight: 600;">Email</th>';
        $html .= '<th style="padding: 12px; text-align: center; font-weight: 600;">Rol</th>';
        $html .= '<th style="padding: 12px; text-align: center; font-weight: 600;">Fecha de Registro</th>';
        $html .= '<th style="padding: 12px; text-align: center; font-weight: 600;">Acciones</th>';
        $html .= '</tr></thead><tbody>';
        
        foreach ($usuarios as $usuario) {
            $html .= '<tr style="border-bottom: 1px solid #dee2e6;">';
            $html .= '<td style="padding: 12px;"><div style="font-weight: 500;">' . e($usuario->name . ' ' . $usuario->apellidos) . '</div></td>';
            $html .= '<td style="padding: 12px; color: #666;">' . e($usuario->email) . '</td>';
            
            // Badge de rol
            $html .= '<td style="padding: 12px; text-align: center;">';
            if ($usuario->rol === 'administrador') {
                $html .= '<span class="badge badge-admin">👤 Admin</span>';
            } elseif ($usuario->rol === 'gerente') {
                $html .= '<span class="badge badge-gerente">🏪 Gerente</span>';
            } else {
                $html .= '<span class="badge badge-usuario">👥 Usuario</span>';
            }
            $html .= '</td>';
            
            $html .= '<td style="padding: 12px; text-align: center; color: #666; font-size: 13px;">' . $usuario->created_at->format('d/m/Y H:i') . '</td>';
            
            // Acciones
            $html .= '<td style="padding: 12px; text-align: center;">';
            $html .= '<button class="btn btn-sm btn-primary actions-btn" onclick="abrirModalEditar(' . $usuario->id . ')" title="Editar">✏️</button>';
            
            if ($usuario->id !== $currentUserId) {
                $html .= '<button class="btn btn-sm btn-danger actions-btn" onclick="confirmarEliminar(' . $usuario->id . ')" title="Eliminar">🗑️</button>';
            }
            
            $html .= '</td></tr>';
        }
        
        $html .= '</tbody></table>';
        
        return $html;
    }
    
    /**
     * Generar HTML de paginación
     */
    private function generarPaginacionHtml($usuarios)
    {
        if (!$usuarios->hasPages()) {
            return '';
        }
        
        $html = '<div class="pagination">';

        // Botón anterior
        if ($usuarios->onFirstPage()) {
            $html .= '<span class="page-link page-disabled">«</span>';
        } else {
            $html .= '<a href="#" class="page-link" data-page="' . ($usuarios->currentPage() - 1) . '">«</a>';
        }

        // Primera página
        if ($usuarios->currentPage() > 3) {
            $html .= '<a href="#" class="page-link" data-page="1">1</a>';
            if ($usuarios->currentPage() > 4) {
                $html .= '<span class="page-dots">...</span>';
            }
        }

        // Páginas alrededor de la actual
        for ($page = max(1, $usuarios->currentPage() - 2); $page <= min($usuarios->lastPage(), $usuarios->currentPage() + 2); $page++) {
            if ($page == $usuarios->currentPage()) {
                $html .= '<span class="page-link active">' . $page . '</span>';
            } else {
                $html .= '<a href="#" class="page-link" data-page="' . $page . '">' . $page . '</a>';
            }
        }

        // Última página
        if ($usuarios->currentPage() < $usuarios->lastPage() - 2) {
            if ($usuarios->currentPage() < $usuarios->lastPage() - 3) {
                $html .= '<span class="page-dots">...</span>';
            }
            $html .= '<a href="#" class="page-link" data-page="' . $usuarios->lastPage() . '">' . $usuarios->lastPage() . '</a>';
        }

        // Botón siguiente
        if ($usuarios->hasMorePages()) {
            $html .= '<a href="#" class="page-link" data-page="' . ($usuarios->currentPage() + 1) . '">»</a>';
        } else {
            $html .= '<span class="page-link page-disabled">»</span>';
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Formulario para crear nuevo usuario
     */
    public function create()
    {
        $this->checkAdmin();
        return view('admin.usuarios.create');
    }

    /**
     * Guardar nuevo usuario
     */
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:100',
                'apellidos' => 'required|string|min:2|max:100',
                'email' => 'required|email|unique:users,email',
                'rol' => 'required|in:administrador,gerente,usuario',
                'password' => 'required|string|min:6|confirmed',
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.min' => 'El nombre debe tener al menos 2 caracteres.',
                'name.max' => 'El nombre no puede exceder 100 caracteres.',
                'apellidos.required' => 'Los apellidos son obligatorios.',
                'apellidos.min' => 'Los apellidos deben tener al menos 2 caracteres.',
                'apellidos.max' => 'Los apellidos no pueden exceder 100 caracteres.',
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'El email debe tener un formato válido.',
                'email.unique' => 'Este email ya está registrado.',
                'rol.required' => 'El rol es obligatorio.',
                'rol.in' => 'El rol seleccionado no es válido.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        try {
            User::create([
                'name' => $validated['name'],
                'apellidos' => $validated['apellidos'],
                'email' => $validated['email'],
                'rol' => $validated['rol'],
                'password' => Hash::make($validated['password']),
            ]);

            // Si es AJAX, devolver JSON
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario creado exitosamente.'
                ]);
            }

            return redirect()->route('admin.usuarios.index')
                ->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el usuario: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Error al crear el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Formulario para editar usuario
     */
    public function edit(Request $request, User $usuario)
    {
        $this->checkAdmin();
        
        // Si es petición AJAX, devolver datos en JSON
        if ($request->ajax() || $request->input('ajax')) {
            return response()->json([
                'success' => true,
                'usuario' => [
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'apellidos' => $usuario->apellidos,
                    'email' => $usuario->email,
                    'rol' => $usuario->rol,
                    'created_at' => $usuario->created_at->format('d/m/Y H:i')
                ]
            ]);
        }
        
        return view('admin.usuarios.edit', compact('usuario'));
    }

    /**
     * Actualizar usuario
     */
    public function update(Request $request, User $usuario)
    {
        $this->checkAdmin();
        
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:100',
                'apellidos' => 'required|string|min:2|max:100',
                'email' => 'required|email|unique:users,email,' . $usuario->id,
                'rol' => 'required|in:administrador,gerente,usuario',
                'password' => 'nullable|string|min:6|confirmed',
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'name.min' => 'El nombre debe tener al menos 2 caracteres.',
                'name.max' => 'El nombre no puede exceder 100 caracteres.',
                'apellidos.required' => 'Los apellidos son obligatorios.',
                'apellidos.min' => 'Los apellidos deben tener al menos 2 caracteres.',
                'apellidos.max' => 'Los apellidos no pueden exceder 100 caracteres.',
                'email.required' => 'El email es obligatorio.',
                'email.email' => 'El email debe tener un formato válido.',
                'email.unique' => 'Este email ya está registrado.',
                'rol.required' => 'El rol es obligatorio.',
                'rol.in' => 'El rol seleccionado no es válido.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        try {
            $usuario->update([
                'name' => $validated['name'],
                'apellidos' => $validated['apellidos'],
                'email' => $validated['email'],
                'rol' => $validated['rol'],
            ]);

            if ($request->filled('password')) {
                $usuario->update(['password' => Hash::make($validated['password'])]);
            }

            // Si es AJAX, devolver JSON
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario actualizado exitosamente.'
                ]);
            }

            return redirect()->route('admin.usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Error al actualizar el usuario: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar usuario
     */
    public function destroy(User $usuario)
    {
        $this->checkAdmin();

        // No permitir eliminar el usuario admin actual
        if ($usuario->id === Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes eliminar tu propia cuenta.'
            ], 403);
        }

        try {
            // Si el usuario es gerente, verificar si tiene restaurantes asociados
            if ($usuario->rol === 'gerente') {
                $restaurantesAsociados = DB::table('restaurantes')
                    ->where('user_id', $usuario->id)
                    ->count();
                
                if ($restaurantesAsociados > 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes eliminar este gerente porque tiene restaurantes asociados.'
                    ], 409);
                }
            }

            $usuario->delete();

            return response()->json([
                'success' => true,
                'message' => 'Usuario eliminado exitosamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}
