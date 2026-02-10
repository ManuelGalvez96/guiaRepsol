<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuardarRestaurante extends Model
{
    protected $table = 'tbl_guardar_restaurante';

    protected $fillable = [
        'user_id',
        'restaurante_id',
    ];
}
