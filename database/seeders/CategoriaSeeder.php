<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            ['nombre' => 'Restaurante', 'slug' => 'restaurante', 'descripcion' => 'Restaurantes tradicionales'],
            ['nombre' => 'Cafetería', 'slug' => 'cafeteria', 'descripcion' => 'Cafeterías y establecimientos de café'],
            ['nombre' => 'Bar', 'slug' => 'bar', 'descripcion' => 'Bares y tabernas'],
            ['nombre' => 'Gastrobar', 'slug' => 'gastrobar', 'descripcion' => 'Gastrobares modernos'],
            ['nombre' => 'Pizzería', 'slug' => 'pizzeria', 'descripcion' => 'Pizzerías italianas'],
            ['nombre' => 'Asador', 'slug' => 'asador', 'descripcion' => 'Asadores y parrillas'],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
