<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'departamentos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'departamento_id');
    }

    // Accesor para contar productos activos
    public function getTotalProductosAttribute()
    {
        return $this->productos()->count();
    }

    // Accesor para contar productos con existencias
    public function getProductosConExistenciasAttribute()
    {
        return $this->productos()->where('existencias', '>', 0)->count();
    }

    // Scope para búsqueda por nombre
    public function scopePorNombre($query, $nombre)
    {
        return $query->where('nombre', 'like', "%{$nombre}%");
    }

    // Scope para búsqueda por descripción
    public function scopePorDescripcion($query, $descripcion)
    {
        return $query->where('descripcion', 'like', "%{$descripcion}%");
    }

    // Método para verificar si tiene productos
    public function getTieneProductosAttribute()
    {
        return $this->productos()->exists();
    }

    // Método para obtener productos con bajo stock (si definimos un mínimo)
    public function productosBajoStock($minimo = 5)
    {
        return $this->productos()->where('existencias', '<=', $minimo)->get();
    }
}
