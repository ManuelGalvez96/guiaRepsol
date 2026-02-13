<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImagenesRestauranteSeeder extends Seeder
{
    /**
     * Asignar imágenes reales del storage a todos los restaurantes
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
        
        // Obtener imágenes reales del storage
        $storagePath = storage_path('app/public/restaurantes');
        $imagenes = [];
        
        if (is_dir($storagePath)) {
            $files = scandir($storagePath);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $imagenes[] = 'restaurantes/' . $file;
                }
            }
        }
        
        if (empty($imagenes)) {
            $this->command->info('No hay imágenes en storage/app/public/restaurantes.');
            return;
        }
        
        $this->command->info('Encontradas ' . count($imagenes) . ' imágenes en storage.');
        
        // Asignar imágenes a restaurantes rotativamente
        foreach ($restaurantes as $index => $restaurante) {
            $imagenIndex = $index % count($imagenes);
            
            \App\Models\ImagenRestaurante::create([
                'restaurante_id' => $restaurante->id,
                'url' => $imagenes[$imagenIndex],
                'alt' => $restaurante->nombre,
                'principal' => true,
                'orden' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $this->command->info('✅ Asignadas imágenes reales a ' . $restaurantes->count() . ' restaurantes.');
    }
}