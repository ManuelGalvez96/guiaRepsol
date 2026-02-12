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
            'name' => 'María',
            'apellidos' => 'García López',
            'email' => 'maria.garcia@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Roberto',
            'apellidos' => 'Sánchez',
            'email' => 'roberto.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Victoria',
            'apellidos' => 'Ruiz Navarro',
            'email' => 'victoria.ruiz@email.com',
            'email_verified_at' => now(),
            'rol' => 'administrador',
            'password' => $password,
        ]);

        // 15 Gerentes (uno por restaurante)
        User::create([
            'name' => 'Juan',
            'apellidos' => 'Martínez Pérez',
            'email' => 'juan.martinez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ana',
            'apellidos' => 'López',
            'email' => 'ana.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Carlos',
            'apellidos' => 'Fernández García',
            'email' => 'carlos.fernandez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Laura',
            'apellidos' => 'Sánchez',
            'email' => 'laura.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Andrés',
            'apellidos' => 'Martín Díaz',
            'email' => 'andres.martin@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Isabel',
            'apellidos' => 'Rodríguez',
            'email' => 'isabel.rodriguez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Pedro',
            'apellidos' => 'Jiménez Ruiz',
            'email' => 'pedro.jimenez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'María',
            'apellidos' => 'Pérez',
            'email' => 'maria.perez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Miguel',
            'apellidos' => 'Torres Sánchez',
            'email' => 'miguel.torres@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Sofia',
            'apellidos' => 'González Moreno',
            'email' => 'sofia.gonzalez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ricardo',
            'apellidos' => 'López',
            'email' => 'ricardo.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Elena',
            'apellidos' => 'García Fernández',
            'email' => 'elena.garcia@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Francisco',
            'apellidos' => 'Sánchez',
            'email' => 'francisco.sanchez@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Beatriz',
            'apellidos' => 'Ruiz Torres',
            'email' => 'beatriz.ruiz@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Javier',
            'apellidos' => 'Moreno',
            'email' => 'javier.moreno@email.com',
            'email_verified_at' => now(),
            'rol' => 'gerente',
            'password' => $password,
        ]);

        // Usuarios normales
        User::create([
            'name' => 'David',
            'apellidos' => 'Jiménez Vega',
            'email' => 'david.jimenez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Patricia',
            'apellidos' => 'Martín',
            'email' => 'patricia.martin@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Enrique',
            'apellidos' => 'Gómez Ramírez',
            'email' => 'enrique.gomez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Marta',
            'apellidos' => 'López',
            'email' => 'marta.lopez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Fernando',
            'apellidos' => 'Blanco Castro',
            'email' => 'fernando.blanco@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Cristina',
            'apellidos' => 'Vega',
            'email' => 'cristina.vega@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ángel',
            'apellidos' => 'Delgado Prieto',
            'email' => 'angel.delgado@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Raquel',
            'apellidos' => 'Morales',
            'email' => 'raquel.morales@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Carlos',
            'apellidos' => 'Medina Ortiz',
            'email' => 'carlos.medina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Lucia',
            'apellidos' => 'Romero',
            'email' => 'lucia.romero@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'David',
            'apellidos' => 'Navarro Iglesias',
            'email' => 'david.navarro@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Paula',
            'apellidos' => 'Cabrera',
            'email' => 'paula.cabrera@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Hector',
            'apellidos' => 'Salas Ramos',
            'email' => 'hector.salas@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Silvia',
            'apellidos' => 'Pardo',
            'email' => 'silvia.pardo@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ruben',
            'apellidos' => 'Molina Herrera',
            'email' => 'ruben.molina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Clara',
            'apellidos' => 'Santos',
            'email' => 'clara.santos@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);
    }
}
