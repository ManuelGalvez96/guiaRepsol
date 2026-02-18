<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin',
            'apellidos' => 'Sistema',
            'email' => 'admin@guiarepsol.com',
            'password' => Hash::make('password'),
            'rol' => 'administrador',
        ]);

        // Gerentes reales
        User::create([
            'name' => 'Carlos',
            'apellidos' => 'García López',
            'email' => 'carlos.garcia@restaurante.es',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'María',
            'apellidos' => 'Rodríguez Pérez',
            'email' => 'maria.rodriguez@restaurante.es',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Juan',
            'apellidos' => 'Martínez Sánchez',
            'email' => 'juan.martinez@restaurante.es',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Ana',
            'apellidos' => 'Fernández Gómez',
            'email' => 'ana.fernandez@restaurante.es',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        User::create([
            'name' => 'Pedro',
            'apellidos' => 'López Martín',
            'email' => 'pedro.lopez@restaurante.es',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        // Usuario con email del desarrollador
        User::create([
            'name' => 'Diego',
            'apellidos' => 'Zenon Developer',
            'email' => 'darkzenon89@gmail.com',
            'password' => Hash::make('password'),
            'rol' => 'gerente',
        ]);

        // Usuarios normales
        User::create([
            'name' => 'Laura',
            'apellidos' => 'González Ruiz',
            'email' => 'laura.gonzalez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Diego',
            'apellidos' => 'Sánchez Martín',
            'email' => 'diego.sanchez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Sofía',
            'apellidos' => 'Pérez García',
            'email' => 'sofia.perez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Javier',
            'apellidos' => 'García López',
            'email' => 'javier.garcia@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Elena',
            'apellidos' => 'López Fernández',
            'email' => 'elena.lopez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Roberto',
            'apellidos' => 'González Rodríguez',
            'email' => 'roberto.gonzalez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Isabel',
            'apellidos' => 'Martínez Pérez',
            'email' => 'isabel.martinez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Francisco',
            'apellidos' => 'Rodríguez García',
            'email' => 'francisco.rodriguez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Marta',
            'apellidos' => 'Hernández López',
            'email' => 'marta.hernandez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Antonio',
            'apellidos' => 'Jiménez García',
            'email' => 'antonio.jimenez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rosa',
            'apellidos' => 'Díaz Rodríguez',
            'email' => 'rosa.diaz@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Miguel',
            'apellidos' => 'Ramos García',
            'email' => 'miguel.ramos@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Andrea',
            'apellidos' => 'Ruiz López',
            'email' => 'andrea.ruiz@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Raúl',
            'apellidos' => 'Moreno García',
            'email' => 'raul.moreno@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Patricia',
            'apellidos' => 'Navarro Pérez',
            'email' => 'patricia.navarro@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Alfonso',
            'apellidos' => 'Vargas García',
            'email' => 'alfonso.vargas@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Beatriz',
            'apellidos' => 'Castillo López',
            'email' => 'beatriz.castillo@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Vicente',
            'apellidos' => 'Rojas García',
            'email' => 'vicente.rojas@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Catalina',
            'apellidos' => 'Molina Pérez',
            'email' => 'catalina.molina@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Luis',
            'apellidos' => 'Domínguez García',
            'email' => 'luis.dominguez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Dolores',
            'apellidos' => 'Rivera López',
            'email' => 'dolores.rivera@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Ángel',
            'apellidos' => 'Vázquez García',
            'email' => 'angel.vazquez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Francisca',
            'apellidos' => 'Torres López',
            'email' => 'francisca.torres@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Gonzalo',
            'apellidos' => 'Ortiz García',
            'email' => 'gonzalo.ortiz@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Magdalena',
            'apellidos' => 'Flores López',
            'email' => 'magdalena.flores@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Enrique',
            'apellidos' => 'Silva García',
            'email' => 'enrique.silva@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Concepción',
            'apellidos' => 'Santos López',
            'email' => 'concepcion.santos@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rafael',
            'apellidos' => 'Campos García',
            'email' => 'rafael.campos@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Amparo',
            'apellidos' => 'Medina López',
            'email' => 'amparo.medina@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Eugenio',
            'apellidos' => 'Reyes García',
            'email' => 'eugenio.reyes@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Casilda',
            'apellidos' => 'Guerrero López',
            'email' => 'casilda.guerrero@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Agustín',
            'apellidos' => 'Herrera García',
            'email' => 'agustin.herrera@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Rosario',
            'apellidos' => 'Fernández López',
            'email' => 'rosario.fernandez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Gregorio',
            'apellidos' => 'Salazar García',
            'email' => 'gregorio.salazar@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Trinidad',
            'apellidos' => 'Figueroa López',
            'email' => 'trinidad.figueroa@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Marino',
            'apellidos' => 'Bravo García',
            'email' => 'marino.bravo@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Esperanza',
            'apellidos' => 'Fuentes López',
            'email' => 'esperanza.fuentes@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Heriberto',
            'apellidos' => 'Carrillo García',
            'email' => 'heriberto.carrillo@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Soledad',
            'apellidos' => 'Palacios López',
            'email' => 'soledad.palacios@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Leopoldo',
            'apellidos' => 'Suárez García',
            'email' => 'leopoldo.suarez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Carmen',
            'apellidos' => 'Ramírez López',
            'email' => 'carmen.ramirez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Aurelio',
            'apellidos' => 'Beltrán García',
            'email' => 'aurelio.beltran@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Milagros',
            'apellidos' => 'Crespo López',
            'email' => 'milagros.crespo@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Jesús',
            'apellidos' => 'Gómez García',
            'email' => 'jesus.gomez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Virtudes',
            'apellidos' => 'Estrada López',
            'email' => 'virtudes.estrada@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Olegario',
            'apellidos' => 'Vega García',
            'email' => 'olegario.vega@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Encarnación',
            'apellidos' => 'Segura López',
            'email' => 'encarnacion.segura@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Otilio',
            'apellidos' => 'Valenzuela García',
            'email' => 'otilio.valenzuela@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Paz',
            'apellidos' => 'Lozano López',
            'email' => 'paz.lozano@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Javier',
            'apellidos' => 'López García',
            'email' => 'javier.lopez@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);

        User::create([
            'name' => 'Sofía',
            'apellidos' => 'García López',
            'email' => 'sofia.garcia@email.com',
            'password' => Hash::make('password'),
            'rol' => 'usuario',
        ]);
    }
}

