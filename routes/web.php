<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestauranteController;

Route::get('/', function () {
    return view('index');
});

Route::view('/login', 'log.login')->name('login');

// Ruta protegida - Solo accesible para usuarios autenticados (Descomentar cuando se implemente autenticación)
// Route::middleware('auth')->group(function () {
//     Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
// });

// Ruta temporal sin protección para desarrollo (Eliminar después de implementar autenticación)
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');

