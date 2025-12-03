<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credito extends Model
{
    use SoftDeletes;

    // Las columnas que pueden ser asignadas masivamente (incluyendo 'estado')
    protected $fillable = [
        'cliente_id',
        'ticket_id',
        'monto_original',
        'adeudo', // La columna que usamos para el saldo pendiente
        'estado', // 🚨 ¡ESTA ES LA CORRECCIÓN FALTANTE!
    ];

    // ✅ CORRECCIÓN 2: El array $casts es el que define el tipo de dato
    protected $casts = [
        // Aseguramos que los campos monetarios se traten como decimales con 2 dígitos
        'monto_original' => 'decimal:2',
        'adeudo' => 'decimal:2',
    ];

    // Las columnas que deben ser tratadas como objetos Carbon
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * Relación con el Ticket (1 a 1).
     * Usa 'unsignedInteger' si la ID de tickets es INT(11)
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    /**
     * Relación con el Cliente (1 a 1).
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Relación con los Abonos (1 a Muchos).
     */
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'credito_id');
    }
}
