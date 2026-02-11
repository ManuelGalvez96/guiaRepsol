<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestauranteController;
use App\Http\Controllers\AuthUser;

Route::get('/', function () {
    return view('index');
});

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
});

// Rutas protegidas - Solo accesibles para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
    Route::get('/restaurante/{id}', [RestauranteController::class, 'show'])->name('restaurante.detalle');
});

// Rutas para formulario de registro de restaurantes
Route::get('/formulario', [RestauranteController::class, 'create'])->name('formulario');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
