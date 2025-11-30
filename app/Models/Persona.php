<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'nombre',
        'apaterno',
        'amaterno',
        'telefono',
        'direccion'
    ];

    // Relación: Una persona tiene un usuario asociado
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    // Relación: Una persona puede ser un cliente
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'persona_id');
    }
}
