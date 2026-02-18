<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudEliminacionRestaurante extends Model
{
    protected $table = 'solicitudes_eliminacion_restaurantes';

    protected $fillable = [
        'restaurante_id',
        'gerente_id',
        'razon',
        'estado',
        'admin_id',
        'respondido_at',
    ];

    protected $casts = [
        'respondido_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Restaurante a eliminar
     */
    public function restaurante()
    {
        return $this->belongsTo(Restaurante::class, 'restaurante_id');
    }

    /**
     * Gerente que solicita
     */
    public function gerente()
    {
        return $this->belongsTo(User::class, 'gerente_id');
    }

    /**
     * Admin que responde (si aplica)
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
