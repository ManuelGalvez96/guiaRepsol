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
        if (count($usuarios) < 8 || count($restaurantes) < 15) {
            return;
        }

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

        // Additional likes to reach 50+
        if (count($usuarios) > 8 && count($restaurantes) > 35) {
            LikeRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[15],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[18],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[22],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[9],
                'restaurante_id' => $restaurantes[16],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[9],
                'restaurante_id' => $restaurantes[19],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[9],
                'restaurante_id' => $restaurantes[25],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[17],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[20],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[21],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[11],
                'restaurante_id' => $restaurantes[23],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[11],
                'restaurante_id' => $restaurantes[24],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[12],
                'restaurante_id' => $restaurantes[26],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[12],
                'restaurante_id' => $restaurantes[27],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[12],
                'restaurante_id' => $restaurantes[28],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[13],
                'restaurante_id' => $restaurantes[29],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[13],
                'restaurante_id' => $restaurantes[30],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[14],
                'restaurante_id' => $restaurantes[31],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[14],
                'restaurante_id' => $restaurantes[32],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[14],
                'restaurante_id' => $restaurantes[33],
            ]);

            LikeRestaurante::create([
                'user_id' => $usuarios[15],
                'restaurante_id' => $restaurantes[34],
            ]);
            LikeRestaurante::create([
                'user_id' => $usuarios[15],
                'restaurante_id' => $restaurantes[35],
            ]);

            if (count($usuarios) > 16 && count($restaurantes) > 45) {
                LikeRestaurante::create([
                    'user_id' => $usuarios[16],
                    'restaurante_id' => $restaurantes[36],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[16],
                    'restaurante_id' => $restaurantes[37],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[16],
                    'restaurante_id' => $restaurantes[38],
                ]);

                LikeRestaurante::create([
                    'user_id' => $usuarios[17],
                    'restaurante_id' => $restaurantes[39],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[17],
                    'restaurante_id' => $restaurantes[40],
                ]);

                LikeRestaurante::create([
                    'user_id' => $usuarios[18],
                    'restaurante_id' => $restaurantes[41],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[18],
                    'restaurante_id' => $restaurantes[42],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[18],
                    'restaurante_id' => $restaurantes[43],
                ]);

                LikeRestaurante::create([
                    'user_id' => $usuarios[19],
                    'restaurante_id' => $restaurantes[44],
                ]);
                LikeRestaurante::create([
                    'user_id' => $usuarios[19],
                    'restaurante_id' => $restaurantes[45],
                ]);
            }
        }
    }
}
