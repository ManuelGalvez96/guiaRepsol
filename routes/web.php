<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RestauranteController;

Route::get('/', function () {
    return view('index');
});

Route::view('/login', 'log.login')->name('login');
Route::view('/register', 'log.register')->name('register');

<<<<<<< HEAD
// Ruta temporal para login (redirecciona al admin por ahora)
Route::post('/login', function () {
    return redirect()->route('admin.index');
})->name('login.post');

// Rutas del panel de administración
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{restaurante}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{restaurante}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{restaurante}', [AdminController::class, 'destroy'])->name('destroy');
=======
// Rutas protegidas - Solo accesibles para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/restaurantes', [RestauranteController::class, 'index'])->name('restaurantes');
    Route::get('/restaurante/{id}', [RestauranteController::class, 'show'])->name('restaurante.detalle');
>>>>>>> 2f67ab647dcac0975f6facda47090743018609a9
});

// Rutas para formulario de registro de restaurantes
Route::get('/formulario', [RestauranteController::class, 'create'])->name('formulario');
Route::post('/restaurantes', [RestauranteController::class, 'store'])->name('restaurantes.store');
