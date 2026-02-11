<?php

namespace Database\Seeders;

use App\Models\RestaurantePendiente;
use App\Models\TipoComidaRestaurantePendiente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoComidaRestaurantePendienteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restauranteIds = RestaurantePendiente::orderBy('id')->pluck('id')->all();
        if (count($restauranteIds) < 4) {
            return;
        }

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[0],
            'tipo_comida_id' => 1,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[0],
            'tipo_comida_id' => 3,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[1],
            'tipo_comida_id' => 2,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[1],
            'tipo_comida_id' => 5,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[2],
            'tipo_comida_id' => 1,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[2],
            'tipo_comida_id' => 4,
        ]);

        TipoComidaRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[3],
            'tipo_comida_id' => 2,
        ]);
    }
}
