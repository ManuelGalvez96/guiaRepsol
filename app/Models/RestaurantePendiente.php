<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RestaurantePendiente extends Model
{
    protected $table = 'restaurante_pendiente';

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
        'categoria_id',
        'ubicacion_pendiente_id',
        'direccion',
        'telefono',
        'email',
        'web',
        'precio',
        'soles',
        'valoracion_promedio',
        'patrocinados',
        'activo',
    ];

    protected $casts = [
        'patrocinados' => 'boolean',
        'activo' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ubicacionPendiente(): BelongsTo
    {
        return $this->belongsTo(UbicacionRestaurantePendiente::class, 'ubicacion_pendiente_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
