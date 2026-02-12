<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenRestaurantePendiente extends Model
{
    protected $table = 'imagenes_restaurante_pendiente';

    protected $fillable = [
        'restaurante_pendiente_id',
        'url',
        'alt',
        'principal',
        'orden',
    ];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function restaurantePendiente(): BelongsTo
    {
        return $this->belongsTo(RestaurantePendiente::class, 'restaurante_pendiente_id');
    }
}
