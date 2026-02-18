<?php

namespace Database\Seeders;

use App\Models\Ubicacion;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    public function run(): void
    {
        Ubicacion::create([
            'comunidad_autonoma' => 'Comunidad de Madrid',
            'provincia' => 'Madrid',
            'ciudad' => 'Madrid',
            'codigo_postal' => '28001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'País Vasco',
            'provincia' => 'Guipúzcoa',
            'ciudad' => 'San Sebastián',
            'codigo_postal' => '20001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Cataluña',
            'provincia' => 'Barcelona',
            'ciudad' => 'Barcelona',
            'codigo_postal' => '08001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Comunidad Valenciana',
            'provincia' => 'Valencia',
            'ciudad' => 'Valencia',
            'codigo_postal' => '46001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Málaga',
            'ciudad' => 'Málaga',
            'codigo_postal' => '29001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Sevilla',
            'ciudad' => 'Sevilla',
            'codigo_postal' => '41001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Galicia',
            'provincia' => 'A Coruña',
            'ciudad' => 'Santiago de Compostela',
            'codigo_postal' => '15701',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Castilla y León',
            'provincia' => 'Valladolid',
            'ciudad' => 'Valladolid',
            'codigo_postal' => '47001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Castilla y León',
            'provincia' => 'Segovia',
            'ciudad' => 'Segovia',
            'codigo_postal' => '40001',
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Islas Baleares',
            'provincia' => 'Islas Baleares',
            'ciudad' => 'Palma de Mallorca',
            'codigo_postal' => '07001',
        ]);
    }
}
