<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;

    protected $table = 'ubicaciones';

    protected $fillable = [
        'comunidad_autonoma',
        'provincia',
        'ciudad',
        'codigo_postal',
        'latitud',
        'longitud'
    ];

    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class);
    }
}
