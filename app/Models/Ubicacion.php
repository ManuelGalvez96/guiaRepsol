<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    
    protected $fillable = [
        'comunidad_autonoma',
        'provincia',
        'ciudad',
        'codigo_postal',
        'latitud',
        'longitud'
    ];

    protected $casts = [
        'latitud' => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class);
    }
}
