<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\PerfilController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Rutas de autenticación
Route::get('/pre-login', [AuthUser::class, 'preLogin'])->name('pre-login');
Route::get('/login', [AuthUser::class, 'showLogin'])->name('login');
Route::post('/login', [AuthUser::class, 'login'])->name('login.post');
Route::get('/register', [AuthUser::class, 'showRegister'])->name('register');
Route::post('/register', [AuthUser::class, 'register'])->name('register.post');
Route::post('/logout', [AuthUser::class, 'logout'])->name('logout');

// Rutas del panel de administración
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de restaurantes
    Route::get('/restaurantes', [AdminController::class, 'index'])->name('index');
    Route::get('/restaurantes/create', [AdminController::class, 'create'])->name('create');
    Route::post('/restaurantes', [AdminController::class, 'store'])->name('store');
    Route::get('/restaurantes/{restaurante}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/restaurantes/{restaurante}', [AdminController::class, 'update'])->name('update');
    Route::delete('/restaurantes/{restaurante}', [AdminController::class, 'destroy'])->name('destroy');
    
    // Gestión de usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    
    // Solicitudes de negocio (restaurantes pendientes)
    Route::get('/solicitudes', [AdminController::class, 'solicitudes'])->name('solicitudes');
    Route::post('/solicitudes/{id}/aprobar', [AdminController::class, 'aprobarSolicitud'])->name('solicitudes.aprobar');
    Route::delete('/solicitudes/{id}/rechazar', [AdminController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
    
    // Denuncias de valoraciones
    Route::get('/denuncias', [AdminController::class, 'verDenuncias'])->name('denuncias.index');
    Route::get('/denuncias/{id}', [AdminController::class, 'revisarDenuncia'])->name('denuncias.revisar');
    Route::post('/denuncias/{id}/resolver', [AdminController::class, 'resolverDenuncia'])->name('denuncias.resolver');
    
    // Solicitudes de eliminación de restaurantes
    Route::get('/solicitudes-eliminacion', [AdminController::class, 'verSolicitudesEliminacion'])->name('solicitudes-eliminacion.index');
    Route::post('/solicitudes-eliminacion/{id}/responder', [AdminController::class, 'responderSolicitudEliminacion'])->name('solicitudes-eliminacion.responder');
    
    // Previews de emails
    Route::get('/restaurantes/{restaurante}/email-preview-modificado', [AdminController::class, 'emailPreviewModificado'])->name('emailPreview.modificado');
    Route::get('/restaurantes/{restaurante}/email-preview-eliminado', [AdminController::class, 'emailPreviewEliminado'])->name('emailPreview.eliminado');
});

// Rutas protegidas - Solo accesibles para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
    Route::get('/restaurante/{id}', [RestauranteController::class, 'show'])->name('restaurante.detalle');
    
    // Rutas de perfil y notificaciones
    Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil.show');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
    Route::get('/notificaciones', [PerfilController::class, 'obtenerNotificaciones'])->name('notificaciones.obtener');
    Route::put('/notificaciones/{id}/leida', [PerfilController::class, 'marcarNotificacionLeida'])->name('notificaciones.leida');
    Route::put('/notificaciones/marcar-todas-leidas', [PerfilController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar-todas');
    Route::delete('/notificaciones/{id}', [PerfilController::class, 'eliminarNotificacion'])->name('notificaciones.eliminar');
    
    // Rutas de valoraciones
    Route::post('/restaurante/{id}/valoracion', [ValoracionController::class, 'store'])->name('valoracion.store');
    Route::put('/valoracion/{id}', [ValoracionController::class, 'update'])->name('valoracion.update');
    Route::delete('/valoracion/{id}', [ValoracionController::class, 'destroy'])->name('valoracion.destroy');
    Route::post('/valoracion/{id}/responder', [ValoracionController::class, 'responder'])->name('valoracion.responder');
    Route::delete('/valoracion/{id}/respuesta', [ValoracionController::class, 'eliminarRespuesta'])->name('valoracion.eliminarRespuesta');
    Route::post('/valoracion/{id}/reportar', [ValoracionController::class, 'reportar'])->name('valoracion.reportar');
    
    // Rutas de likes y guardados
    Route::post('/restaurante/{id}/like', [RestauranteController::class, 'toggleLike'])->name('restaurante.like');
    Route::post('/restaurante/{id}/guardar', [RestauranteController::class, 'toggleGuardar'])->name('restaurante.guardar');
    Route::get('/restaurantes-guardados', [RestauranteController::class, 'guardados'])->name('restaurantes.guardados');
    
    // Solicitar eliminación de restaurante (solo gerentes)
    Route::post('/restaurante/{id}/solicitar-eliminacion', [RestauranteController::class, 'solicitarEliminacion'])->name('restaurante.solicitar-eliminacion');
    
    // Ruta para actualizar restaurante (solo gerentes)
    Route::post('/restaurante/{id}', [RestauranteController::class, 'update'])->name('restaurante.update');
    Route::delete('/imagen-slider/{id}', [RestauranteController::class, 'eliminarImagenSlider'])->name('imagen.slider.delete');
});

// Rutas para formulario de registro de restaurantes
Route::get('/formulario', [RestauranteController::class, 'create'])->name('formulario');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
