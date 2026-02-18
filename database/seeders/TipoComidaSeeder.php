<?php

namespace Database\Seeders;

use App\Models\TipoComida;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TipoComidaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Mediterránea',
            'Española',
            'Japonesa',
            'Italiana',
            'Mexicana',
            'Vasca',
            'Catalana',
            'Asturiana',
            'Gallega',
            'Andaluza',
            'Mariscos',
            'Carnes',
            'Pescados',
            'Vegetariana',
            'Fusión',
        ];

        foreach ($tipos as $nombre) {
            TipoComida::create([
                'nombre' => $nombre,
                'slug' => Str::slug($nombre),
            ]);
        }
    }
}
