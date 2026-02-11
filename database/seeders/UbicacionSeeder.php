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

        // Additional 10 ubicaciones
        Ubicacion::create([
            'comunidad_autonoma' => 'Cataluña',
            'provincia' => 'Girona',
            'ciudad' => 'Girona',
            'codigo_postal' => '17001',
            'latitud' => 41.9794,
            'longitud' => 2.8214,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Comunidad Valenciana',
            'provincia' => 'Alicante',
            'ciudad' => 'Alicante',
            'codigo_postal' => '03001',
            'latitud' => 38.3453,
            'longitud' => -0.4831,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Granada',
            'ciudad' => 'Granada',
            'codigo_postal' => '18001',
            'latitud' => 37.1773,
            'longitud' => -3.5986,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Aragón',
            'provincia' => 'Zaragoza',
            'ciudad' => 'Zaragoza',
            'codigo_postal' => '50001',
            'latitud' => 41.6488,
            'longitud' => -0.8891,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Extremadura',
            'provincia' => 'Cáceres',
            'ciudad' => 'Cáceres',
            'codigo_postal' => '10001',
            'latitud' => 39.4753,
            'longitud' => -6.3724,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Castilla y León',
            'provincia' => 'Salamanca',
            'ciudad' => 'Salamanca',
            'codigo_postal' => '37001',
            'latitud' => 40.9701,
            'longitud' => -5.6635,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Cantabria',
            'provincia' => 'Cantabria',
            'ciudad' => 'Santander',
            'codigo_postal' => '39001',
            'latitud' => 43.4623,
            'longitud' => -3.8100,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Región de Murcia',
            'provincia' => 'Murcia',
            'ciudad' => 'Murcia',
            'codigo_postal' => '30001',
            'latitud' => 37.9922,
            'longitud' => -1.1307,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Castilla-La Mancha',
            'provincia' => 'Toledo',
            'ciudad' => 'Toledo',
            'codigo_postal' => '45001',
            'latitud' => 39.8628,
            'longitud' => -4.0273,
        ]);

        Ubicacion::create([
            'comunidad_autonoma' => 'Andalucía',
            'provincia' => 'Cádiz',
            'ciudad' => 'Cádiz',
            'codigo_postal' => '11001',
            'latitud' => 36.5271,
            'longitud' => -6.2886,
        ]);
    }
}
