<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurante extends Model
{
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
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'valoracion_promedio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function tiposComida()
    {
        return $this->belongsToMany(TipoComida::class, 'restaurante_tipo_comida');
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }
}
