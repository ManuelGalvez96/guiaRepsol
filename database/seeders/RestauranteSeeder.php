<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestauranteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Restaurante::create([
            'nombre' => 'Tripea',
            'descripcion' => 'Cocina de fusión con toques mediterráneos dirigida por el chef Marcos González. Especialidad en carnes premium y productos de temporada.',
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Jose Ortega y Gasset, 22',
            'telefono' => '914356789',
            'email' => 'reservas@tripea.es',
            'web' => 'https://www.tripea.es',
            'precio' => 65.00,
            'soles' => 1,
            'valoracion_promedio' => 4.50,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Miga Cana',
            'descripcion' => 'Bar de cocina tradicional española con toques modernos. Famoso por sus arroces y carnes a la brasa.',
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle Jorge Juan, 14',
            'telefono' => '913456712',
            'email' => 'info@migacana.es',
            'web' => 'https://www.migacana.es',
            'precio' => 45.00,
            'soles' => 0,
            'valoracion_promedio' => 4.20,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Kitchen 154',
            'descripcion' => 'Restaurante de alta cocina con propuestas innovadoras. Menú degustación con productos locales.',
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Hermosilla, 154',
            'telefono' => '912345678',
            'email' => 'reservas@kitchen154.com',
            'web' => 'https://www.kitchen154.com',
            'precio' => 85.00,
            'soles' => 0,
            'valoracion_promedio' => 4.70,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Martín Berasategui',
            'descripcion' => 'Tres soles Repsol. Templo de la alta gastronomía vasca con creaciones del maestro Martín Berasategui.',
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Loidi Kalea, 4, Lasarte-Oria',
            'telefono' => '943366471',
            'email' => 'restaurante@martinberasategui.com',
            'web' => 'https://www.martinberasategui.com',
            'precio' => 240.00,
            'soles' => 3,
            'valoracion_promedio' => 5.00,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Akelarre',
            'descripcion' => 'Tres soles Repsol. Cocina vasca de vanguardia con vistas espectaculares al Cantábrico.',
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Paseo Padre Orcolaga, 56',
            'telefono' => '943311209',
            'email' => 'info@akelarre.net',
            'web' => 'https://www.akelarre.net',
            'precio' => 220.00,
            'soles' => 3,
            'valoracion_promedio' => 4.95,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Disfrutar',
            'descripcion' => 'Dos soles Repsol. Propuesta gastronómica innovadora de Oriol Castro, Eduard Xatruch y Mateu Casañas.',
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Carrer de Villarroel, 163',
            'telefono' => '933486896',
            'email' => 'reservas@disfrutarbarcelona.com',
            'web' => 'https://www.disfrutarbarcelona.com',
            'precio' => 195.00,
            'soles' => 2,
            'valoracion_promedio' => 4.90,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Ricard Camarena',
            'descripcion' => 'Dos soles Repsol. Cocina mediterránea contemporánea con producto valenciano de máxima calidad.',
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Carrer del Dr. Sumsi, 4',
            'telefono' => '963355418',
            'email' => 'info@ricardcamarena.com',
            'web' => 'https://www.ricardcamarena.com',
            'precio' => 160.00,
            'soles' => 2,
            'valoracion_promedio' => 4.85,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Skina',
            'descripcion' => 'Dos soles Repsol. Alta cocina en pleno centro de Marbella con propuestas creativas.',
            'categoria_id' => 1,
            'ubicacion_id' => 5,
            'direccion' => 'Calle Aduar, 12',
            'telefono' => '952765277',
            'email' => 'reservas@restauranteskina.com',
            'web' => 'https://www.restauranteskina.com',
            'precio' => 140.00,
            'soles' => 2,
            'valoracion_promedio' => 4.80,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Casa Marcelo',
            'descripcion' => 'Un sol Repsol. Cocina gallega de fusión con influencias asiáticas en el corazón de Santiago.',
            'categoria_id' => 1,
            'ubicacion_id' => 6,
            'direccion' => 'Rúa das Hortas, 1',
            'telefono' => '981558580',
            'email' => 'info@casamarcelo.net',
            'web' => 'https://www.casamarcelo.net',
            'precio' => 75.00,
            'soles' => 1,
            'valoracion_promedio' => 4.60,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Casa Gerardo',
            'descripcion' => 'Un sol Repsol. Cocina asturiana tradicional reinventada con productos de proximidad.',
            'categoria_id' => 1,
            'ubicacion_id' => 7,
            'direccion' => 'Carretera AS-19, Km 9',
            'telefono' => '985887797',
            'email' => 'reservas@casagerardo.es',
            'web' => 'https://www.casagerardo.es',
            'precio' => 90.00,
            'soles' => 1,
            'valoracion_promedio' => 4.65,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Nerua',
            'descripcion' => 'Un sol Repsol. Restaurante del Guggenheim Bilbao con cocina vasca contemporánea.',
            'categoria_id' => 1,
            'ubicacion_id' => 8,
            'direccion' => 'Abandoibarra Etorbidea, 2',
            'telefono' => '944000430',
            'email' => 'nerua@neruaguggenheimbilbao.com',
            'web' => 'https://www.neruaguggenheimbilbao.com',
            'precio' => 110.00,
            'soles' => 1,
            'valoracion_promedio' => 4.55,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'La Botica',
            'descripcion' => 'Un sol Repsol. Propuesta gastronómica creativa en Matapozuelos con productos castellanos.',
            'categoria_id' => 1,
            'ubicacion_id' => 9,
            'direccion' => 'Plaza de San Joaquín, 4, Matapozuelos',
            'telefono' => '983832698',
            'email' => 'info@laboticarestaurante.com',
            'web' => 'https://www.laboticarestaurante.com',
            'precio' => 70.00,
            'soles' => 1,
            'valoracion_promedio' => 4.40,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Abantal',
            'descripcion' => 'Un sol Repsol. Cocina andaluza de autor con toques modernos en Sevilla.',
            'categoria_id' => 1,
            'ubicacion_id' => 10,
            'direccion' => 'Calle Alcalde José de la Bandera, 7',
            'telefono' => '954540000',
            'email' => 'reservas@abantalrestaurante.es',
            'web' => 'https://www.abantalrestaurante.es',
            'precio' => 95.00,
            'soles' => 1,
            'valoracion_promedio' => 4.75,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Club Allard',
            'descripcion' => 'Dos soles Repsol. Alta cocina de vanguardia en un palacete modernista madrileño.',
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Ferraz, 2',
            'telefono' => '915590939',
            'email' => 'info@elcluballard.com',
            'web' => 'https://www.elcluballard.com',
            'precio' => 175.00,
            'soles' => 2,
            'valoracion_promedio' => 4.88,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'DiverXO',
            'descripcion' => 'Tres soles Repsol. El primer y único tres soles de Madrid. Cocina fusión de Dabiz Muñoz.',
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Padre Damián, 23',
            'telefono' => '915700766',
            'email' => 'reservas@diverxo.com',
            'web' => 'https://www.diverxo.com',
            'precio' => 365.00,
            'soles' => 3,
            'valoracion_promedio' => 4.98,
            'activo' => true,
        ]);
    }
}
