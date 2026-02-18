<?php

namespace App\Http\Controllers;

use App\Models\Restaurante;
use App\Models\Categoria;
use App\Models\TipoComida;
use App\Models\Ubicacion;
use App\Models\ImagenRestaurante;
use App\Models\DenunciaValoracion;
use App\Models\SolicitudEliminacionRestaurante;
use App\Mail\Restaurante_Modificado_o_eliminado;
use App\Mail\Restaurante_Eliminado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
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
     * Dashboard principal del administrador con estadísticas
     */
    public function dashboard()
    {
        $this->checkAdmin();
        
        // Estadísticas generales
        $totalRestaurantes = Restaurante::where('estado', 'aceptado')->count();
        $restaurantesPendientes = Restaurante::where('estado', 'pendiente')->count();
        $restaurantesRechazados = Restaurante::where('estado', 'rechazado')->count();
        $totalValoraciones = DB::table('valoraciones')->count();
        $totalUsuarios = DB::table('users')->where('rol', 'usuario')->count();
        
        // Restaurantes mejor valorados
        $mejoresRestaurantes = Restaurante::where('estado', 'aceptado')
            ->orderBy('valoracion_promedio', 'desc')
            ->take(5)
            ->get();
        
        // Últimas valoraciones (CORREGIDO: usar usuario_id en lugar de user_id)
        $ultimasValoraciones = DB::table('valoraciones')
            ->join('restaurantes', 'valoraciones.restaurante_id', '=', 'restaurantes.id')
            ->join('users', 'valoraciones.usuario_id', '=', 'users.id')
            ->select('valoraciones.*', 'restaurantes.nombre as restaurante_nombre', 'users.name as usuario_nombre')
            ->orderBy('valoraciones.created_at', 'desc')
            ->take(10)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalRestaurantes',
            'restaurantesPendientes', 
            'restaurantesRechazados',
            'totalValoraciones',
            'totalUsuarios',
            'mejoresRestaurantes',
            'ultimasValoraciones'
        ));
    }

    /**
     * Listado de restaurantes (antes era el index)
     */
    public function index(Request $request)
    {
        $this->checkAdmin();
        $query = Restaurante::with(['categoria', 'ubicacion', 'imagenes', 'tiposComida']);

        // Filtro de búsqueda por nombre del restaurante o gerente
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', '%' . $buscar . '%')
                  ->orWhereHas('gerente', function($qGerente) use ($buscar) {
                      $qGerente->where('name', 'LIKE', '%' . $buscar);
                  });
            });
        }

        // Filtro de estado (todos por defecto)
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
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

        return view('admin.restaurantes', compact('restaurantes', 'categorias', 'tiposComida'));
    }

    /**
     * Solicitudes de restaurantes pendientes
     */
    public function solicitudes(Request $request)
    {
        $this->checkAdmin();
        $perPage = $request->input('per_page', 10);
        
        // Obtener restaurantes con estado 'pendiente'
        $solicitudes = Restaurante::with(['categoria', 'ubicacion', 'imagenes', 'tiposComida', 'gerente'])
            ->where('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->except('page'));

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
            'descripcion' => 'nullable|min:100|string',
            'user_id' => 'required|exists:users,id',
            'categoria_id' => 'required|exists:categorias,id',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email',
            'web' => 'nullable|url',
            'precio' => 'required|numeric',
            'soles' => 'nullable|integer|min:0|max:3',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Crear restaurante con estado 'aceptado' por defecto (creado por admin)
        $dataRestaurante = $validated;
        $dataRestaurante['estado'] = 'aceptado';
        
        $restaurante = Restaurante::create($dataRestaurante);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        }

        // Guardar imágenes si se subieron
        if ($request->hasFile('imagenes')) {
            $orden = 0;
            $directory = public_path('img/restaurantes');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            foreach ($request->file('imagenes') as $imagen) {
                $filename = uniqid('rest_') . '.' . $imagen->getClientOriginalExtension();
                $imagen->move($directory, $filename);
                $path = 'img/restaurantes/' . $filename;
                
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => $path,
                    'alt' => $restaurante->nombre,
                    'principal' => $orden === 0, // Primera imagen es principal
                    'orden' => $orden++
                ]);
            }
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
            'descripcion' => 'nullable|min:100|string',
            'user_id' => 'required|exists:users,id',
            'categoria_id' => 'required|exists:categorias,id',
            'ubicacion_id' => 'required|exists:ubicaciones,id',
            'direccion' => 'required|string',
            'telefono' => 'nullable|string',
            'email' => 'required|email|unique:restaurantes,email,' . $restaurante->id,
            'web' => 'nullable|url',
            'precio' => 'required|numeric',
            'soles' => 'nullable|integer|min:0|max:3',
            'tipos_comida' => 'nullable|array',
            'tipos_comida.*' => 'exists:tipo_comida,id',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'imagenes_eliminar' => 'nullable|string', // IDs separados por comas
            'imagenes_estado' => 'nullable|string', // JSON con cambios de estado
        ]);

        $restaurante->update($validated);

        // Sincronizar tipos de comida
        if ($request->has('tipos_comida')) {
            $restaurante->tiposComida()->sync($request->tipos_comida);
        } else {
            $restaurante->tiposComida()->detach();
        }

        // Manejar eliminación de imágenes específicas
        if ($request->filled('imagenes_eliminar')) {
            $imagenesAEliminar = explode(',', $request->imagenes_eliminar);
            $imagenesAEliminar = array_filter($imagenesAEliminar, 'is_numeric'); // Filtrar solo números
            
            if (!empty($imagenesAEliminar)) {
                $imagenesExistentes = ImagenRestaurante::where('restaurante_id', $restaurante->id)
                    ->whereIn('id', $imagenesAEliminar)
                    ->get();
                    
                foreach ($imagenesExistentes as $imagen) {
                    // Eliminar archivo físico
                    if (Storage::disk('public')->exists($imagen->url)) {
                        Storage::disk('public')->delete($imagen->url);
                    }
                    // Eliminar registro de BD
                    $imagen->delete();
                }
            }
        }

        // Manejar cambios de estado (Principal/Adicional) de imágenes existentes
        if ($request->filled('imagenes_estado')) {
            $cambiosEstado = json_decode($request->imagenes_estado, true);
            
            if (is_array($cambiosEstado)) {
                // Verificar que siempre haya al menos una imagen Principal
                $tienePrincipal = false;
                $imagenesActuales = $restaurante->imagenes()->pluck('id')->toArray();
                
                // Contar cuántas serán principales después de los cambios
                foreach ($cambiosEstado as $imagenId => $estado) {
                    if ((int)$estado === 1) {
                        $tienePrincipal = true;
                        break;
                    }
                }
                
                // Si no hay principal en los cambios, verificar que no se eliminen todas las principales
                if (!$tienePrincipal) {
                    // Verificar si hay alguna principal que no esté siendo modificada
                    $principalSinCambios = $restaurante->imagenes()
                        ->where('principal', true)
                        ->whereNotIn('id', array_keys($cambiosEstado))
                        ->exists();
                    
                    if (!$principalSinCambios) {
                        return back()->withErrors(['imagenes' => 'Debes tener al menos una imagen Principal. No puedes dejar todas como Adicionales.'])->withInput();
                    }
                }
                
                foreach ($cambiosEstado as $imagenId => $estado) {
                    $imagen = ImagenRestaurante::where('restaurante_id', $restaurante->id)
                        ->where('id', (int)$imagenId)
                        ->first();
                    
                    if ($imagen) {
                        // Si se marcó como principal, quitar principal de otras imágenes
                        if ($estado == 1 && !$imagen->principal) {
                            $restaurante->imagenes()->update(['principal' => false]);
                            $imagen->update(['principal' => true]);
                        } elseif ($estado == 0 && $imagen->principal) {
                            // Si hay otras imágenes, asignar principal a la primera
                            $imagen->update(['principal' => false]);
                            $primeraImagen = $restaurante->imagenes()->where('id', '!=', $imagenId)->first();
                            if ($primeraImagen) {
                                $primeraImagen->update(['principal' => true]);
                            }
                        }
                    }
                }
            }
        }

        // Agregar nuevas imágenes si se subieron
        if ($request->hasFile('imagenes')) {
            // Obtener el orden máximo actual para continuar la numeración
            $maxOrden = $restaurante->imagenes()->max('orden') ?? -1;
            $orden = $maxOrden + 1;
            
            // Verificar si hay una imagen principal existente
            $tienePrincipal = $restaurante->imagenes()->where('principal', true)->exists();

            $directory = public_path('img/restaurantes');
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
            }
            
            foreach ($request->file('imagenes') as $imagen) {
                $filename = uniqid('rest_') . '.' . $imagen->getClientOriginalExtension();
                $imagen->move($directory, $filename);
                $path = 'img/restaurantes/' . $filename;
                
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => $path,
                    'alt' => $restaurante->nombre,
                    'principal' => !$tienePrincipal && $orden == ($maxOrden + 1), // Primera nueva imagen es principal si no há ninguna
                    'orden' => $orden++
                ]);
                
                $tienePrincipal = true; // Marcar que ya hay principal
            }
        }

        $restaurante->loadMissing('usuario');
        // Solo los administradores pueden enviar estos correos de notificación
        $recipientEmail = $restaurante->usuario?->email;
        if ($recipientEmail) {
            Mail::to($recipientEmail)->send(new Restaurante_Modificado_o_eliminado($restaurante));
        } else {
            Log::warning('No se pudo enviar email: usuario o email no disponible.', [
                'restaurante_id' => $restaurante->id,
                'user_id' => $restaurante->user_id,
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

    /**
     * Aprobar solicitud de restaurante (cambiar estado a 'aceptado')
     */
    public function aprobarSolicitud($id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);
            
            // Cambiar estado a aceptado
            $restaurante->update(['estado' => 'aceptado']);
            
            // Si el usuario no es gerente, cambiar su rol a gerente
            $usuario = \App\Models\User::find($restaurante->user_id);
            if ($usuario && $usuario->rol !== 'gerente' && $usuario->rol !== 'administrador') {
                $usuario->update(['rol' => 'gerente']);
            }
            
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
    
    /**
     * Rechazar solicitud de restaurante (cambiar estado a 'rechazado')
     */
    public function rechazarSolicitud($id)
    {
        try {
            $restaurante = Restaurante::findOrFail($id);
            
            // Cambiar estado a rechazado
            $restaurante->update(['estado' => 'rechazado']);
            
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
        
        $restaurante->loadMissing('usuario');
        $recipientEmail = $restaurante->usuario?->email;
        $nombreRestaurante = $restaurante->nombre;
        $restauranteId = $restaurante->id;
        $userId = $restaurante->user_id;  // Guardar antes de eliminar
        
        $restaurante->delete();

        // Enviar email de eliminación solo a administradores
        if ($recipientEmail) {
            try {
                Mail::to($recipientEmail)->send(new Restaurante_Eliminado($nombreRestaurante, $restauranteId));
            } catch (\Exception $e) {
                Log::error('Error al enviar email de eliminación: ' . $e->getMessage(), [
                    'restaurante_id' => $restauranteId,
                    'user_id' => $userId,
                ]);
            }
        } else {
            Log::warning('No se pudo enviar email de eliminación: usuario o email no disponible.', [
                'restaurante_id' => $restauranteId,
                'user_id' => $userId,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Restaurante eliminado exitosamente'
            ]);
        }
        return Redirect::route('admin.index')->with('success', 'Restaurante eliminado exitosamente');
    }

    public function emailPreviewModificado(Restaurante $restaurante)
    {
        $this->checkAdmin();
        $restaurante->loadMissing('usuario');
        return view('emails.restaurante_modificado_o_eliminado', ['restaurante' => $restaurante]);
    }

    public function emailPreviewEliminado(Restaurante $restaurante)
    {
        $this->checkAdmin();
        return view('emails.restaurante_eliminado', [
            'nombre' => $restaurante->nombre,
            'restaurante_id' => $restaurante->id
        ]);
    }

    /**
     * Ver denuncias/reportes de valoraciones
     */
    public function verDenuncias(Request $request)
    {
        $this->checkAdmin();

        $query = DenunciaValoracion::with(['usuario', 'valoracion' => function($q) {
            $q->with(['restaurante' => function($r) {
                $r->select('id', 'nombre');
            }, 'usuario' => function($u) {
                $u->select('id', 'name', 'apellidos');
            }]);
        }]);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        } else {
            // Por defecto mostrar pendientes
            $query->where('estado', 'pendiente');
        }

        $denuncias = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.denuncias', compact('denuncias'));
    }

    /**
     * Revisar una denuncia específica
     */
    public function revisarDenuncia(Request $request, $id)
    {
        $this->checkAdmin();

        $denuncia = DenunciaValoracion::with(['usuario', 'valoracion' => function($q) {
            $q->with(['restaurante', 'usuario']);
        }])->findOrFail($id);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'denuncia' => $denuncia
            ]);
        }

        return view('admin.revisar-denuncia', compact('denuncia'));
    }

    /**
     * Resolver una denuncia (aceptar o rechazar)
     */
    public function resolverDenuncia(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'accion' => 'required|in:aceptar,rechazar',
        ]);

        $denuncia = DenunciaValoracion::findOrFail($id);

        try {
            DB::beginTransaction();

            $accion = $request->accion;

            if ($accion === 'aceptar') {
                // Eliminar la valoración reportada
                $valoracion = $denuncia->valoracion;
                if ($valoracion) {
                    $restauranteId = $valoracion->restaurante_id;
                    $valoracion->delete();

                    // Actualizar valoración promedio del restaurante
                    $this->actualizarValoracionPromedio($restauranteId);
                }

                $denuncia->update(['estado' => 'revisado']);
            } else {
                // Rechazar denuncia
                $denuncia->update(['estado' => 'rechazado']);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Denuncia resuelta correctamente.'
                ]);
            }

            return redirect()->route('admin.denuncias')->with('success', 'Denuncia resuelta correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error al resolver la denuncia.'], 500);
            }
            return redirect()->back()->with('error', 'Error al resolver la denuncia.');
        }
    }

    /**
     * Ver solicitudes de eliminación de restaurantes
     */
    public function verSolicitudesEliminacion(Request $request)
    {
        $this->checkAdmin();

        $query = SolicitudEliminacionRestaurante::with(['restaurante', 'gerente', 'admin']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        } else {
            // Por defecto mostrar pendientes
            $query->where('estado', 'pendiente');
        }

        $solicitudes = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.solicitudes-eliminacion', compact('solicitudes'));
    }

    /**
     * Responder a una solicitud de eliminación
     */
    public function responderSolicitudEliminacion(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'accion' => 'required|in:aceptar,rechazar',
        ]);

        $solicitud = SolicitudEliminacionRestaurante::findOrFail($id);

        try {
            DB::beginTransaction();

            $accion = $request->accion;

            if ($accion === 'aceptar') {
                // Eliminar el restaurante
                $restaurante = $solicitud->restaurante;
                if ($restaurante) {
                    $restaurante->delete();
                }

                $solicitud->update([
                    'estado' => 'aceptada',
                    'admin_id' => Auth::id(),
                    'respondido_at' => now(),
                ]);
            } else {
                // Rechazar solicitud
                $solicitud->update([
                    'estado' => 'rechazada',
                    'admin_id' => Auth::id(),
                    'respondido_at' => now(),
                ]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Solicitud resuelta correctamente.'
                ]);
            }

            return redirect()->back()->with('success', 'Solicitud resuelta correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Error al resolver la solicitud.'], 500);
            }
            return redirect()->back()->with('error', 'Error al resolver la solicitud.');
        }
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
