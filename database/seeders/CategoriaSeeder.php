<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Restaurante',
            'slug' => 'restaurante',
            'descripcion' => 'Establecimientos gastronómicos de alta cocina',
            'icono' => 'bi-shop',
        ]);

        Categoria::create([
            'nombre' => 'Bar',
            'slug' => 'bar',
            'descripcion' => 'Bares y tabernas con oferta gastronómica',
            'icono' => 'bi-cup-straw',
        ]);

        Categoria::create([
            'nombre' => 'Cafetería',
            'slug' => 'cafeteria',
            'descripcion' => 'Cafeterías y locales de desayunos',
            'icono' => 'bi-cup-hot',
        ]);

        Categoria::create([
            'nombre' => 'Gastrobar',
            'slug' => 'gastrobar',
            'descripcion' => 'Espacios modernos con propuesta gastronómica innovadora',
            'icono' => 'bi-moisture',
        ]);
    }
}
