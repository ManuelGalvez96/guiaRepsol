<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikeRestaurante extends Model
{
    protected $table = 'tbl_likes_restaurantes';

    protected $fillable = [
        'user_id',
        'restaurante_id',
    ];
}
