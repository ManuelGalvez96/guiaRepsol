<?php

namespace Database\Seeders;

use App\Models\User;
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
        $gerenteIds = User::where('rol', 'gerente')->orderBy('id')->pluck('id')->all();
        $defaultGerenteId = $gerenteIds[0] ?? null;
        $index = 0;

        Restaurante::create([
            'nombre' => 'Tripea',
            'descripcion' => 'Cocina de fusión con toques mediterráneos dirigida por el chef Marcos González. Especialidad en carnes premium y productos de temporada.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Jose Ortega y Gasset, 22',
            'telefono' => '914356789',
            'email' => 'reservas@tripea.es',
            'web' => 'https://www.tripea.es',
            'precio' => 65.00,
            'soles' => 1,
            'valoracion_promedio' => 4.50,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Miga Cana',
            'descripcion' => 'Bar de cocina tradicional española con toques modernos. Famoso por sus arroces y carnes a la brasa.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle Jorge Juan, 14',
            'telefono' => '913456712',
            'email' => 'info@migacana.es',
            'web' => 'https://www.migacana.es',
            'precio' => 45.00,
            'soles' => 0,
            'valoracion_promedio' => 4.20,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Kitchen 154',
            'descripcion' => 'Restaurante de alta cocina con propuestas innovadoras. Menú degustación con productos locales.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Hermosilla, 154',
            'telefono' => '912345678',
            'email' => 'reservas@kitchen154.com',
            'web' => 'https://www.kitchen154.com',
            'precio' => 85.00,
            'soles' => 0,
            'valoracion_promedio' => 4.70,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Martín Berasategui',
            'descripcion' => 'Tres soles Repsol. Templo de la alta gastronomía vasca con creaciones del maestro Martín Berasategui.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Loidi Kalea, 4, Lasarte-Oria',
            'telefono' => '943366471',
            'email' => 'restaurante@martinberasategui.com',
            'web' => 'https://www.martinberasategui.com',
            'precio' => 240.00,
            'soles' => 3,
            'valoracion_promedio' => 5.00,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Akelarre',
            'descripcion' => 'Tres soles Repsol. Cocina vasca de vanguardia con vistas espectaculares al Cantábrico.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
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
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Carrer de Villarroel, 163',
            'telefono' => '933486896',
            'email' => 'reservas@disfrutarbarcelona.com',
            'web' => 'https://www.disfrutarbarcelona.com',
            'precio' => 195.00,
            'soles' => 2,
            'valoracion_promedio' => 4.90,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Ricard Camarena',
            'descripcion' => 'Dos soles Repsol. Cocina mediterránea contemporánea con producto valenciano de máxima calidad.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
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
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
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
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 6,
            'direccion' => 'Rúa das Hortas, 1',
            'telefono' => '981558580',
            'email' => 'info@casamarcelo.net',
            'web' => 'https://www.casamarcelo.net',
            'precio' => 75.00,
            'soles' => 1,
            'valoracion_promedio' => 4.60,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Casa Gerardo',
            'descripcion' => 'Un sol Repsol. Cocina asturiana tradicional reinventada con productos de proximidad.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
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
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 8,
            'direccion' => 'Abandoibarra Etorbidea, 2',
            'telefono' => '944000430',
            'email' => 'nerua@neruaguggenheimbilbao.com',
            'web' => 'https://www.neruaguggenheimbilbao.com',
            'precio' => 110.00,
            'soles' => 1,
            'valoracion_promedio' => 4.55,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'La Botica',
            'descripcion' => 'Un sol Repsol. Propuesta gastronómica creativa en Matapozuelos con productos castellanos.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
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
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 10,
            'direccion' => 'Calle Alcalde José de la Bandera, 7',
            'telefono' => '954540000',
            'email' => 'reservas@abantalrestaurante.es',
            'web' => 'https://www.abantalrestaurante.es',
            'precio' => 95.00,
            'soles' => 1,
            'valoracion_promedio' => 4.75,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Club Allard',
            'descripcion' => 'Dos soles Repsol. Alta cocina de vanguardia en un palacete modernista madrileño.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Ferraz, 2',
            'telefono' => '915590939',
            'email' => 'info@elcluballard.com',
            'web' => 'https://www.elcluballard.com',
            'precio' => 175.00,
            'soles' => 2,
            'valoracion_promedio' => 4.88,
            'patrocinados' => true,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'DiverXO',
            'descripcion' => 'Tres soles Repsol. El primer y único tres soles de Madrid. Cocina fusión de Dabiz Muñoz.',
            'user_id' => $gerenteIds[$index++] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Padre Damián, 23',
            'telefono' => '915700766',
            'email' => 'reservas@diverxo.com',
            'web' => 'https://www.diverxo.com',
            'precio' => 365.00,
            'soles' => 3,
            'valoracion_promedio' => 4.98,
            'patrocinados' => true,
            'activo' => true,
        ]);

        // Additional 35 restaurants
        Restaurante::create([
            'nombre' => 'La Terraza del Casino',
            'descripcion' => 'Dos soles Repsol. Elegante restaurante de Paco Roncero con vistas privilegiadas de Madrid.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Alcalá, 15',
            'telefono' => '915321275',
            'email' => 'info@casinomadrid.es',
            'web' => 'https://www.casinomadrid.es',
            'precio' => 185.00,
            'soles' => 2,
            'valoracion_promedio' => 4.85,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Coque',
            'descripcion' => 'Dos soles Repsol. Los hermanos Sandoval ofrecen una experiencia gastronómica completa.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Francisco de Medina y Mendoza, 4',
            'telefono' => '916044984',
            'email' => 'reservas@restaurantecoque.com',
            'web' => 'https://www.restaurantecoque.com',
            'precio' => 190.00,
            'soles' => 2,
            'valoracion_promedio' => 4.90,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Santceloni',
            'descripcion' => 'Dos soles Repsol. Cocina española contemporánea con servicio impecable.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Paseo de la Castellana, 57',
            'telefono' => '912107878',
            'email' => 'santceloni@hospes.com',
            'web' => 'https://www.restaurantesantceloni.com',
            'precio' => 210.00,
            'soles' => 2,
            'valoracion_promedio' => 4.87,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Lasarte',
            'descripcion' => 'Tres soles Repsol. El restaurante de Martín Berasategui en Barcelona.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Carrer del Mallorca, 259',
            'telefono' => '934453242',
            'email' => 'reservas@restaurantlasarte.com',
            'web' => 'https://www.restaurantlasarte.com',
            'precio' => 250.00,
            'soles' => 3,
            'valoracion_promedio' => 4.96,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Moments',
            'descripcion' => 'Dos soles Repsol. Carme Ruscalleda y Raül Balam fusionan tradición e innovación.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Passeig de Gràcia, 38-40',
            'telefono' => '932151000',
            'email' => 'moments@mandarinoriental.com',
            'web' => 'https://www.mandarinoriental.com/barcelona',
            'precio' => 205.00,
            'soles' => 2,
            'valoracion_promedio' => 4.83,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Azurmendi',
            'descripcion' => 'Tres soles Repsol. Eneko Atxa combina sostenibilidad y alta cocina vasca.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 8,
            'direccion' => 'Barrio Leguina, s/n, Larrabetzu',
            'telefono' => '944558359',
            'email' => 'azurmendi@azurmendi.restaurant',
            'web' => 'https://www.azurmendi.restaurant',
            'precio' => 260.00,
            'soles' => 3,
            'valoracion_promedio' => 4.94,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Mugaritz',
            'descripcion' => 'Dos soles Repsol. Andoni Luis Aduriz propone experiencias gastronómicas únicas.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Aldura Gunea Aldea, 20, Errenteria',
            'telefono' => '943522455',
            'email' => 'mugaritz@mugaritz.com',
            'web' => 'https://www.mugaritz.com',
            'precio' => 230.00,
            'soles' => 2,
            'valoracion_promedio' => 4.89,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Arzak',
            'descripcion' => 'Tres soles Repsol. Icono de la nueva cocina vasca con tradición familiar.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Avenida Alcalde José Elosegui, 273',
            'telefono' => '943278465',
            'email' => 'restaurante@arzak.info',
            'web' => 'https://www.arzak.info',
            'precio' => 255.00,
            'soles' => 3,
            'valoracion_promedio' => 4.97,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Etxebarri',
            'descripcion' => 'Un sol Repsol. Victor Arguinzoniz es el maestro de la parrilla.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 8,
            'direccion' => 'Plaza San Juan, 1, Axpe',
            'telefono' => '946583042',
            'email' => 'asador@asadoretxebarri.com',
            'web' => 'https://www.asadoretxebarri.com',
            'precio' => 120.00,
            'soles' => 1,
            'valoracion_promedio' => 4.78,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Quique Dacosta',
            'descripcion' => 'Tres soles Repsol. Vanguardia gastronómica con raíces mediterráneas.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Carrer del Rascassà, 1, Dénia',
            'telefono' => '965784179',
            'email' => 'info@quiquedacosta.es',
            'web' => 'https://www.quiquedacosta.es',
            'precio' => 270.00,
            'soles' => 3,
            'valoracion_promedio' => 4.92,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Celler de Can Roca',
            'descripcion' => 'Tres soles Repsol. Los hermanos Roca han creado uno de los mejores restaurantes del mundo.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Carrer Can Sunyer, 48, Girona',
            'telefono' => '972222157',
            'email' => 'reservas@cellercanroca.com',
            'web' => 'https://www.cellercanroca.com',
            'precio' => 245.00,
            'soles' => 3,
            'valoracion_promedio' => 5.00,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Tickets Bar',
            'descripcion' => 'Tapas de alta cocina por el equipo de Adrià en ambiente desenfadado.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 3,
            'direccion' => 'Avinguda del Paral·lel, 164',
            'telefono' => '932927550',
            'email' => 'tickets@ticketsbar.es',
            'web' => 'https://www.ticketsbar.es',
            'precio' => 75.00,
            'soles' => 0,
            'valoracion_promedio' => 4.50,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Casa Mono',
            'descripcion' => 'Cocina tradicional española con toques modernos en un ambiente acogedor.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle Tutor, 37',
            'telefono' => '915334917',
            'email' => 'info@casamonomadrid.com',
            'web' => 'https://www.casamonomadrid.com',
            'precio' => 55.00,
            'soles' => 0,
            'valoracion_promedio' => 4.35,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'La Tasquita de Enfrente',
            'descripcion' => 'Un sol Repsol. Cocina de mercado con toque personal de Juanjo López.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de la Ballesta, 6',
            'telefono' => '915321449',
            'email' => 'info@latasquitadeenfrente.com',
            'web' => 'https://www.latasquitadeenfrente.com',
            'precio' => 80.00,
            'soles' => 1,
            'valoracion_promedio' => 4.60,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Taberna del Alabardero',
            'descripcion' => 'Cocina andaluza refinada en un palacio del siglo XIX.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 10,
            'direccion' => 'Calle Zaragoza, 20',
            'telefono' => '954502721',
            'email' => 'sevilla@alabardero.com',
            'web' => 'https://www.tabernadelalabardero.es',
            'precio' => 65.00,
            'soles' => 0,
            'valoracion_promedio' => 4.45,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Poblet',
            'descripcion' => 'Un sol Repsol. Cocina valenciana moderna por Quique Dacosta.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Carrer de Correus, 8',
            'telefono' => '961111106',
            'email' => 'reservas@elpobletrestaurant.com',
            'web' => 'https://www.elpobletrestaurant.com',
            'precio' => 98.00,
            'soles' => 1,
            'valoracion_promedio' => 4.68,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'La Salita',
            'descripcion' => 'Un sol Repsol. Cocina mediterránea de autor con producto de temporada.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Carrer del Mestre Josep Serrano, 5',
            'telefono' => '963271948',
            'email' => 'info@restaurantelasalita.com',
            'web' => 'https://www.restaurantelasalita.com',
            'precio' => 85.00,
            'soles' => 1,
            'valoracion_promedio' => 4.55,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Bardal',
            'descripcion' => 'Dos soles Repsol. Cocina creativa en Ronda con vistas espectaculares.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 5,
            'direccion' => 'Calle José Aparicio, 1, Ronda',
            'telefono' => '951489828',
            'email' => 'info@bardal.es',
            'web' => 'https://www.bardal.es',
            'precio' => 165.00,
            'soles' => 2,
            'valoracion_promedio' => 4.82,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Sollo',
            'descripcion' => 'Un sol Repsol. Diego Gallegos, maestro del caviar y pescado de estero.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 5,
            'direccion' => 'Plaza San Andrés, 2, Fuengirola',
            'telefono' => '952580196',
            'email' => 'info@sollo.es',
            'web' => 'https://www.sollo.es',
            'precio' => 125.00,
            'soles' => 1,
            'valoracion_promedio' => 4.72,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Aponiente',
            'descripcion' => 'Tres soles Repsol. Ángel León, el Chef del Mar, revoluciona la cocina marina.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 10,
            'direccion' => 'Calle Francisco Cossi Ochoa, s/n, El Puerto de Santa María',
            'telefono' => '956851870',
            'email' => 'reservas@aponiente.com',
            'web' => 'https://www.aponiente.com',
            'precio' => 280.00,
            'soles' => 3,
            'valoracion_promedio' => 4.95,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Atrio',
            'descripcion' => 'Tres soles Repsol. Toño Pérez y su bodega legendaria en Cáceres.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Plaza San Mateo, 1, Cáceres',
            'telefono' => '927242928',
            'email' => 'atrio@restauranteatrio.com',
            'web' => 'https://www.restauranteatrio.com',
            'precio' => 290.00,
            'soles' => 3,
            'valoracion_promedio' => 4.93,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Cenador de Amós',
            'descripcion' => 'Dos soles Repsol. Jesús Sánchez combina tradición cántabra e innovación.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 7,
            'direccion' => 'Barrio La Rasilla, s/n, Villaverde de Pontones',
            'telefono' => '942508243',
            'email' => 'info@cenadordeamos.com',
            'web' => 'https://www.cenadordeamos.com',
            'precio' => 180.00,
            'soles' => 2,
            'valoracion_promedio' => 4.84,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Kabuki',
            'descripcion' => 'Un sol Repsol. Fusión nikkei con toques mediterráneos.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 3,
            'ubicacion_id' => 1,
            'direccion' => 'Avenida Presidente Carmona, 2',
            'telefono' => '917828880',
            'email' => 'reservas@restaurantekabuki.com',
            'web' => 'https://www.restaurantekabuki.com',
            'precio' => 95.00,
            'soles' => 1,
            'valoracion_promedio' => 4.62,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Cañadío',
            'descripcion' => 'Un sol Repsol. Coctelería y gastronomía de alto nivel.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle del Conde de Peñalver, 86',
            'telefono' => '914010977',
            'email' => 'info@canadio.es',
            'web' => 'https://www.canadio.es',
            'precio' => 72.00,
            'soles' => 1,
            'valoracion_promedio' => 4.48,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'La Maruca',
            'descripcion' => 'Especialidad en pescados y mariscos de la costa cantábrica.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Velázquez, 54',
            'telefono' => '914314580',
            'email' => 'info@lamaruca.es',
            'web' => 'https://www.lamaruca.es',
            'precio' => 60.00,
            'soles' => 0,
            'valoracion_promedio' => 4.30,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Casa Lucio',
            'descripcion' => 'Emblemático restaurante madrileño famoso por sus huevos estrellados.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de la Cava Baja, 35',
            'telefono' => '913653252',
            'email' => 'info@casalucio.es',
            'web' => 'https://www.casalucio.es',
            'precio' => 50.00,
            'soles' => 0,
            'valoracion_promedio' => 4.25,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Botín',
            'descripcion' => 'El restaurante más antiguo del mundo según Guinness Records. Cocina castellana tradicional.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Cuchilleros, 17',
            'telefono' => '913664217',
            'email' => 'info@botin.es',
            'web' => 'https://www.botin.es',
            'precio' => 58.00,
            'soles' => 0,
            'valoracion_promedio' => 4.40,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Molino de Enmedio',
            'descripcion' => 'Un sol Repsol. Cocina tradicional manchega renovada.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 9,
            'direccion' => 'Camino de Enmedio, s/n, Villanueva de Alcardete',
            'telefono' => '925560025',
            'email' => 'info@molinodeenmedio.es',
            'web' => 'https://www.molinodeenmedio.es',
            'precio' => 68.00,
            'soles' => 1,
            'valoracion_promedio' => 4.52,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Ramón Freixa Madrid',
            'descripcion' => 'Dos soles Repsol. Alta cocina catalana en el corazón de Madrid.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Claudio Coello, 67',
            'telefono' => '917818262',
            'email' => 'reservas@ramonfreixamadrid.com',
            'web' => 'https://www.ramonfreixamadrid.com',
            'precio' => 198.00,
            'soles' => 2,
            'valoracion_promedio' => 4.86,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Maralba',
            'descripcion' => 'Un sol Repsol. Cocina de arraigo con productos de Almansa.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Calle Las Norias, 10, Almansa',
            'telefono' => '967312652',
            'email' => 'reservas@maralba.com',
            'web' => 'https://www.maralba.com',
            'precio' => 74.00,
            'soles' => 1,
            'valoracion_promedio' => 4.58,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'El Refectorio',
            'descripcion' => 'Cocina tradicional leonesa en un convento del siglo XVIII.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 9,
            'direccion' => 'Plaza de Santo Domingo, 8, León',
            'telefono' => '987303070',
            'email' => 'info@elrefectorio.es',
            'web' => 'https://www.elrefectorio.es',
            'precio' => 52.00,
            'soles' => 0,
            'valoracion_promedio' => 4.38,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Zalacaín',
            'descripcion' => 'Leyenda de la gastronomía madrileña, pionero de la alta cocina.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 1,
            'direccion' => 'Calle de Álvarez de Baena, 4',
            'telefono' => '915614840',
            'email' => 'info@zalacain.es',
            'web' => 'https://www.zalacain.es',
            'precio' => 105.00,
            'soles' => 0,
            'valoracion_promedio' => 4.42,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Topa Sukaldería',
            'descripcion' => 'Un sol Repsol. Cocina vasca moderna en pleno San Sebastián.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 2,
            'direccion' => 'Calle San Sebastian, 32',
            'telefono' => '943131300',
            'email' => 'info@topasukalderia.com',
            'web' => 'https://www.topasukalderia.com',
            'precio' => 88.00,
            'soles' => 1,
            'valoracion_promedio' => 4.65,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Cinc Sentits',
            'descripcion' => 'Un sol Repsol. Restaurante íntimo con cocina catalana contemporánea.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 3,
            'direccion' => 'Carrer d\'Entença, 60',
            'telefono' => '933239490',
            'email' => 'info@cincsentits.com',
            'web' => 'https://www.cincsentits.com',
            'precio' => 92.00,
            'soles' => 1,
            'valoracion_promedio' => 4.67,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'Villena',
            'descripcion' => 'Un sol Repsol. Cocina de mercado en Segovia con raíces castellanas.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 2,
            'ubicacion_id' => 9,
            'direccion' => 'Plaza Mayor, 4, Segovia',
            'telefono' => '921466349',
            'email' => 'reservas@restaurantevillena.com',
            'web' => 'https://www.restaurantevillena.com',
            'precio' => 78.00,
            'soles' => 1,
            'valoracion_promedio' => 4.54,
            'activo' => true,
        ]);

        Restaurante::create([
            'nombre' => 'L\'Escaleta',
            'descripcion' => 'Un sol Repsol. Cocina mediterránea creativa en Cocentaina.',
            'user_id' => $gerenteIds[$index++ % count($gerenteIds)] ?? $defaultGerenteId,
            'categoria_id' => 1,
            'ubicacion_id' => 4,
            'direccion' => 'Carrer Escaletes, 5, Cocentaina',
            'telefono' => '965590900',
            'email' => 'info@escaletarestaurant.com',
            'web' => 'https://www.escaletarestaurant.com',
            'precio' => 86.00,
            'soles' => 1,
            'valoracion_promedio' => 4.61,
            'activo' => true,
        ]);
    }
}
