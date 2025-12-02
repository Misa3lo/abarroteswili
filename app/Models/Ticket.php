<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    public $timestamps = false; // Esto ya lo tenías, ¡déjalo así!

    protected $fillable = [
        'folio',
        'usuario_id',
        'cliente_id',
        'metodo_pago_id',
        'total'
    ];

    // ✅ CORRECCIÓN: Convertir 'fecha_hora' a objeto de fecha automáticamente
    protected $casts = [
        'fecha_hora' => 'datetime',
    ];

    // ... (El resto de tus relaciones: ventas, cliente, etc.)
    public function ventas() { return $this->hasMany(Venta::class, 'ticket_id'); }
    public function cliente() { return $this->belongsTo(Cliente::class, 'cliente_id'); }
    public function metodoPago() { return $this->belongsTo(MetodoPago::class, 'metodo_pago_id'); }
    public function usuario() { return $this->belongsTo(Usuario::class, 'usuario_id'); }
}
