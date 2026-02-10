<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenRestaurante extends Model
{
    protected $table = 'imagenes_restaurante';

    protected $fillable = [
        'restaurante_id',
        'url',
        'alt',
        'principal',
        'orden',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function restaurante(): BelongsTo
    {
        return $this->belongsTo(Restaurante::class);
    }
}
