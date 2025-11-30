<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- ¡CLAVE!

class Usuario extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';

    protected $hidden = [
        'password',
    ];
    // Indica a Laravel que el campo de nombre de usuario es 'usuario'
    // SIN ESTO, LARAVEL BUSCA EL CAMPO 'email'.
    public function getAuthIdentifierName()
    {
        return 'usuario';
    }

    // ... (otras propiedades)

    protected $fillable = [
        'persona_id',
        'usuario',
        'password',
        'rol',
    ];


}
