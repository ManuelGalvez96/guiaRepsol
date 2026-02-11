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

        // Additional saves to reach 50+
        if (count($usuarios) > 8) {
            GuardarRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[15],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[18],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[8],
                'restaurante_id' => $restaurantes[22],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[9],
                'restaurante_id' => $restaurantes[16],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[9],
                'restaurante_id' => $restaurantes[25],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[3],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[17],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[10],
                'restaurante_id' => $restaurantes[21],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[11],
                'restaurante_id' => $restaurantes[19],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[11],
                'restaurante_id' => $restaurantes[23],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[11],
                'restaurante_id' => $restaurantes[27],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[12],
                'restaurante_id' => $restaurantes[20],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[12],
                'restaurante_id' => $restaurantes[24],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[13],
                'restaurante_id' => $restaurantes[26],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[13],
                'restaurante_id' => $restaurantes[28],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[13],
                'restaurante_id' => $restaurantes[30],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[14],
                'restaurante_id' => $restaurantes[29],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[14],
                'restaurante_id' => $restaurantes[31],
            ]);

            GuardarRestaurante::create([
                'user_id' => $usuarios[15],
                'restaurante_id' => $restaurantes[32],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[15],
                'restaurante_id' => $restaurantes[33],
            ]);
            GuardarRestaurante::create([
                'user_id' => $usuarios[15],
                'restaurante_id' => $restaurantes[34],
            ]);

            if (count($usuarios) > 16) {
                GuardarRestaurante::create([
                    'user_id' => $usuarios[16],
                    'restaurante_id' => $restaurantes[35],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[16],
                    'restaurante_id' => $restaurantes[36],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[17],
                    'restaurante_id' => $restaurantes[37],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[17],
                    'restaurante_id' => $restaurantes[38],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[17],
                    'restaurante_id' => $restaurantes[39],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[18],
                    'restaurante_id' => $restaurantes[40],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[18],
                    'restaurante_id' => $restaurantes[41],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[19],
                    'restaurante_id' => $restaurantes[42],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[19],
                    'restaurante_id' => $restaurantes[43],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[19],
                    'restaurante_id' => $restaurantes[44],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[20],
                    'restaurante_id' => $restaurantes[45],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[20],
                    'restaurante_id' => $restaurantes[46],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[21],
                    'restaurante_id' => $restaurantes[47],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[21],
                    'restaurante_id' => $restaurantes[48],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[22],
                    'restaurante_id' => $restaurantes[49],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[22],
                    'restaurante_id' => $restaurantes[3],
                ]);

                GuardarRestaurante::create([
                    'user_id' => $usuarios[23],
                    'restaurante_id' => $restaurantes[5],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[23],
                    'restaurante_id' => $restaurantes[15],
                ]);
                GuardarRestaurante::create([
                    'user_id' => $usuarios[23],
                    'restaurante_id' => $restaurantes[25],
                ]);
            }
        }
    }
}
