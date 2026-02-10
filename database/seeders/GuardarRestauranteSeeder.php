<?php

namespace Database\Seeders;

use App\Models\GuardarRestaurante;
use App\Models\User;
use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuardarRestauranteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = User::where('rol', 'usuario')->pluck('id')->all();
        $restaurantes = Restaurante::pluck('id')->all();

        // Usuario 1
        GuardarRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[3],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[5],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[14],
        ]);

        // Usuario 2
        GuardarRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[1],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[7],
        ]);

        // Usuario 3
        GuardarRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[0],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[2],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[6],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[12],
        ]);

        // Usuario 4
        GuardarRestaurante::create([
            'user_id' => $usuarios[3],
            'restaurante_id' => $restaurantes[4],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[3],
            'restaurante_id' => $restaurantes[9],
        ]);

        // Usuario 5
        GuardarRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[1],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[11],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[13],
        ]);

        // Usuario 6
        GuardarRestaurante::create([
            'user_id' => $usuarios[5],
            'restaurante_id' => $restaurantes[0],
        ]);

        // Usuario 7
        GuardarRestaurante::create([
            'user_id' => $usuarios[6],
            'restaurante_id' => $restaurantes[2],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[6],
            'restaurante_id' => $restaurantes[8],
        ]);

        // Usuario 8
        GuardarRestaurante::create([
            'user_id' => $usuarios[7],
            'restaurante_id' => $restaurantes[4],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[7],
            'restaurante_id' => $restaurantes[10],
        ]);
        GuardarRestaurante::create([
            'user_id' => $usuarios[7],
            'restaurante_id' => $restaurantes[14],
        ]);
    }
}
