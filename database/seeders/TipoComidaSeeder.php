<?php

namespace Database\Seeders;

use App\Models\TipoComida;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoComidaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoComida::create([
            'nombre' => 'Mediterránea',
            'slug' => 'mediterranea',
            'icono' => 'bi-sun',
        ]);

        TipoComida::create([
            'nombre' => 'Vasca',
            'slug' => 'vasca',
            'icono' => 'bi-geo-alt',
        ]);

        TipoComida::create([
            'nombre' => 'Japonesa',
            'slug' => 'japonesa',
            'icono' => 'bi-chopsticks',
        ]);

        TipoComida::create([
            'nombre' => 'Italiana',
            'slug' => 'italiana',
            'icono' => 'bi-pizza',
        ]);

        TipoComida::create([
            'nombre' => 'Asturiana',
            'slug' => 'asturiana',
            'icono' => 'bi-mountain',
        ]);

        TipoComida::create([
            'nombre' => 'Gallega',
            'slug' => 'gallega',
            'icono' => 'bi-water',
        ]);

        TipoComida::create([
            'nombre' => 'Catalana',
            'slug' => 'catalana',
            'icono' => 'bi-building',
        ]);

        TipoComida::create([
            'nombre' => 'Fusión',
            'slug' => 'fusion',
            'icono' => 'bi-bezier2',
        ]);

        TipoComida::create([
            'nombre' => 'Tradicional española',
            'slug' => 'tradicional-espanola',
            'icono' => 'bi-flag',
        ]);

        TipoComida::create([
            'nombre' => 'Creativa',
            'slug' => 'creativa',
            'icono' => 'bi-stars',
        ]);
    }
}
