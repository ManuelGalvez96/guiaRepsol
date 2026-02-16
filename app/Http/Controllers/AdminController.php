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
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $restaurante = Restaurante::create($validated);

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
            
            // Si el usuario no es gerente, cambiar su rol a gerente
            $usuario = \App\Models\User::find($pendiente->user_id);
            if ($usuario && $usuario->rol !== 'gerente') {
                $usuario->update(['rol' => 'gerente']);
            }
            
            // Migrar imágenes: trasladar de img/restaurantes/pendiente/ a img/restaurantes/
            $imagenesPendientes = ImagenRestaurantePendiente::where('restaurante_pendiente_id', $id)->get();
            foreach ($imagenesPendientes as $imagenPendiente) {
                $oldPath = $imagenPendiente->url;
                
                // Cambiar ruta de: img/restaurantes/pendiente/archivo.jpg a img/restaurantes/archivo.jpg
                $newPath = str_replace('img/restaurantes/pendiente/', 'img/restaurantes/', $oldPath);
                
                // Obtener rutas completas usando public_path()
                $oldFullPath = public_path($oldPath);
                $newFullPath = public_path($newPath);
                
                // Mover archivo del sistema de archivos
                if (File::exists($oldFullPath)) {
                    // Asegurar que la carpeta destino existe
                    $destDir = dirname($newFullPath);
                    if (!File::isDirectory($destDir)) {
                        File::makeDirectory($destDir, 0755, true);
                    }
                    // Mover el archivo
                    File::move($oldFullPath, $newFullPath);
                }
                
                // Crear registro de imagen en tabla restaurantes con la nueva ruta
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => $newPath,  // Ruta actualizada en la BD
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
}
