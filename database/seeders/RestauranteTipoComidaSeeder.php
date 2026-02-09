<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestauranteTipoComidaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('restaurante_tipo_comida')->insert([
            ['restaurante_id' => 1, 'tipo_comida_id' => 1], // Tripea: Mediterránea
            ['restaurante_id' => 1, 'tipo_comida_id' => 10], // Tripea: Creativa
            ['restaurante_id' => 2, 'tipo_comida_id' => 9], // Miga Cana: Tradicional española
            ['restaurante_id' => 3, 'tipo_comida_id' => 10], // Kitchen 154: Creativa
            ['restaurante_id' => 3, 'tipo_comida_id' => 8], // Kitchen 154: Fusión
            ['restaurante_id' => 4, 'tipo_comida_id' => 2], // Martín Berasategui: Vasca
            ['restaurante_id' => 4, 'tipo_comida_id' => 10], // Martín Berasategui: Creativa
            ['restaurante_id' => 5, 'tipo_comida_id' => 2], // Akelarre: Vasca
            ['restaurante_id' => 5, 'tipo_comida_id' => 10], // Akelarre: Creativa
            ['restaurante_id' => 6, 'tipo_comida_id' => 7], // Disfrutar: Catalana
            ['restaurante_id' => 6, 'tipo_comida_id' => 10], // Disfrutar: Creativa
            ['restaurante_id' => 7, 'tipo_comida_id' => 1], // Ricard Camarena: Mediterránea
            ['restaurante_id' => 7, 'tipo_comida_id' => 10], // Ricard Camarena: Creativa
            ['restaurante_id' => 8, 'tipo_comida_id' => 1], // Skina: Mediterránea
            ['restaurante_id' => 8, 'tipo_comida_id' => 10], // Skina: Creativa
            ['restaurante_id' => 9, 'tipo_comida_id' => 6], // Casa Marcelo: Gallega
            ['restaurante_id' => 9, 'tipo_comida_id' => 8], // Casa Marcelo: Fusión
            ['restaurante_id' => 10, 'tipo_comida_id' => 5], // Casa Gerardo: Asturiana
            ['restaurante_id' => 10, 'tipo_comida_id' => 9], // Casa Gerardo: Tradicional
            ['restaurante_id' => 11, 'tipo_comida_id' => 2], // Nerua: Vasca
            ['restaurante_id' => 11, 'tipo_comida_id' => 10], // Nerua: Creativa
            ['restaurante_id' => 12, 'tipo_comida_id' => 9], // La Botica: Tradicional
            ['restaurante_id' => 12, 'tipo_comida_id' => 10], // La Botica: Creativa
            ['restaurante_id' => 13, 'tipo_comida_id' => 1], // Abantal: Mediterránea
            ['restaurante_id' => 13, 'tipo_comida_id' => 10], // Abantal: Creativa
            ['restaurante_id' => 14, 'tipo_comida_id' => 10], // El Club Allard: Creativa
            ['restaurante_id' => 14, 'tipo_comida_id' => 8], // El Club Allard: Fusión
            ['restaurante_id' => 15, 'tipo_comida_id' => 8], // DiverXO: Fusión
            ['restaurante_id' => 15, 'tipo_comida_id' => 3], // DiverXO: Japonesa
            ['restaurante_id' => 15, 'tipo_comida_id' => 10], // DiverXO: Creativa
        ]);
    }
}
