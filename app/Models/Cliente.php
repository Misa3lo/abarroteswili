<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';
    protected $primaryKey = 'id';

    protected $fillable = [
        'persona_id',
        'limite_credito'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Relación con Créditos
    // En tu modelo Cliente existente, agregar:
    public function creditos()
    {
        return $this->hasMany(Credito::class, 'cliente_id');
    }

// Y este método útil:
    public function getTieneCreditosActivosAttribute()
    {
        return $this->creditos()->where('adeudo', '>', 0)->exists();
    }

    // Accesor para obtener el nombre completo a través de la persona
    public function getNombreCompletoAttribute()
    {
        if ($this->persona) {
            return $this->persona->nombre . ' ' .
                $this->persona->apaterno . ' ' .
                ($this->persona->amaterno ?? '');
        }
        return 'Sin nombre';
    }

    // Accesor para el teléfono
    public function getTelefonoAttribute()
    {
        return $this->persona ? $this->persona->telefono : null;
    }

    // Accesor para la dirección
    public function getDireccionAttribute()
    {
        return $this->persona ? $this->persona->direccion : null;
    }

    // Método para obtener créditos activos (con adeudo > 0)
    public function creditosActivos()
    {
        return $this->creditos()->where('adeudo', '>', 0)->get();
    }

    // Método para calcular el total adeudado
    public function getTotalAdeudadoAttribute()
    {
        return $this->creditos()->sum('adeudo');
    }
}
