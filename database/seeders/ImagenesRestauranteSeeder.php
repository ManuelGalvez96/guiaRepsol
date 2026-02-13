<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImagenesRestauranteSeeder extends Seeder
{
    /**
     * Asignar imágenes de img_restaurante a todos los restaurantes
     */
    public function run(): void
    {
        // Limpiar imágenes existentes
        \App\Models\ImagenRestaurante::truncate();
        
        // Obtener todos los restaurantes
        $restaurantes = \App\Models\Restaurante::all();
        
        if ($restaurantes->isEmpty()) {
            $this->command->info('No hay restaurantes en la base de datos.');
            return;
        }
        
        // Lista de imágenes disponibles en img_restaurante
        $imagenes = [
            'Abantal.jpg',
            'Akelarre.jpg', 
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
            'el-poblet.jpg',
            'El-Molino-Enmedio.jpg',
            'emigrante.webp',
            'Etxebarri.jpg',
            'Kabuki.jpg',
            'Kitchen154.jpg',
            'la_btiga.jpg',
            'La-Maruca.jpg',
            'La-Salita.jpg',
            'La-Terraza-del-Casino.jpg',
            'latasquita.jpg',
            'L\'Escaleta.jpg',
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
            'alabardero-sevilla.jpg'
        ];
        
        $contadorImagenes = 0;
        
        // Asignar imágenes rotatoriamente a cada restaurante
        foreach ($restaurantes as $index => $restaurante) {
            $imagenIndex = $index % count($imagenes);
            $nombreImagen = $imagenes[$imagenIndex];
            
            \App\Models\ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => "images/img_restaurante/{$nombreImagen}",
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0
            ]);
            
            $contadorImagenes++;
        }
        
        $this->command->info("Imágenes de img_restaurante asignadas a {$contadorImagenes} restaurantes.");
    }
}