<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Surtido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surtidos';
    protected $fillable = ['producto_id', 'precio_entrada', 'cantidad', 'fecha_hora'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($surtido) {
            $surtido->fecha_hora = now();
        });
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function getTotalEntradaAttribute()
    {
        return $this->precio_entrada * $this->cantidad;
    }

    public function getFechaFormateadaAttribute()
    {
        return $this->fecha_hora->format('d/m/Y H:i');
    }
}
