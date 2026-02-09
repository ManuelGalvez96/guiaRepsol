<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $table = 'valoraciones';
    
    protected $fillable = [
        'restaurante_id',
        'usuario_id',
        'puntuacion',
        'comentario'
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
