<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TipoComidaRestaurantePendiente extends Model
{
    protected $table = 'tipo_comida_restaurante_pendiente';

    protected $fillable = [
        'restaurante_pendiente_id',
        'tipo_comida_id',
    ];

    public function restaurantePendiente(): BelongsTo
    {
        return $this->belongsTo(RestaurantePendiente::class, 'restaurante_pendiente_id');
    }

    public function tipoComida(): BelongsTo
    {
        return $this->belongsTo(TipoComida::class, 'tipo_comida_id');
    }
}
