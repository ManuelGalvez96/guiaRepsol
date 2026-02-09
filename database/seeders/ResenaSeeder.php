<?php

namespace Database\Seeders;

use App\Models\Resena;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ResenaSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Resena::create([
            'restaurante_id' => 1,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Hemos celebrado nuestro aniversario aquí y ha sido perfecto. El ambiente es acogedor y la comida extraordinaria.',
        ]);

        Resena::create([
            'restaurante_id' => 2,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Local animado con buena oferta de tapas. Ideal para ir con amigos.',
        ]);

        Resena::create([
            'restaurante_id' => 3,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'La creatividad en cada plato es asombrosa. El maridaje de vinos fue excepcional.',
        ]);

        Resena::create([
            'restaurante_id' => 4,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Sin duda merece sus tres soles Repsol. Una experiencia que hay que vivir al menos una vez.',
        ]);

        Resena::create([
            'restaurante_id' => 5,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'La puesta de sol desde el restaurante es mágica, y la comida está a la altura.',
        ]);

        Resena::create([
            'restaurante_id' => 6,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Los antiguos chefs de El Bulli siguen revolucionando la gastronomía. Impresionante.',
        ]);

        Resena::create([
            'restaurante_id' => 7,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Cada plato cuenta una historia del Mediterráneo. Producto de primera y ejecución perfecta.',
        ]);

        Resena::create([
            'restaurante_id' => 8,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Marbella tiene en Skina una joya gastronómica. Todo fue excepcional.',
        ]);

        Resena::create([
            'restaurante_id' => 15,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'DiverXO es una experiencia única. Dabiz Muñoz lleva la cocina a otra dimensión.',
        ]);

        Resena::create([
            'restaurante_id' => 14,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'El palacete es precioso y la comida está a la altura del entorno. Muy recomendable.',
        ]);
    }
}
