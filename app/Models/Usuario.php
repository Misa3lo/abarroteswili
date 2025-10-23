<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';
    protected $fillable = ['persona_id', 'usuario', 'password', 'rol'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->persona ? $this->persona->nombre_completo : 'N/A';
    }

    public function getCantidadTicketsAttribute()
    {
        return $this->tickets->count();
    }

    public function isAdministrador()
    {
        return $this->rol === 'administrador';
    }

    public function isEmpleado()
    {
        return $this->rol === 'empleado';
    }
}
