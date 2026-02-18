<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LikeRestauranteSeeder extends Seeder
{
    public function run(): void
    {
        $restaurantes = Restaurante::where('estado', 'aceptado')->get();
        $usuarios = User::where('rol', 'usuario')->get();

        if ($usuarios->isEmpty()) {
            return;
        }

        foreach ($usuarios as $usuario) {
            // Cada usuario da like a 5-15 restaurantes aleatorios
            $numLikes = rand(5, 15);
            $restaurantesAleatorios = $restaurantes->random(min($numLikes, $restaurantes->count()));

            foreach ($restaurantesAleatorios as $restaurante) {
                DB::table('tbl_likes_restaurantes')->insert([
                    'user_id' => $usuario->id,
                    'restaurante_id' => $restaurante->id,
                    'created_at' => now()->subDays(rand(1, 90)),
                    'updated_at' => now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }
}
