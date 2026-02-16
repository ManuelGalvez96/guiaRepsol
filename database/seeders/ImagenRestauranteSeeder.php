<?php

namespace Database\Seeders;

use App\Models\ImagenRestaurante;
use App\Models\Restaurante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImagenRestauranteSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restauranteIds = Restaurante::orderBy('id')->pluck('id')->all();

        if (count($restauranteIds) < 15) {
            return;
        }

        // Crear imágenes para cada restaurante
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[0],
            'url' => 'img/restaurantes/tripea.jpg',
            'alt' => 'Foto principal Tripea',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[1],
            'url' => 'img/restaurantes/miga_cena.jpg',
            'alt' => 'Foto principal Miga Cana',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[2],
            'url' => 'img/restaurantes/Kitchen154.jpg',
            'alt' => 'Foto principal Kitchen 154',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[3],
            'url' => 'img/restaurantes/Martín_Berasategui.jpg',
            'alt' => 'Foto principal Martín Berasategui',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4],
            'url' => 'img/restaurantes/Akelarre.jpg',
            'alt' => 'Foto principal Akelarre',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[5],
            'url' => 'img/restaurantes/Disfrutar.jpg',
            'alt' => 'Foto principal Disfrutar',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[6],
            'url' => 'img/restaurantes/Ricard_Camarena.jpg',
            'alt' => 'Foto principal Ricard Camarena',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[7],
            'url' => 'img/restaurantes/Skina.jpg',
            'alt' => 'Foto principal Skina',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[8],
            'url' => 'img/restaurantes/casa-marcelo.jpg',
            'alt' => 'Foto principal Casa Marcelo',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[9],
            'url' => 'img/restaurantes/Casa_Gerardo.jpg',
            'alt' => 'Foto principal Casa Gerardo',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[10],
            'url' => 'img/restaurantes/nerua.jpg',
            'alt' => 'Foto principal Nerua',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[11],
            'url' => 'img/restaurantes/La-Salita.jpg',
            'alt' => 'Foto principal La Botica',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[12],
            'url' => 'img/restaurantes/Abantal.jpg',
            'alt' => 'Foto principal Abantal',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[13],
            'url' => 'img/restaurantes/El-Club-Allard.jpg',
            'alt' => 'Foto principal El Club Allard',
            'principal' => true,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[14],
            'url' => 'img/restaurantes/diverxo.jpg',
            'alt' => 'Foto principal DiverXO',
            'principal' => true,
            'orden' => 1,
        ]);

        // Imágenes adicionales para el slider de Akelarre
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_1.jpg',
            'alt' => 'Interior restaurante Akelarre',
            'principal' => false,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_2.jpg',
            'alt' => 'Plato estrella Akelarre',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_3.jpg',
            'alt' => 'Vistas desde Akelarre',
            'principal' => false,
            'orden' => 3,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_4.jpg',
            'alt' => 'Terraza Akelarre',
            'principal' => false,
            'orden' => 4,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_5.jpg',
            'alt' => 'Plato gourmet Akelarre',
            'principal' => false,
            'orden' => 5,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_6.jpg',
            'alt' => 'Cocina Akelarre',
            'principal' => false,
            'orden' => 6,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_7.jpg',
            'alt' => 'Detalle decoración Akelarre',
            'principal' => false,
            'orden' => 7,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[4], // Akelarre
            'url' => 'img/restaurantes/Akelarre_8.jpg',
            'alt' => 'Ambiente nocturno Akelarre',
            'principal' => false,
            'orden' => 8,
        ]);

        // Imágenes adicionales para el slider de Disfrutar
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[5], // Disfrutar
            'url' => 'img/restaurantes/Disfrutar_1.jpg',
            'alt' => 'Sala principal Disfrutar',
            'principal' => false,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[5], // Disfrutar
            'url' => 'img/restaurantes/Disfrutar_2.jpg',
            'alt' => 'Creación culinaria Disfrutar',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[5], // Disfrutar
            'url' => 'img/restaurantes/Disfrutar_3.jpg',
            'alt' => 'Cocina abierta Disfrutar',
            'principal' => false,
            'orden' => 3,
        ]);

        // Imágenes adicionales para el slider de Martín Berasategui
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[3], // Martín Berasategui
            'url' => 'img/restaurantes/Martin_Berasategui_1.jpg',
            'alt' => 'Comedor elegante Martín Berasategui',
            'principal' => false,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[3], // Martín Berasategui
            'url' => 'img/restaurantes/Martin_Berasategui_2.jpg',
            'alt' => 'Plato gourmet Martín Berasategui',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[3], // Martín Berasategui
            'url' => 'img/restaurantes/Martin_Berasategui_3.jpg',
            'alt' => 'Bodega Martín Berasategui',
            'principal' => false,
            'orden' => 3,
        ]);

        // Imágenes adicionales para el slider de Abantal
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[12], // Abantal
            'url' => 'img/restaurantes/Abantal_1.jpg',
            'alt' => 'Interior moderno Abantal',
            'principal' => false,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[12], // Abantal
            'url' => 'img/restaurantes/Abantal_2.jpg',
            'alt' => 'Tapa innovadora Abantal',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[12], // Abantal
            'url' => 'img/restaurantes/Abantal_3.jpg',
            'alt' => 'Menú degustación Abantal',
            'principal' => false,
            'orden' => 3,
        ]);

        // Imágenes adicionales para el slider de DiverXO
        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[14], // DiverXO
            'url' => 'img/restaurantes/DiverXO_1.jpg',
            'alt' => 'Ambiente único DiverXO',
            'principal' => false,
            'orden' => 1,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[14], // DiverXO
            'url' => 'img/restaurantes/DiverXO_2.jpg',
            'alt' => 'Plato innovador DiverXO',
            'principal' => false,
            'orden' => 2,
        ]);

        ImagenRestaurante::create([
            'restaurante_id' => $restauranteIds[14], // DiverXO
            'url' => 'img/restaurantes/DiverXO_3.jpg',
            'alt' => 'Cocina fusión DiverXO',
            'principal' => false,
            'orden' => 3,
        ]);
    }
}
