<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\ValoracionController;
use App\Http\Controllers\AuthUser;

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
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/solicitudes', [AdminController::class, 'solicitudes'])->name('solicitudes');
    Route::post('/solicitudes/{id}/aprobar', [AdminController::class, 'aprobarSolicitud'])->name('solicitudes.aprobar');
    Route::delete('/solicitudes/{id}/rechazar', [AdminController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{restaurante}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{restaurante}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{restaurante}', [AdminController::class, 'destroy'])->name('destroy');
    Route::get('/{restaurante}/email-preview-modificado', [AdminController::class, 'emailPreviewModificado'])->name('emailPreview.modificado');
    Route::get('/{restaurante}/email-preview-eliminado', [AdminController::class, 'emailPreviewEliminado'])->name('emailPreview.eliminado');

    // Gestión de usuarios
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/crear', [AdminController::class, 'crearUsuario'])->name('usuarios.crear');
    Route::post('/usuarios', [AdminController::class, 'guardarUsuario'])->name('usuarios.guardar');
    Route::get('/usuarios/{id}/editar', [AdminController::class, 'editarUsuario'])->name('usuarios.editar');
    Route::put('/usuarios/{id}', [AdminController::class, 'actualizarUsuario'])->name('usuarios.actualizar');
    Route::delete('/usuarios/{id}', [AdminController::class, 'eliminarUsuario'])->name('usuarios.eliminar');
});

// Rutas protegidas - Solo accesibles para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
    Route::get('/restaurante/{id}', [RestauranteController::class, 'show'])->name('restaurante.detalle');
    
    // Rutas de valoraciones
    Route::post('/restaurante/{id}/valoracion', [ValoracionController::class, 'store'])->name('valoracion.store');
    Route::put('/valoracion/{id}', [ValoracionController::class, 'update'])->name('valoracion.update');
    Route::delete('/valoracion/{id}', [ValoracionController::class, 'destroy'])->name('valoracion.destroy');
    Route::post('/valoracion/{id}/responder', [ValoracionController::class, 'responder'])->name('valoracion.responder');
    Route::delete('/valoracion/{id}/respuesta', [ValoracionController::class, 'eliminarRespuesta'])->name('valoracion.eliminarRespuesta');
    
    // Rutas de likes y guardados
    Route::post('/restaurante/{id}/like', [RestauranteController::class, 'toggleLike'])->name('restaurante.like');
    Route::post('/restaurante/{id}/guardar', [RestauranteController::class, 'toggleGuardar'])->name('restaurante.guardar');
    Route::get('/restaurantes-guardados', [RestauranteController::class, 'guardados'])->name('restaurantes.guardados');
    
    // Ruta para actualizar restaurante (solo gerentes)
    Route::post('/restaurante/{id}', [RestauranteController::class, 'update'])->name('restaurante.update');
    Route::delete('/imagen-slider/{id}', [RestauranteController::class, 'eliminarImagenSlider'])->name('imagen.slider.delete');
});

// Rutas para formulario de registro de restaurantes
Route::get('/formulario', [RestauranteController::class, 'create'])->name('formulario');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
