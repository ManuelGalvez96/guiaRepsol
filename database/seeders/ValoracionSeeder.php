<?php

namespace Database\Seeders;

use App\Models\Restaurante;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ValoracionSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = User::where('rol', 'usuario')->get();

        if ($usuarios->count() < 15) {
            return;
        }

        $usuarioIndex = 0;

        // Crear valoraciones específicas manualmente
        // Restaurantes con valoraciones altas (4-5 estrellas)
        DB::table('valoraciones')->insert([
            'restaurante_id' => 1, // Tripea
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Excelente comida y servicio impecable. Volveré sin duda.',
            'created_at' => now()->subDays(30),
            'updated_at' => now()->subDays(30),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 1,
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Buena relación calidad-precio. Recomendado.',
            'created_at' => now()->subDays(20),
            'updated_at' => now()->subDays(20),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 2, // Miga Cana
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 5,
            'comentario' => 'El ambiente es muy acogedor y la comida deliciosa.',
            'created_at' => now()->subDays(25),
            'updated_at' => now()->subDays(25),
        ]);

        // Restaurantes con valoraciones bajas (1-2 estrellas)
        DB::table('valoraciones')->insert([
            'restaurante_id' => 3, // Kitchen 154
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 2,
            'comentario' => 'La comida estaba bien pero el servicio muy lento. No volvería.',
            'created_at' => now()->subDays(15),
            'updated_at' => now()->subDays(15),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 3,
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 1,
            'comentario' => 'Muy caro y poco valor. Decepcionante.',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 4, // Martín Berasategui
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 2,
            'comentario' => 'La presentación es bonita pero la comida fría. Esperaba más.',
            'created_at' => now()->subDays(12),
            'updated_at' => now()->subDays(12),
        ]);

        // Restaurantes con valoraciones medias (3 estrellas)
        DB::table('valoraciones')->insert([
            'restaurante_id' => 5, // Akelarre
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 3,
            'comentario' => 'Está bien, nada especial. El precio es algo elevado.',
            'created_at' => now()->subDays(18),
            'updated_at' => now()->subDays(18),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 6, // Disfrutar
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Muy creativo y delicioso. Buena experiencia gastronómica.',
            'created_at' => now()->subDays(22),
            'updated_at' => now()->subDays(22),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 7, // Ricard Camarena
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Increíble variedad de platos y sabores únicos.',
            'created_at' => now()->subDays(28),
            'updated_at' => now()->subDays(28),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 8, // Skina
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Lugar perfecto para ocasiones especiales.',
            'created_at' => now()->subDays(14),
            'updated_at' => now()->subDays(14),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 9, // Casa Marcelo
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Una experiencia culinaria inolvidable.',
            'created_at' => now()->subDays(35),
            'updated_at' => now()->subDays(35),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 10, // Casa Gerardo
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 1,
            'comentario' => 'Muy decepcionante. Comida fría y personal desatento.',
            'created_at' => now()->subDays(8),
            'updated_at' => now()->subDays(8),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 11, // Nerua
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 5,
            'comentario' => 'Excelente. El personal muy atento y profesional.',
            'created_at' => now()->subDays(19),
            'updated_at' => now()->subDays(19),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 12, // La Botica
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 3,
            'comentario' => 'Aceptable. Comida tradicional, nada excepcional.',
            'created_at' => now()->subDays(11),
            'updated_at' => now()->subDays(11),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 13, // Abantal
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 4,
            'comentario' => 'Servicio rápido y platos bien presentados.',
            'created_at' => now()->subDays(24),
            'updated_at' => now()->subDays(24),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 14, // El Club Allard
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 5,
            'comentario' => 'Sofisticado y delicioso. Volvería sin dudarlo.',
            'created_at' => now()->subDays(32),
            'updated_at' => now()->subDays(32),
        ]);

        DB::table('valoraciones')->insert([
            'restaurante_id' => 15, // DiverXO
            'usuario_id' => $usuarios[$usuarioIndex++]->id,
            'puntuacion' => 2,
            'comentario' => 'Demasiado experimental. No recomendado.',
            'created_at' => now()->subDays(9),
            'updated_at' => now()->subDays(9),
        ]);

        // Actualizar valoración promedio para TODOS los restaurantes aceptados
        $restaurantes = Restaurante::where('estado', 'aceptado')->get();

        foreach ($restaurantes as $restaurante) {
            $promedio = DB::table('valoraciones')
                ->where('restaurante_id', $restaurante->id)
                ->avg('puntuacion');
            
            // Si no hay valoraciones, dejar en 0. Si hay, actualizar con el promedio
            $restaurante->update(['valoracion_promedio' => $promedio ? round($promedio, 2) : 0]);
        }
    }
}

