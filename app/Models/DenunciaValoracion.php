<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DenunciaValoracion extends Model
{
    protected $table = 'denuncias_valoraciones';

    protected $fillable = [
        'user_id',
        'valoracion_id',
        'razon',
        'estado',
    ];

    /**
     * Usuario que reporta
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Valoración reportada
     */
    public function valoracion()
    {
        return $this->belongsTo(Valoracion::class, 'valoracion_id');
    }
}
