<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurante_id',
        'dia_semana',
        'hora_apertura',
        'hora_cierre',
        'cerrado'
    ];

    protected $casts = [
        'cerrado' => 'boolean',
        'hora_apertura' => 'datetime:H:i',
        'hora_cierre' => 'datetime:H:i',
    ];

    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class);
    }
}
