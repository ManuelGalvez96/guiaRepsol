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

        // Additional 39 valoraciones
        Valoracion::create([
            'restaurante_id' => 11,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Impresionante experiencia gastronómica. El servicio es perfecto.',
        ]);

        Valoracion::create([
            'restaurante_id' => 12,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Menú degustación muy interesante, aunque algunos platos demasiado elaborados.',
        ]);

        Valoracion::create([
            'restaurante_id' => 13,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Cada plato supera al anterior. La creatividad es asombrosa.',
        ]);

        Valoracion::create([
            'restaurante_id' => 14,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'El palacete es precioso y la comida está a la altura.',
        ]);

        Valoracion::create([
            'restaurante_id' => 15,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'DiverXO merece cada una de sus estrellas. Experiencia única.',
        ]);

        Valoracion::create([
            'restaurante_id' => 1,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Buen restaurante pero algo caro para lo que ofrece.',
        ]);

        Valoracion::create([
            'restaurante_id' => 2,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Perfecto para tapear. El ambiente es genial.',
        ]);

        Valoracion::create([
            'restaurante_id' => 3,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'La creatividad del chef es espectacular.',
        ]);

        Valoracion::create([
            'restaurante_id' => 16,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Paco Roncero sigue demostrando su maestría.',
        ]);

        Valoracion::create([
            'restaurante_id' => 17,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Los hermanos Sandoval han creado algo especial.',
        ]);

        Valoracion::create([
            'restaurante_id' => 18,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Servicio impecable y cocina exquisita.',
        ]);

        Valoracion::create([
            'restaurante_id' => 19,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Martín Berasategui en Barcelona es garantía de éxito.',
        ]);

        Valoracion::create([
            'restaurante_id' => 20,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Muy buena cocina, pero esperaba algo más innovador.',
        ]);

        Valoracion::create([
            'restaurante_id' => 21,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Eneko Atxa es un genio de la cocina sostenible.',
        ]);

        Valoracion::create([
            'restaurante_id' => 22,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Mugaritz siempre sorprende. Una experiencia única.',
        ]);

        Valoracion::create([
            'restaurante_id' => 23,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Arzak es historia viva de la gastronomía vasca.',
        ]);

        Valoracion::create([
            'restaurante_id' => 24,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'La parrilla de Victor Arguinzoniz es arte puro.',
        ]);

        Valoracion::create([
            'restaurante_id' => 25,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Quique Dacosta lleva la cocina mediterránea a otro nivel.',
        ]);

        Valoracion::create([
            'restaurante_id' => 26,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'El Celler de Can Roca es sencillamente perfecto.',
        ]);

        Valoracion::create([
            'restaurante_id' => 27,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Tickets es divertido y la comida está muy buena.',
        ]);

        Valoracion::create([
            'restaurante_id' => 28,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Ambiente acogedor y comida casera de calidad.',
        ]);

        Valoracion::create([
            'restaurante_id' => 29,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Juanjo López hace magia con los productos del mercado.',
        ]);

        Valoracion::create([
            'restaurante_id' => 30,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Cocina andaluza elegante en un entorno precioso.',
        ]);

        Valoracion::create([
            'restaurante_id' => 31,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'El Poblet tiene una propuesta muy interesante.',
        ]);

        Valoracion::create([
            'restaurante_id' => 32,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Buena cocina mediterránea con producto fresco.',
        ]);

        Valoracion::create([
            'restaurante_id' => 33,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Bardal ofrece vistas y cocina espectaculares.',
        ]);

        Valoracion::create([
            'restaurante_id' => 34,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'El caviar de Sollo es el mejor que he probado.',
        ]);

        Valoracion::create([
            'restaurante_id' => 35,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Ángel León revoluciona la cocina con su plancton marino.',
        ]);

        Valoracion::create([
            'restaurante_id' => 36,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Atrio y su bodega son legendarios.',
        ]);

        Valoracion::create([
            'restaurante_id' => 37,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Cenador de Amós combina tradición e innovación perfectamente.',
        ]);

        Valoracion::create([
            'restaurante_id' => 38,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'La fusión nikkei de Kabuki es muy acertada.',
        ]);

        Valoracion::create([
            'restaurante_id' => 39,
            'usuario_id' => 5,
            'puntuacion' => 4,
            'comentario' => 'Buena propuesta gastronómica y excelente coctelería.',
        ]);

        Valoracion::create([
            'restaurante_id' => 40,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Pescado fresco de primera calidad.',
        ]);

        Valoracion::create([
            'restaurante_id' => 41,
            'usuario_id' => 2,
            'puntuacion' => 4,
            'comentario' => 'Los huevos estrellados de Casa Lucio son míticos.',
        ]);

        Valoracion::create([
            'restaurante_id' => 42,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Un clásico que hay que visitar al menos una vez.',
        ]);

        Valoracion::create([
            'restaurante_id' => 43,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Cocina manchega auténtica y sabrosa.',
        ]);

        Valoracion::create([
            'restaurante_id' => 44,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Ramón Freixa es un maestro de la alta cocina.',
        ]);

        Valoracion::create([
            'restaurante_id' => 45,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Propuesta interesante con productos locales.',
        ]);

        Valoracion::create([
            'restaurante_id' => 46,
            'usuario_id' => 2,
            'puntuacion' => 3,
            'comentario' => 'Buena comida pero el servicio fue lento.',
        ]);

        Valoracion::create([
            'restaurante_id' => 47,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Zalacaín mantiene su prestigio después de tantos años.',
        ]);

        Valoracion::create([
            'restaurante_id' => 48,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Cocina vasca moderna en su máxima expresión.',
        ]);

        Valoracion::create([
            'restaurante_id' => 49,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Cinc Sentits ofrece una experiencia sensorial completa.',
        ]);

        Valoracion::create([
            'restaurante_id' => 50,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Cocina castellana con toques actuales.',
        ]);
    }
}
