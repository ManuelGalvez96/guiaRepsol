<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\ImagenRestaurante;
use Illuminate\Database\Seeder;

class ImagenRestauranteSeeder extends Seeder
{
    public function run(): void
    {
        // Imágenes disponibles para restaurantes aceptados (excluir imágenes con prefijo rest_p_ que son pendientes)
        $imagenesAceptados = [
            'Abantal.jpg',
            'Akelarre.jpg',
            'Akelarre_1.jpg',
            'Akelarre_2.jpg',
            'Akelarre_3.jpg',
            'alabardero-sevilla.jpg',
            'Aponiente.jpg',
            'Arzak.jpg',
            'Atrio.jpg',
            'Azurmendi.jpg',
            'Bardal.jpg',
            'Botín.jpg',
            'Casa-Lucio.jpg',
            'casa-marcelo.jpg',
            'Casa_Gerardo.jpg',
            'Casa_Mono.jpg',
            'Cañadío.jpg',
            'Cenador-de-Amós.jpg',
            'CincSentits.jpg',
            'Coque.jpg',
            'Disfrutar.jpg',
            'diverxo.jpg',
            'El-Celler-Can-Roca.jpg',
            'El-Club-Allard.jpg',
            'El-Molino-Enmedio.jpg',
            'el-poblet.jpg',
            'Etxebarri.jpg',
            'Kabuki.jpg',
            'Kitchen154.jpg',
            'L\'Escaleta.jpg',
            'La Maruca.jpg',
            'La-Salita.jpg',
            'La-Terraza-del-Casino.jpg',
            'latasquita.jpg',
            'la_btiga.jpg',
            'Maralba.jpg',
            'Martín_Berasategui.jpg',
            'miga_cena.jpg',
            'Mugaritz.jpg',
            'nerua.jpg',
            'QuiqueDacosta.jpg',
            'Ramón-Freixa-Madrid.jpg',
            'Refectorio.jpg',
            'restaurante-lasarte.jpg',
            'restaurante-moments.jpg',
            'Ricard_Camarena.jpg',
            'Santceloni.jpg',
            'Skina.jpg',
            'Sollo.jpg',
            'Tickets_portada.jpg',
            'TopaSukaldería.jpg',
            'tripea.jpg',
            'Villena.jpg',
            'Zalacaín.jpg',
        ];

        $restaurantesAceptados = Restaurante::where('estado', 'aceptado')->get();
        $restaurantesPendientes = Restaurante::where('estado', 'pendiente')->get();

        // Imágenes para restaurantes aceptados
        $imagenIndex = 0;
        foreach ($restaurantesAceptados as $restaurante) {
            // Imagen principal
            $imagen = $imagenesAceptados[$imagenIndex % count($imagenesAceptados)];
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => 'img/restaurantes/' . $imagen,
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0,
            ]);

            // 2-3 imágenes adicionales
            $numImagenes = rand(2, 3);
            for ($i = 1; $i <= $numImagenes; $i++) {
                $imagenIndex++;
                $imagen = $imagenesAceptados[$imagenIndex % count($imagenesAceptados)];
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => 'img/restaurantes/' . $imagen,
                    'alt' => $restaurante->nombre . ' - Imagen ' . $i,
                    'principal' => false,
                    'orden' => $i,
                ]);
            }
            $imagenIndex++;
        }

        // Imágenes para restaurantes pendientes
        $imagenesPendientes = [
            'rest_p_69935c755246c.jpg',
            'rest_p_69947ca89d3c4.jpg',
            'rest_p_69947ca8a27a9.jpg',
            'rest_p_69947ca8a58b3.jpg',
            'rest_p_69947ca8a7c89.jpg',
            'rest_p_69947ca8aa1f0.jpg',
            'rest_p_69947ca8ac7cf.jpg',
            'rest_p_69947ca8aeda5.jpg',
            'rest_p_69947ca8b143a.jpg',
            'rest_p_69947ca8b3b2b.jpg',
        ];

        $imagenPendienteIndex = 0;
        foreach ($restaurantesPendientes as $restaurante) {
            // Imagen principal
            $imagen = $imagenesPendientes[$imagenPendienteIndex % count($imagenesPendientes)];
            ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => 'img/restaurantes/pendiente/' . $imagen,
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0,
            ]);

            // 1-2 imágenes adicionales
            $numImagenes = rand(1, 2);
            for ($i = 1; $i <= $numImagenes; $i++) {
                $imagenPendienteIndex++;
                $imagen = $imagenesPendientes[$imagenPendienteIndex % count($imagenesPendientes)];
                ImagenRestaurante::create([
                    'restaurante_id' => $restaurante->id,
                    'url' => 'img/restaurantes/pendiente/' . $imagen,
                    'alt' => $restaurante->nombre . ' - Imagen ' . $i,
                    'principal' => false,
                    'orden' => $i,
                ]);
            }
            $imagenPendienteIndex++;
        }
    }
}
