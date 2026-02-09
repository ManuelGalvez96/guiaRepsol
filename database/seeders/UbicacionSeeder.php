<?php

namespace Database\Seeders;

use App\Models\Ubicacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicacionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ubicacion::create([
            'comunidad_autonoma' => 'Comunidad de Madrid',
            'provincia' => 'Madrid',
            'ciudad' => 'Madrid',
            'codigo_postal' => '28001',
            'latitud' => 40.4168,
            'longitud' => -3.7038,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'País Vasco',
            'provincia' => 'Guipúzcoa',
            'ciudad' => 'San Sebastián',
            'codigo_postal' => '20001',
            'latitud' => 43.3183,
            'longitud' => -1.9812,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Cataluña',
            'provincia' => 'Barcelona',
            'ciudad' => 'Barcelona',
            'codigo_postal' => '08001',
            'latitud' => 41.3851,
            'longitud' => 2.1734,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Comunidad Valenciana',
            'provincia' => 'Valencia',
            'ciudad' => 'Valencia',
            'codigo_postal' => '46001',
            'latitud' => 39.4699,
            'longitud' => -0.3763,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Málaga',
            'ciudad' => 'Marbella',
            'codigo_postal' => '29600',
            'latitud' => 36.5108,
            'longitud' => -4.8826,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Galicia',
            'provincia' => 'A Coruña',
            'ciudad' => 'Santiago de Compostela',
            'codigo_postal' => '15701',
            'latitud' => 42.8782,
            'longitud' => -8.5448,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Asturias',
            'provincia' => 'Asturias',
            'ciudad' => 'Oviedo',
            'codigo_postal' => '33001',
            'latitud' => 43.3603,
            'longitud' => -5.8448,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'País Vasco',
            'provincia' => 'Vizcaya',
            'ciudad' => 'Bilbao',
            'codigo_postal' => '48001',
            'latitud' => 43.2630,
            'longitud' => -2.9350,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Castilla y León',
            'provincia' => 'Valladolid',
            'ciudad' => 'Valladolid',
            'codigo_postal' => '47001',
            'latitud' => 41.6520,
            'longitud' => -4.7245,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Sevilla',
            'ciudad' => 'Sevilla',
            'codigo_postal' => '41001',
            'latitud' => 37.3886,
            'longitud' => -5.9823,
        ]);
    }
}
