<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ventas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ticket_id',
        'producto_id',
        'cantidad',
        'precio'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    // Relación con Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    // Accesor para el subtotal de la venta
    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio;
    }

    // Accesor para el subtotal formateado
    public function getSubtotalFormateadoAttribute()
    {
        return '$' . number_format($this->subtotal, 2);
    }

    // Accesor para el precio formateado
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }

    // Accesor para la ganancia de esta venta
    public function getGananciaAttribute()
    {
        if ($this->producto) {
            $gananciaUnidad = $this->precio - $this->producto->precio_compra;
            return $gananciaUnidad * $this->cantidad;
        }
        return 0;
    }

    // Accesor para la ganancia formateada
    public function getGananciaFormateadaAttribute()
    {
        return '$' . number_format($this->ganancia, 2);
    }

    // Accesor para el nombre del producto (útil para vistas)
    public function getNombreProductoAttribute()
    {
        return $this->producto ? $this->producto->nombre : 'Producto no encontrado';
    }

    // Scope para ventas de un ticket específico
    public function scopePorTicket($query, $ticketId)
    {
        return $query->where('ticket_id', $ticketId);
    }

    // Scope para ventas de un producto específico
    public function scopePorProducto($query, $productoId)
    {
        return $query->where('producto_id', $productoId);
    }

    // Scope para ventas en un rango de fechas (a través del ticket)
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereHas('ticket', function($q) use ($fechaInicio, $fechaFin) {
            $q->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
        });
    }

    // Método para verificar si hay suficiente stock al momento de la venta
    public function getHuboStockSuficienteAttribute()
    {
        if ($this->producto) {
            return $this->producto->existencias >= $this->cantidad;
        }
        return false;
    }
}
