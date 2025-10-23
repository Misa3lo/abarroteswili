<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';
    protected $fillable = ['nombre', 'apaterno', 'amaterno', 'telefono', 'direccion'];

    public function cliente()
    {
        return $this->hasOne(Cliente::class);
    }

    public function usuario()
    {
        return $this->hasOne(Usuario::class);
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apaterno . ' ' . ($this->amaterno ?? '');
    }

    public function getTieneClienteAttribute()
    {
        return $this->cliente()->exists();
    }

    public function getTieneUsuarioAttribute()
    {
        return $this->usuario()->exists();
    }
}
