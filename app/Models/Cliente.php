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

    // Hace que el campo calculado sea visible al convertir a JSON
    protected $appends = ['total_adeudado'];

    // Relación con Persona
    public function persona()
    {
        // Un Cliente pertenece a una Persona (uno a uno)
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Relación con Créditos
    public function creditos()
    {
        // Un Cliente puede tener muchos Créditos (uno a muchos)
        // Asumiendo que tienes un modelo Credito
        return $this->hasMany(Credito::class, 'cliente_id');
    }

    // ACCESORES ÚTILES

    // Indica si el cliente tiene créditos activos (con adeudo > 0)
    public function getTieneCreditosActivosAttribute()
    {
        // Asumiendo que el modelo Credito tiene un campo 'adeudo'
        return $this->creditos()->where('adeudo', '>', 0)->exists();
    }

    // Método para calcular el total adeudado (Accessor)
    public function getTotalAdeudadoAttribute()
    {
        // Suma el campo 'adeudo' de todos los créditos del cliente
        return $this->creditos()->sum('adeudo');
    }

    // *** Acceder a datos de Persona directamente (Delegación) ***

    // Accesor para obtener el nombre completo a través de la persona
    public function getNombreCompletoAttribute()
    {
        return $this->persona ? $this->persona->nombre_completo : 'Sin Nombre';
    }

    // Accesor para el teléfono a través de la persona
    public function getTelefonoAttribute()
    {
        return $this->persona ? $this->persona->telefono : null;
    }
}
