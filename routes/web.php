<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\AuthUser;
=======
use App\Http\Controllers\RestauranteController;
>>>>>>> 47bf0a336164b4a41f0942c4d8ca5cbfe446a010

Route::get('/', function () {
    return view('welcome');
})->name('home');

<<<<<<< HEAD
// Rutas de autenticación
Route::get('/login', [AuthUser::class, 'showLogin'])->name('login');
Route::post('/login', [AuthUser::class, 'login'])->name('login.post');
Route::post('/logout', [AuthUser::class, 'logout'])->name('logout');

Route::get('/register', [AuthUser::class, 'showRegister'])->name('register');
Route::post('/register', [AuthUser::class, 'register'])->name('register.post');
=======
Route::view('/login', 'log.login')->name('login');

// Ruta protegida - Solo accesible para usuarios autenticados (Descomentar cuando se implemente autenticación)
// Route::middleware('auth')->group(function () {
//     Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
// });

// Ruta temporal sin protección para desarrollo (Eliminar después de implementar autenticación)
Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');

>>>>>>> 47bf0a336164b4a41f0942c4d8ca5cbfe446a010
