<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/login', 'log.login')->name('login');

// Ruta protegida - Solo accesible para usuarios autenticados (Descomentar cuando se implemente autenticación)
// Route::middleware('auth')->group(function () {
//     Route::get('/restaurantes', function () {
//         return view('restaurantes');
//     })->name('restaurantes');
// });

// Ruta temporal sin protección para desarrollo (Eliminar después de implementar autenticación)
Route::get('/restaurantes', function () {
    return view('restaurantes');
})->name('restaurantes');

