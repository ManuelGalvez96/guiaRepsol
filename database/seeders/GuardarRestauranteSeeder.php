<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuardarRestauranteSeeder extends Seeder
{
    public function run(): void
    {
        $restaurantes = Restaurante::where('estado', 'aceptado')->get();
        $usuarios = User::where('rol', 'usuario')->get();

        if ($usuarios->isEmpty()) {
            return;
        }

        foreach ($usuarios as $usuario) {
            // Cada usuario guarda 3-10 restaurantes aleatorios
            $numGuardados = rand(3, 10);
            $restaurantesAleatorios = $restaurantes->random(min($numGuardados, $restaurantes->count()));

            foreach ($restaurantesAleatorios as $restaurante) {
                DB::table('guardar_restaurantes')->insert([
                    'user_id' => $usuario->id,
                    'restaurante_id' => $restaurante->id,
                    'created_at' => now()->subDays(rand(1, 90)),
                    'updated_at' => now()->subDays(rand(1, 90)),
                ]);
            }
        }
    }
}
