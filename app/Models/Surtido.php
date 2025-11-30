<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surtido extends Model
{
    use HasFactory, SoftDeletes;

    // Indica a Laravel el nombre de la columna de creación (ya que no es 'created_at')
    const CREATED_AT = 'fecha_hora'; // Usa el nombre exacto de la columna

    // UPDATED_AT se mantiene por defecto como 'updated_at'

    protected $table = 'surtidos';

    // Definimos la clave primaria como no autoincrementable si fuera el caso,
    // pero la dejaremos en el comportamiento por defecto de Laravel por ahora.

    protected $fillable = [
        'producto_id',
        'precio_entrada',
        'cantidad',
    ];

    /**
     * Relación con Producto
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
