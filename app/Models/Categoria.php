<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = ['nombre', 'slug', 'descripcion', 'icono'];

    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class);
    }
}
