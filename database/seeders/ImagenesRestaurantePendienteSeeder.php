<?php

namespace Database\Seeders;

use App\Models\ImagenRestaurantePendiente;
use App\Models\RestaurantePendiente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagenesRestaurantePendienteSeeder extends Seeder
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

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[0],
            'url' => 'pendientes/laparrillaurbana-1.jpg',
            'alt' => 'Foto principal La Parilla Urbana',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[0],
            'url' => 'pendientes/laparrillaurbana-2.jpg',
            'alt' => 'Interior La Parilla Urbana',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[1],
            'url' => 'pendientes/mercatbites-1.jpg',
            'alt' => 'Plato principal Mercat Bites',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[2],
            'url' => 'pendientes/patioguadalquivir-1.jpg',
            'alt' => 'Salon Patio del Guadalquivir',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[3],
            'url' => 'pendientes/racodelturia-1.jpg',
            'alt' => 'Arroces Raco del Turia',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurantePendiente::create([
            'restaurante_pendiente_id' => $restauranteIds[3],
            'url' => 'pendientes/racodelturia-2.jpg',
            'alt' => 'Mesa Raco del Turia',
            'principal' => false,
            'orden' => 2,
        ]);
    }
}
