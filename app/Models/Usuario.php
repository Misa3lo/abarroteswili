<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';

    protected $hidden = [
        'password',
    ];

    // Indica a Laravel que el campo de nombre de usuario es 'usuario'
    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    protected $fillable = [
        'persona_id',
        'usuario',
        'password',
        'rol',
    ];

    // ********** ¡AÑADE ESTE MÉTODO! **********
    /**
     * Define la relación de Usuario con Persona (Un Usuario pertenece a una Persona).
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }
    // *******************************************
}

// Asegúrate de que Persona esté importada si la tienes en un namespace diferente
// Aunque generalmente no es necesario si está en el mismo App\Models
