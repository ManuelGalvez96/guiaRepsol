<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ubicacion;

class UbicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ubicaciones = [
            ['comunidad_autonoma' => 'Comunidad de Madrid', 'provincia' => 'Madrid', 'ciudad' => 'Madrid', 'codigo_postal' => '28001'],
            ['comunidad_autonoma' => 'Cataluña', 'provincia' => 'Barcelona', 'ciudad' => 'Barcelona', 'codigo_postal' => '08001'],
            ['comunidad_autonoma' => 'Comunidad Valenciana', 'provincia' => 'Valencia', 'ciudad' => 'Valencia', 'codigo_postal' => '46001'],
            ['comunidad_autonoma' => 'Andalucía', 'provincia' => 'Sevilla', 'ciudad' => 'Sevilla', 'codigo_postal' => '41001'],
            ['comunidad_autonoma' => 'País Vasco', 'provincia' => 'Vizcaya', 'ciudad' => 'Bilbao', 'codigo_postal' => '48001'],
            ['comunidad_autonoma' => 'Andalucía', 'provincia' => 'Málaga', 'ciudad' => 'Málaga', 'codigo_postal' => '29001'],
        ];

        foreach ($ubicaciones as $ubicacion) {
            Ubicacion::create($ubicacion);
        }
    }
}
