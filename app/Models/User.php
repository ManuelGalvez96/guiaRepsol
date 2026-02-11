<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'apellidos',
        'email',
        'password',
        'rol',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the restaurantes owned by the user.
     */
    public function restaurantes()
    {
        return $this->hasMany(Restaurante::class);
    }

    /**
     * Restaurantes que el usuario ha dado like.
     */
    public function restaurantesLiked()
    {
        return $this->belongsToMany(Restaurante::class, 'tbl_likes_restaurantes')
            ->withTimestamps();
    }

    /**
     * Restaurantes guardados por el usuario.
     */
    public function restaurantesGuardados()
    {
        return $this->belongsToMany(Restaurante::class, 'tbl_guardar_restaurante')
            ->withTimestamps();
    }
}