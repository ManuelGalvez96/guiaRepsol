<?php

namespace Database\Seeders;

use App\Models\Valoracion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ValoracionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Valoracion::create([
            'restaurante_id' => 1,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Excelente experiencia gastronómica. Las carnes estaban en su punto perfecto.',
        ]);

        Valoracion::create([
            'restaurante_id' => 1,
            'usuario_id' => 2,
            'puntuacion' => 4,
            'comentario' => 'Muy buena cocina, aunque el servicio podría mejorar un poco.',
        ]);

        Valoracion::create([
            'restaurante_id' => 2,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Relación calidad-precio increíble. Los arroces son espectaculares.',
        ]);

        Valoracion::create([
            'restaurante_id' => 3,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Uno de los mejores restaurantes de Madrid. Imprescindible el menú degustación.',
        ]);

        Valoracion::create([
            'restaurante_id' => 4,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Una experiencia inolvidable. Cada plato es una obra de arte.',
        ]);

        Valoracion::create([
            'restaurante_id' => 5,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Las vistas y la comida son de otro nivel. Absolutamente recomendable.',
        ]);

        Valoracion::create([
            'restaurante_id' => 6,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Innovación en estado puro. Cada bocado sorprende.',
        ]);

        Valoracion::create([
            'restaurante_id' => 7,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Ricard Camarena vuelve a demostrar su maestría con el producto valenciano.',
        ]);

        Valoracion::create([
            'restaurante_id' => 8,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Pequeño pero con una propuesta gastronómica impresionante.',
        ]);

        Valoracion::create([
            'restaurante_id' => 9,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Fusión gallego-asiática muy interesante. Destaca el pulpo.',
        ]);

        Valoracion::create([
            'restaurante_id' => 10,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Cocina asturiana de la más alta calidad. La fabada es sublime.',
        ]);
    }
}
