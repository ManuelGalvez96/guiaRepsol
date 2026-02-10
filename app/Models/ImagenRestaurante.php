<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenRestaurante extends Model
{
    protected $table = 'imagenes_restaurante';

    protected $fillable = [
        'restaurante_id',
        'url',
        'alt',
        'principal',
        'orden'
    ];

    protected $casts = [
        'principal' => 'boolean',
        'orden' => 'integer'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
