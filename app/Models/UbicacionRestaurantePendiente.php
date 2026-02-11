<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbicacionRestaurantePendiente extends Model
{
    protected $table = 'ubicaciones_restaurante_pendiente';

    protected $fillable = [
        'comunidad_autonoma',
        'provincia',
        'ciudad',
        'codigo_postal',
        'latitud',
        'longitud',
    ];
}
