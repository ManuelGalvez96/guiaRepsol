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

        // Additional 40 reseñas
        Resena::create([
            'restaurante_id' => 11,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Nerua en el Guggenheim combina arte y gastronomía de forma magistral. El menú degustación es una experiencia completa que te hace viajar por los sabores vascos más auténticos.',
        ]);

        Resena::create([
            'restaurante_id' => 12,
            'usuario_id' => 5,
            'puntuacion' => 4,
            'comentario' => 'La Botica es un descubrimiento en Matapozuelos. La cocina castellana renovada con mucho respeto por el producto local. El lechazo es excepcional.',
        ]);

        Resena::create([
            'restaurante_id' => 13,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Abantal en Sevilla es una joya. La fusión de cocina andaluza con técnicas modernas crea platos sorprendentes. El servicio es atento sin ser agobiante.',
        ]);

        Resena::create([
            'restaurante_id' => 16,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'La Terraza del Casino es puro lujo. Paco Roncero demuestra por qué es uno de los grandes de la gastronomía española. Las vistas desde el Casino de Madrid son el complemento perfecto.',
        ]);

        Resena::create([
            'restaurante_id' => 17,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Coque es una experiencia única desde que entras. Los hermanos Sandoval han creado un templo gastronómico donde cada detalle está cuidado al máximo. El viaje por las tres estancias es inolvidable.',
        ]);

        Resena::create([
            'restaurante_id' => 18,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Santceloni mantiene su nivel de excelencia año tras año. El servicio es impecable y la bodega espectacular. Cada plato es una lección de cocina española contemporánea.',
        ]);

        Resena::create([
            'restaurante_id' => 19,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Lasarte en Barcelona es la extensión perfecta del universo de Martín Berasategui. La cocina es técnica, precisa y llena de sabor. Un imprescindible en Barcelona.',
        ]);

        Resena::create([
            'restaurante_id' => 20,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Moments en el Mandarin Oriental ofrece una experiencia de lujo total. La cocina de Carme Ruscalleda fusiona tradición catalana con toques innovadores. El ambiente es elegante y acogedor.',
        ]);

        Resena::create([
            'restaurante_id' => 21,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Azurmendi es mucho más que un restaurante, es una declaración de intenciones sobre sostenibilidad y cocina de vanguardia. Eneko Atxa ha creado algo verdaderamente especial.',
        ]);

        Resena::create([
            'restaurante_id' => 22,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Mugaritz desafía todas las convenciones. Andoni Luis Aduriz te hace reflexionar sobre qué es la comida y qué significa comer. Una experiencia filosófica además de gastronómica.',
        ]);

        Resena::create([
            'restaurante_id' => 23,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Arzak es historia viva de la gastronomía vasca. Juan Mari y Elena Arzak continúan innovando sin perder la esencia. Cada visita es un recuerdo imborrable.',
        ]);

        Resena::create([
            'restaurante_id' => 24,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Etxebarri es la demostración de que la simplicidad puede ser sublime. Victor Arguinzoniz eleva la parrilla a categoría de arte. El producto es el protagonista absoluto.',
        ]);

        Resena::create([
            'restaurante_id' => 25,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Quique Dacosta en Dénia es una celebración del Mediterráneo. Cada plato cuenta una historia del mar y la tierra. La técnica es impecable y la creatividad desbordante.',
        ]);

        Resena::create([
            'restaurante_id' => 26,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'El Celler de Can Roca es perfección absoluta. Los hermanos Roca han creado un universo gastronómico completo donde cocina, servicio y vino se entrelazan magistralmente.',
        ]);

        Resena::create([
            'restaurante_id' => 27,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Tickets Bar es pura diversión. El equipo de Adrià ha creado un espacio donde las tapas de alta cocina se sirven en un ambiente desenfadado y animado. Ideal para grupos.',
        ]);

        Resena::create([
            'restaurante_id' => 28,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Casa Mono ofrece cocina tradicional española con toques contemporáneos. El ambiente es acogedor y familiar. Perfecto para una comida tranquila sin grandes pretensiones.',
        ]);

        Resena::create([
            'restaurante_id' => 29,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'La Tasquita de Enfrente es un secreto bien guardado en Madrid. Juanjo López trabaja con productos de mercado creando platos sorprendentes. Pequeño pero con gran alma.',
        ]);

        Resena::create([
            'restaurante_id' => 30,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Taberna del Alabardero en Sevilla combina tradición e historia. El palacio del siglo XIX es espectacular y la cocina andaluza está muy bien ejecutada.',
        ]);

        Resena::create([
            'restaurante_id' => 31,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'El Poblet demuestra la versatilidad de Quique Dacosta. Cocina valenciana moderna con técnica impecable. El arroz meloso es una maravilla.',
        ]);

        Resena::create([
            'restaurante_id' => 32,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'La Salita ofrece cocina mediterránea de autor en un ambiente íntimo. El producto de temporada es el protagonista y la ejecución es muy cuidada.',
        ]);

        Resena::create([
            'restaurante_id' => 33,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Bardal en Ronda es espectacular en todos los sentidos. Las vistas del Tajo son impresionantes y la cocina de Benito Gómez está a la altura del paisaje.',
        ]);

        Resena::create([
            'restaurante_id' => 34,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Sollo es el templo del caviar en España. Diego Gallegos ha revolucionado la cocina española con su trabajo con esturiones y pescados de estero. Simplemente brillante.',
        ]);

        Resena::create([
            'restaurante_id' => 35,
            'usuario_id' => 1,
            'puntuacion' => 5,
            'comentario' => 'Aponiente es la demostración de que Ángel León merece el título de Chef del Mar. El plancton marino y sus elaboraciones te hacen ver el mar con otros ojos.',
        ]);

        Resena::create([
            'restaurante_id' => 36,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Atrio en Cáceres es una experiencia completa. Toño Pérez crea platos exquisitos y la bodega con más de 3000 referencias es un tesoro. El hotel relicario es el complemento perfecto.',
        ]);

        Resena::create([
            'restaurante_id' => 37,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Cenador de Amós es un remanso de paz en Cantabria. Jesús Sánchez trabaja el producto cántabro con un respeto absoluto. La presentación de los platos es arte puro.',
        ]);

        Resena::create([
            'restaurante_id' => 38,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'Kabuki ofrece una fusión nikkei muy interesante. Ricardo Sanz ha sabido combinar la precisión japonesa con el sabor mediterráneo. El tataki de atún es excepcional.',
        ]);

        Resena::create([
            'restaurante_id' => 39,
            'usuario_id' => 5,
            'puntuacion' => 4,
            'comentario' => 'Cañadío es perfecto para una velada especial. La coctelería es de primer nivel y los platos están muy bien pensados. El ambiente es sofisticado pero no pretencioso.',
        ]);

        Resena::create([
            'restaurante_id' => 40,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'La Maruca es sinónimo de pescado fresco. El producto del Cantábrico llega a la mesa en condiciones óptimas. Simple pero delicioso.',
        ]);

        Resena::create([
            'restaurante_id' => 41,
            'usuario_id' => 2,
            'puntuacion' => 4,
            'comentario' => 'Casa Lucio es un clásico de Madrid. Los huevos rotos son legendarios y el cochinillo también merece la pena. Ambiente tradicional y familiar.',
        ]);

        Resena::create([
            'restaurante_id' => 42,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Botín tiene el encanto de ser el restaurante más antiguo del mundo. El cochinillo asado es su especialidad y está bien ejecutado. La historia que se respira entre sus paredes es única.',
        ]);

        Resena::create([
            'restaurante_id' => 43,
            'usuario_id' => 4,
            'puntuacion' => 4,
            'comentario' => 'El Molino de Enmedio rescata recetas tradicionales manchegas y las presenta con elegancia. El cordero y las migas son imprescindibles. Excelente relación calidad-precio.',
        ]);

        Resena::create([
            'restaurante_id' => 44,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Ramón Freixa Madrid es refinamiento absoluto. Cada plato es una obra de arte que además sabe espectacular. El servicio es impecable y la bodega muy completa.',
        ]);

        Resena::create([
            'restaurante_id' => 45,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Maralba trabaja con productos de Almansa y la comarca con mucho acierto. La cocina es de arraigo pero con presentaciones actuales. Muy recomendable.',
        ]);

        Resena::create([
            'restaurante_id' => 46,
            'usuario_id' => 2,
            'puntuacion' => 3,
            'comentario' => 'El Refectorio tiene un entorno precioso en el convento. La cocina leonesa es correcta aunque esperaba algo más. El servicio fue algo lento el día que fuimos.',
        ]);

        Resena::create([
            'restaurante_id' => 47,
            'usuario_id' => 3,
            'puntuacion' => 4,
            'comentario' => 'Zalacaín es una institución que mantiene su prestigio. La cocina clásica española está bien ejecutada y el servicio es muy profesional. Un clásico que no defrauda.',
        ]);

        Resena::create([
            'restaurante_id' => 48,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Topa Sukaldería en San Sebastián ofrece cocina vasca moderna sin artificios. Los productos de la huerta y el mar se trabajan con mucho respeto. Todo estaba delicioso.',
        ]);

        Resena::create([
            'restaurante_id' => 49,
            'usuario_id' => 5,
            'puntuacion' => 5,
            'comentario' => 'Cinc Sentits hace honor a su nombre. La experiencia sensorial es completa y la cocina catalana contemporánea está magistralmente ejecutada. Espacio íntimo y acogedor.',
        ]);

        Resena::create([
            'restaurante_id' => 50,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Villena en Segovia ofrece cocina castellana de mercado con toques actuales. El cochinillo es excelente y los postres creativos. Muy buena propuesta en plena Plaza Mayor.',
        ]);

        Resena::create([
            'restaurante_id' => 1,
            'usuario_id' => 3,
            'puntuacion' => 5,
            'comentario' => 'Tripea sigue siendo uno de mis favoritos en Madrid. Las carnes son de primera calidad y el servicio siempre atento. La relación calidad-precio es excelente.',
        ]);

        Resena::create([
            'restaurante_id' => 2,
            'usuario_id' => 1,
            'puntuacion' => 4,
            'comentario' => 'Miga Cana es perfecto para una comida informal pero de calidad. Los arroces están muy ricos y la carta de vinos es interesante. Ambiente animado.',
        ]);

        Resena::create([
            'restaurante_id' => 9,
            'usuario_id' => 2,
            'puntuacion' => 5,
            'comentario' => 'Casa Marcelo es un descubrimiento en Santiago. La fusión gallego-asiática funciona sorprendentemente bien. El pulpo es el mejor que he probado en mucho tiempo.',
        ]);

        Resena::create([
            'restaurante_id' => 10,
            'usuario_id' => 4,
            'puntuacion' => 5,
            'comentario' => 'Casa Gerardo en Asturias es tradición renovada. Los productos asturianos se trabajan con técnicas modernas. La fabada es una reinterpretación brillante del clásico.',
        ]);
    }
}
