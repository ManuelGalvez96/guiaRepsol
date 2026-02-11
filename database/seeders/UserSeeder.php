<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // Administradores
        User::create([
            'name' => 'María García',
            'email' => 'maria.garcia@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Roberto Sánchez',
            'email' => 'roberto.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Victoria Ruiz',
            'email' => 'victoria.ruiz@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        // 15 Gerentes (uno por restaurante)
        User::create([
            'name' => 'Juan Martínez',
            'email' => 'juan.martinez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ana López',
            'email' => 'ana.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Carlos Fernández',
            'email' => 'carlos.fernandez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Laura Sánchez',
            'email' => 'laura.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Andrés Martín',
            'email' => 'andres.martin@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Isabel Rodríguez',
            'email' => 'isabel.rodriguez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Pedro Jiménez',
            'email' => 'pedro.jimenez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'María Pérez',
            'email' => 'maria.perez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Miguel Torres',
            'email' => 'miguel.torres@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Sofia González',
            'email' => 'sofia.gonzalez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ricardo López',
            'email' => 'ricardo.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Elena García',
            'email' => 'elena.garcia@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Francisco Sánchez',
            'email' => 'francisco.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Beatriz Ruiz',
            'email' => 'beatriz.ruiz@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Javier Moreno',
            'email' => 'javier.moreno@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        // Usuarios normales
        User::create([
            'name' => 'David Jiménez',
            'email' => 'david.jimenez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Patricia Martín',
            'email' => 'patricia.martin@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Enrique Gómez',
            'email' => 'enrique.gomez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Marta López',
            'email' => 'marta.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Fernando Blanco',
            'email' => 'fernando.blanco@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Cristina Vega',
            'email' => 'cristina.vega@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ángel Delgado',
            'email' => 'angel.delgado@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Raquel Morales',
            'email' => 'raquel.morales@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Carlos Medina',
            'email' => 'carlos.medina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Lucia Romero',
            'email' => 'lucia.romero@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'David Navarro',
            'email' => 'david.navarro@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Paula Cabrera',
            'email' => 'paula.cabrera@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Hector Salas',
            'email' => 'hector.salas@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Silvia Pardo',
            'email' => 'silvia.pardo@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ruben Molina',
            'email' => 'ruben.molina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Clara Santos',
            'email' => 'clara.santos@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);
    }
}
