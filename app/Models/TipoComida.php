<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoComida extends Model
{
    protected $table = 'tipo_comida';
    
    protected $fillable = ['nombre', 'slug', 'icono'];

    public function restaurantes()
    {
        return $this->belongsToMany(Restaurante::class, 'restaurante_tipo_comida');
    }
}
