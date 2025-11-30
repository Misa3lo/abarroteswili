<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'codigo_barras',
        'descripcion',
        'precio_venta',
        'precio_compra',
        'departamento_id',
        'existencias'
    ];

    public function departamento()
    {
        // Asumiendo que tienes un modelo llamado 'Departamento'
        return $this->belongsTo(Departamento::class);
    }

    public function surtidos()
    {
        return $this->hasMany(Surtido::class, 'producto_id');
    }
}
