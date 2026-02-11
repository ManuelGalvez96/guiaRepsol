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
    
    // Rutas de valoraciones
    Route::post('/restaurante/{id}/valoracion', [ValoracionController::class, 'store'])->name('valoracion.store');
    Route::put('/valoracion/{id}', [ValoracionController::class, 'update'])->name('valoracion.update');
    Route::delete('/valoracion/{id}', [ValoracionController::class, 'destroy'])->name('valoracion.destroy');
    Route::post('/valoracion/{id}/responder', [ValoracionController::class, 'responder'])->name('valoracion.responder');
});

// Rutas para formulario de registro de restaurantes
Route::get('/formulario', [RestauranteController::class, 'create'])->name('formulario');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
