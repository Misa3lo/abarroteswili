<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ventas';
    protected $fillable = ['ticket_id', 'producto_id', 'cantidad', 'precio'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->cantidad * $this->precio;
    }

    public function getGananciaAttribute()
    {
        if ($this->producto) {
            $gananciaUnitaria = $this->precio - $this->producto->precio_compra;
            return $gananciaUnitaria * $this->cantidad;
        }
        return 0;
    }
}
