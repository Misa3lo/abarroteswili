<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $fillable = [
        'folio',
        'usuario_id',
        'cliente_id',
        'metodo_pago_id',
        'total'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->fecha_hora = now();
        });
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function getFechaFormateadaAttribute()
    {
        return $this->fecha_hora->format('d/m/Y H:i');
    }

    public function getCantidadProductosAttribute()
    {
        return $this->ventas->sum('cantidad');
    }
}
