<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurante extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'user_id',
        'categoria_id',
        'ubicacion_id',
        'direccion',
        'telefono',
        'email',
        'web',
        'precio',
        'soles',
        'valoracion_promedio',
        'patrocinados',
        'activo'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'valoracion_promedio' => 'decimal:2',
        'patrocinados' => 'boolean',
        'activo' => 'boolean',
    ];

    // Relaciones
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }

    public function valoraciones()
    {
        return $this->hasMany(Valoracion::class);
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenRestaurante::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function tiposComida()
    {
        return $this->belongsToMany(TipoComida::class, 'restaurante_tipo_comida');
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }

    public function gerente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Usuarios que dieron like al restaurante.
     */
    public function usuariosLikes()
    {
        return $this->belongsToMany(User::class, 'tbl_likes_restaurantes')
            ->withTimestamps();
    }

    /**
     * Usuarios que guardaron el restaurante.
     */
    public function usuariosGuardados()
    {
        return $this->belongsToMany(User::class, 'tbl_guardar_restaurante')
            ->withTimestamps();
    }
}

