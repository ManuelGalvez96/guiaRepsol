<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar los seeders en el orden correcto respetando las dependencias
        $this->call([
            CategoriaSeeder::class,
            TipoComidaSeeder::class,
            UbicacionSeeder::class,
            UserSeeder::class,
            RestauranteSeeder::class,
            RestauranteTipoComidaSeeder::class,
            ValoracionSeeder::class,
            ResenaSeeder::class,
            LikeRestauranteSeeder::class,
            GuardarRestauranteSeeder::class,
        ]);
    }
}
