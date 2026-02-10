<?php

namespace Database\Seeders;

use App\Models\LikeRestaurante;
use App\Models\User;
use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeRestauranteSeeder extends Seeder
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
        LikeRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[0],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[3],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[5],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[8],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[0],
            'restaurante_id' => $restaurantes[14],
        ]);

        // Usuario 2
        LikeRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[1],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[4],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[7],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[1],
            'restaurante_id' => $restaurantes[10],
        ]);

        // Usuario 3
        LikeRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[0],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[2],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[6],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[2],
            'restaurante_id' => $restaurantes[12],
        ]);

        // Usuario 4
        LikeRestaurante::create([
            'user_id' => $usuarios[3],
            'restaurante_id' => $restaurantes[3],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[3],
            'restaurante_id' => $restaurantes[4],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[3],
            'restaurante_id' => $restaurantes[9],
        ]);

        // Usuario 5
        LikeRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[1],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[5],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[11],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[4],
            'restaurante_id' => $restaurantes[13],
        ]);

        // Usuario 6
        LikeRestaurante::create([
            'user_id' => $usuarios[5],
            'restaurante_id' => $restaurantes[0],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[5],
            'restaurante_id' => $restaurantes[7],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[5],
            'restaurante_id' => $restaurantes[14],
        ]);

        // Usuario 7
        LikeRestaurante::create([
            'user_id' => $usuarios[6],
            'restaurante_id' => $restaurantes[2],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[6],
            'restaurante_id' => $restaurantes[6],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[6],
            'restaurante_id' => $restaurantes[8],
        ]);

        // Usuario 8
        LikeRestaurante::create([
            'user_id' => $usuarios[7],
            'restaurante_id' => $restaurantes[4],
        ]);
        LikeRestaurante::create([
            'user_id' => $usuarios[7],
            'restaurante_id' => $restaurantes[10],
        ]);
    }
}
