<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'precio_compra',
        'departamento_id',
        'existencias'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    // Relación con Surtidos
    public function surtidos()
    {
        return $this->hasMany(Surtido::class, 'producto_id');
    }

    // Relación con Ventas
    // En el modelo Producto, agregar esta relación:
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'producto_id');
    }

    // Accesor para el precio de venta formateado
    public function getPrecioVentaFormateadoAttribute()
    {
        return '$' . number_format($this->precio_venta, 2);
    }

    // Accesor para el precio de compra formateado
    public function getPrecioCompraFormateadoAttribute()
    {
        return '$' . number_format($this->precio_compra, 2);
    }

    // Accesor para la ganancia por unidad
    public function getGananciaUnidadAttribute()
    {
        return $this->precio_venta - $this->precio_compra;
    }

    // Accesor para la ganancia formateada
    public function getGananciaUnidadFormateadaAttribute()
    {
        return '$' . number_format($this->ganancia_unidad, 2);
    }

    // Accesor para el margen de ganancia porcentual
    public function getMargenGananciaAttribute()
    {
        if ($this->precio_compra > 0) {
            return (($this->precio_venta - $this->precio_compra) / $this->precio_compra) * 100;
        }
        return 0;
    }

    // Accesor para verificar si tiene existencias
    public function getTieneExistenciasAttribute()
    {
        return $this->existencias > 0;
    }

    // Accesor para verificar si está bajo stock (menos de 5 unidades)
    public function getBajoStockAttribute()
    {
        return $this->existencias <= 5;
    }

    // Accesor para el estado del stock
    public function getEstadoStockAttribute()
    {
        if ($this->existencias == 0) {
            return 'Agotado';
        } elseif ($this->existencias <= 5) {
            return 'Bajo Stock';
        } else {
            return 'Disponible';
        }
    }

    // Scope para productos con existencias
    public function scopeConExistencias($query)
    {
        return $query->where('existencias', '>', 0);
    }

    // Scope para productos agotados
    public function scopeAgotados($query)
    {
        return $query->where('existencias', '<=', 0);
    }

    // Scope para productos bajo stock
    public function scopeBajoStock($query, $minimo = 5)
    {
        return $query->where('existencias', '<=', $minimo);
    }

    // Scope para búsqueda por nombre
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    // Scope para productos de un departamento
    public function scopePorDepartamento($query, $departamentoId)
    {
        return $query->where('departamento_id', $departamentoId);
    }

    // Scope para productos con ganancia
    public function scopeConGanancia($query)
    {
        return $query->whereRaw('precio_venta > precio_compra');
    }

    // Método para actualizar existencias
    public function actualizarExistencias($cantidad)
    {
        $this->existencias += $cantidad;
        return $this->save();
    }

    // Método para verificar si se puede vender cierta cantidad
    public function puedeVender($cantidad)
    {
        return $this->existencias >= $cantidad;
    }

    // Método para obtener el total de ventas del producto
    public function getTotalVendidoAttribute()
    {
        return $this->ventas()->sum('cantidad');
    }

    // Método para obtener el valor total en inventario
    public function getValorInventarioAttribute()
    {
        return $this->existencias * $this->precio_compra;
    }

    // Método para obtener el valor total en inventario formateado
    public function getValorInventarioFormateadoAttribute()
    {
        return '$' . number_format($this->valor_inventario, 2);
    }

}
