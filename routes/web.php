<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\RestauranteController;

Route::get('/', function () {
    return view('index');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthUser::class, 'showLogin'])->name('login');
Route::post('/login', [AuthUser::class, 'login'])->name('login.post');
Route::get('/register', [AuthUser::class, 'showRegister'])->name('register');
Route::post('/register', [AuthUser::class, 'register'])->name('register.post');
Route::post('/logout', [AuthUser::class, 'logout'])->name('logout');

// Ruta protegida - Solo accesible para usuarios autenticados (Descomentar cuando se implemente autenticación)
// Route::middleware('auth')->group(function () {
//     Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
// });

// Ruta temporal sin protección para desarrollo (Eliminar después de implementar autenticación)
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
Route::get('/restaurante/{id}', [RestauranteController::class, 'show'])->name('restaurante.detalle');

