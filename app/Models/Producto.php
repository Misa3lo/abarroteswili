<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'precio_compra',
        'departamento_id',
        'existencias'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function surtidos()
    {
        return $this->hasMany(Surtido::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function getGananciaUnitariaAttribute()
    {
        return $this->precio_venta - $this->precio_compra;
    }

    public function getEstadoStockAttribute()
    {
        if ($this->existencias == 0) {
            return 'Agotado';
        } elseif ($this->existencias < 10) {
            return 'Bajo Stock';
        } else {
            return 'Disponible';
        }
    }
}
