<?php

namespace Database\Seeders;

use App\Models\RestaurantePendiente;
use App\Models\UbicacionRestaurantePendiente;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantePendienteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarioIds = User::where('rol', 'usuario')->orderBy('id')->pluck('id')->all();
        $ubicacionIds = UbicacionRestaurantePendiente::orderBy('id')->pluck('id')->all();
        if (count($usuarioIds) < 4 || count($ubicacionIds) < 4) {
            return;
        }

        RestaurantePendiente::create([
            'nombre' => 'La Parilla Urbana',
            'descripcion' => 'Propuesta de cocina de brasas con menu corto y producto local.',
            'user_id' => $usuarioIds[0],
            'categoria_id' => 1,
            'ubicacion_pendiente_id' => $ubicacionIds[0],
            'direccion' => 'Calle de Atocha, 42',
            'telefono' => '910111222',
            'email' => 'laparrillaurbana@pendiente.com',
            'web' => 'https://www.laparrillaurbana.com',
            'precio' => 35.00,
            'soles' => 0,
            'valoracion_promedio' => 0,
            'patrocinados' => false,
            'activo' => true,
        ]);

        RestaurantePendiente::create([
            'nombre' => 'Mercat Bites',
            'descripcion' => 'Cocina creativa de mercado con platos para compartir.',
            'user_id' => $usuarioIds[1],
            'categoria_id' => 2,
            'ubicacion_pendiente_id' => $ubicacionIds[1],
            'direccion' => 'Carrer de Sepulveda, 120',
            'telefono' => '930222333',
            'email' => 'mercatbites@pendiente.com',
            'web' => 'https://www.mercatbites.com',
            'precio' => 42.50,
            'soles' => 0,
            'valoracion_promedio' => 0,
            'patrocinados' => false,
            'activo' => true,
        ]);

        RestaurantePendiente::create([
            'nombre' => 'Patio del Guadalquivir',
            'descripcion' => 'Cocina andaluza con toques actuales y carta de vinos regionales.',
            'user_id' => $usuarioIds[2],
            'categoria_id' => 1,
            'ubicacion_pendiente_id' => $ubicacionIds[2],
            'direccion' => 'Calle Betis, 18',
            'telefono' => '954333444',
            'email' => 'patioguadalquivir@pendiente.com',
            'web' => 'https://www.patioguadalquivir.com',
            'precio' => 38.00,
            'soles' => 0,
            'valoracion_promedio' => 0,
            'patrocinados' => false,
            'activo' => true,
        ]);

        RestaurantePendiente::create([
            'nombre' => 'Raco del Turia',
            'descripcion' => 'Arroceria moderna con menu degustacion y producto de temporada.',
            'user_id' => $usuarioIds[3],
            'categoria_id' => 3,
            'ubicacion_pendiente_id' => $ubicacionIds[3],
            'direccion' => 'Avenida del Puerto, 9',
            'telefono' => '960444555',
            'email' => 'racodelturia@pendiente.com',
            'web' => 'https://www.racodelturia.com',
            'precio' => 48.00,
            'soles' => 0,
            'valoracion_promedio' => 0,
            'patrocinados' => false,
            'activo' => true,
        ]);
    }
}
