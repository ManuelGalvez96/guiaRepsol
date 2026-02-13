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
    }
}
