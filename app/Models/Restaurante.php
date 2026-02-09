<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'categoria_id',
        'ubicacion_id',
        'direccion',
        'telefono',
        'email',
        'web',
        'precio',
        'soles',
        'valoracion_promedio',
        'activo',
        'imagen'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'valoracion_promedio' => 'decimal:2',
        'activo' => 'boolean',
    ];
}
