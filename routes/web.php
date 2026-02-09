<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthUser;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas de autenticación
Route::get('/login', [AuthUser::class, 'showLogin'])->name('login');
Route::post('/login', [AuthUser::class, 'login'])->name('login.post');
Route::post('/logout', [AuthUser::class, 'logout'])->name('logout');

Route::get('/register', [AuthUser::class, 'showRegister'])->name('register');
Route::post('/register', [AuthUser::class, 'register'])->name('register.post');
