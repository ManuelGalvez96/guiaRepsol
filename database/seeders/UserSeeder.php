<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'apellidos' => 'Sistema',
            'email' => 'admin@guiarepsol.com',
            'password' => Hash::make('admin123'),
            'rol' => 'administrador',
        ]);

        User::create([
            'name' => 'Carlos',
            'apellidos' => 'García López',
            'email' => 'gerente1@restaurant.com',
            'password' => Hash::make('gerente123'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'María',
            'apellidos' => 'Rodríguez Pérez',
            'email' => 'gerente2@restaurant.com',
            'password' => Hash::make('gerente123'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Juan',
            'apellidos' => 'Martínez Sánchez',
            'email' => 'gerente3@restaurant.com',
            'password' => Hash::make('gerente123'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Ana',
            'apellidos' => 'Fernández Gómez',
            'email' => 'gerente4@restaurant.com',
            'password' => Hash::make('gerente123'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Pedro',
            'apellidos' => 'López Martín',
            'email' => 'gerente5@restaurant.com',
            'password' => Hash::make('gerente123'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Laura',
            'apellidos' => 'González Ruiz',
            'email' => 'usuario@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Diego',
            'apellidos' => 'Sánchez',
            'email' => 'usuario2@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Sofía',
            'apellidos' => 'Pérez',
            'email' => 'usuario3@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Javier',
            'apellidos' => 'García',
            'email' => 'usuario4@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Elena',
            'apellidos' => 'López',
            'email' => 'usuario5@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Roberto',
            'apellidos' => 'González',
            'email' => 'usuario6@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Isabel',
            'apellidos' => 'Martínez',
            'email' => 'usuario7@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Francisco',
            'apellidos' => 'Rodríguez',
            'email' => 'usuario8@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Marta',
            'apellidos' => 'Hernández',
            'email' => 'usuario9@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Antonio',
            'apellidos' => 'Jiménez',
            'email' => 'usuario10@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rosa',
            'apellidos' => 'Díaz',
            'email' => 'usuario11@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Miguel',
            'apellidos' => 'Ramos',
            'email' => 'usuario12@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Andrea',
            'apellidos' => 'Ruiz',
            'email' => 'usuario13@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Raúl',
            'apellidos' => 'Moreno',
            'email' => 'usuario14@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Patricia',
            'apellidos' => 'Navarro',
            'email' => 'usuario15@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Alfonso',
            'apellidos' => 'Vargas',
            'email' => 'usuario16@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Beatriz',
            'apellidos' => 'Castillo',
            'email' => 'usuario17@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Vicente',
            'apellidos' => 'Rojas',
            'email' => 'usuario18@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Catalina',
            'apellidos' => 'Molina',
            'email' => 'usuario19@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Luis',
            'apellidos' => 'Domínguez',
            'email' => 'usuario20@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Dolores',
            'apellidos' => 'Rivera',
            'email' => 'usuario21@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Ángel',
            'apellidos' => 'Vázquez',
            'email' => 'usuario22@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Francisca',
            'apellidos' => 'Torres',
            'email' => 'usuario23@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Gonzalo',
            'apellidos' => 'Ortiz',
            'email' => 'usuario24@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Magdalena',
            'apellidos' => 'Flores',
            'email' => 'usuario25@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Enrique',
            'apellidos' => 'Silva',
            'email' => 'usuario26@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Concepción',
            'apellidos' => 'Santos',
            'email' => 'usuario27@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rafael',
            'apellidos' => 'Campos',
            'email' => 'usuario28@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Amparo',
            'apellidos' => 'Medina',
            'email' => 'usuario29@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Eugenio',
            'apellidos' => 'Reyes',
            'email' => 'usuario30@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Casilda',
            'apellidos' => 'Guerrero',
            'email' => 'usuario31@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Agustín',
            'apellidos' => 'Herrera',
            'email' => 'usuario32@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rosario',
            'apellidos' => 'Fernández',
            'email' => 'usuario33@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Gregorio',
            'apellidos' => 'Salazar',
            'email' => 'usuario34@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Trinidad',
            'apellidos' => 'Figueroa',
            'email' => 'usuario35@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Marino',
            'apellidos' => 'Bravo',
            'email' => 'usuario36@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Esperanza',
            'apellidos' => 'Fuentes',
            'email' => 'usuario37@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Heriberto',
            'apellidos' => 'Carrillo',
            'email' => 'usuario38@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Soledad',
            'apellidos' => 'Palacios',
            'email' => 'usuario39@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Leopoldo',
            'apellidos' => 'Suárez',
            'email' => 'usuario40@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Carmen',
            'apellidos' => 'Ramírez',
            'email' => 'usuario41@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Aurelio',
            'apellidos' => 'Beltrán',
            'email' => 'usuario42@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Milagros',
            'apellidos' => 'Crespo',
            'email' => 'usuario43@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Jesús',
            'apellidos' => 'Gómez',
            'email' => 'usuario44@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Virtudes',
            'apellidos' => 'Estrada',
            'email' => 'usuario45@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Olegario',
            'apellidos' => 'Vega',
            'email' => 'usuario46@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Encarnación',
            'apellidos' => 'Segura',
            'email' => 'usuario47@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Otilio',
            'apellidos' => 'Valenzuela',
            'email' => 'usuario48@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Paz',
            'apellidos' => 'Lozano',
            'email' => 'usuario49@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Diego',
            'apellidos' => 'López',
            'email' => 'usuario50@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Sofía',
            'apellidos' => 'García',
            'email' => 'usuario51@example.com',
            'password' => Hash::make('usuario123'),
            'rol' => 'usuario',
        ]);
    }
}
