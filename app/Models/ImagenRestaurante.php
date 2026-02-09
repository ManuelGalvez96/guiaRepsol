<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenRestaurante extends Model
{
    use HasFactory;

    protected $table = 'imagenes_restaurante';

    protected $fillable = [
        'restaurante_id',
        'ruta_imagen',
        'orden',
        'es_principal'
    ];

    protected $casts = [
        'es_principal' => 'boolean',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
