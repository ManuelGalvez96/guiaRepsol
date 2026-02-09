<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('index');
});

Route::view('/login', 'log.login')->name('login');
Route::view('/register', 'log.register')->name('register');

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
});
