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
        $password = Hash::make('Ejp2021#');

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

        // Additional 24 usuarios
        User::create([
            'name' => 'Luis Navarro',
            'email' => 'luis.navarro@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Carmen Ortiz',
            'email' => 'carmen.ortiz@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Sergio Ramírez',
            'email' => 'sergio.ramirez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Alicia Herrera',
            'email' => 'alicia.herrera@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Pablo Castro',
            'email' => 'pablo.castro@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Silvia Romero',
            'email' => 'silvia.romero@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Alberto Suárez',
            'email' => 'alberto.suarez@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Rosa Iglesias',
            'email' => 'rosa.iglesias@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Rubén Gil',
            'email' => 'ruben.gil@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Nuria Serrano',
            'email' => 'nuria.serrano@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Adrián Molina',
            'email' => 'adrian.molina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Mónica Vargas',
            'email' => 'monica.vargas@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Álvaro Mendoza',
            'email' => 'alvaro.mendoza@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Teresa Campos',
            'email' => 'teresa.campos@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Gonzalo Ramos',
            'email' => 'gonzalo.ramos@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Sandra Flores',
            'email' => 'sandra.flores@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Marcos Ortega',
            'email' => 'marcos.ortega@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Pilar Santos',
            'email' => 'pilar.santos@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Diego Prieto',
            'email' => 'diego.prieto@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Verónica Cabrera',
            'email' => 'veronica.cabrera@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Ignacio Vidal',
            'email' => 'ignacio.vidal@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Gloria Reyes',
            'email' => 'gloria.reyes@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Óscar Aguilar',
            'email' => 'oscar.aguilar@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);

        User::create([
            'name' => 'Irene Medina',
            'email' => 'irene.medina@email.com',
            'email_verified_at' => now(),
            'rol' => 'usuario',
            'password' => $password,
        ]);
    }
}
