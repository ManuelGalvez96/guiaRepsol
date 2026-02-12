<?php

namespace Database\Seeders;

use App\Models\UbicacionRestaurantePendiente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionRestaurantePendienteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UbicacionRestaurantePendiente::create([
            'comunidad_autonoma' => 'Comunidad de Madrid',
            'provincia' => 'Madrid',
            'ciudad' => 'Madrid',
            'codigo_postal' => '28012',
            'latitud' => 40.4115,
            'longitud' => -3.7030,
        ]);

        UbicacionRestaurantePendiente::create([
            'comunidad_autonoma' => 'Cataluna',
            'provincia' => 'Barcelona',
            'ciudad' => 'Barcelona',
            'codigo_postal' => '08015',
            'latitud' => 41.3874,
            'longitud' => 2.1686,
        ]);

        UbicacionRestaurantePendiente::create([
            'comunidad_autonoma' => 'Andalucia',
            'provincia' => 'Sevilla',
            'ciudad' => 'Sevilla',
            'codigo_postal' => '41010',
            'latitud' => 37.3858,
            'longitud' => -5.9841,
        ]);

        UbicacionRestaurantePendiente::create([
            'comunidad_autonoma' => 'Comunidad Valenciana',
            'provincia' => 'Valencia',
            'ciudad' => 'Valencia',
            'codigo_postal' => '46008',
            'latitud' => 39.4709,
            'longitud' => -0.3762,
        ]);
    }
}
