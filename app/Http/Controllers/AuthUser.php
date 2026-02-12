<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthUser extends Controller
{
    public function preLogin()
    {
        return view('log.pre-login');
    }

    /**
     * Mostrar el formulario de login
     */
    public function showLogin()
    {
        return view('log.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirigir según el rol del usuario
            $user = Auth::user();
            
            return match($user->rol) {
                'administrador' => redirect()->route('admin.index'),
                'gerente' => redirect()->route('restaurantes'),
                'usuario' => redirect()->route('restaurantes'),
                default => redirect()->route('restaurantes'),
            };
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }

    /**
     * Procesar logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Mostrar el formulario de registro
     */
    public function showRegister()
    {
        return view('log.register');
    }

    /**
     * Procesar el registro de usuario
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
<<<<<<< HEAD
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8|same:password',
=======
            'password' => 'required|min:6|confirmed',
>>>>>>> 51c406c5331b52020739413100023956e4fd86ee
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'apellidos' => $validated['apellidos'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
<<<<<<< HEAD
            'password' => Hash::make($validated['password_confirmation']),
=======
            'rol' => 'usuario',
            'password' => Hash::make($validated['password']),
>>>>>>> 51c406c5331b52020739413100023956e4fd86ee
        ]);

        Auth::login($user);
        $request->session()->regenerate();

<<<<<<< HEAD
        return redirect('/restaurantes');
=======
        return redirect()->route('restaurantes');
>>>>>>> 51c406c5331b52020739413100023956e4fd86ee
    }
}
