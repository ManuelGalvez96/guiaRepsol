<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\TipoComida;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestauranteTipoComidaSeeder extends Seeder
{
    public function run(): void
    {
        $restaurantes = Restaurante::where('estado', 'aceptado')->get();
        $tiposComida = TipoComida::all();

        foreach ($restaurantes as $restaurante) {
            // Asignar 2-4 tipos de comida aleatorios a cada restaurante
            $numTipos = rand(2, 4);
            $tiposAsignados = $tiposComida->random($numTipos)->pluck('id')->toArray();
            
            $restaurante->tiposComida()->attach($tiposAsignados);
        }
    }
}
