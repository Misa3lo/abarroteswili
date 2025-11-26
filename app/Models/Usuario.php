<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'persona_id',
        'usuario',
        'password',
        'rol'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Persona
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    // Relación con Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'usuario_id');
    }

    // Accesor para el nombre completo (a través de persona)
    public function getNombreCompletoAttribute()
    {
        return $this->persona ? $this->persona->nombre_completo : 'Usuario sin persona';
    }

    // Accesor para el email (si lo tuvieras)
    public function getEmailAttribute()
    {
        return $this->persona ? $this->persona->email : null;
    }

    // Accesor para verificar si es administrador
    public function getEsAdministradorAttribute()
    {
        return $this->rol === 'administrador';
    }

    // Accesor para verificar si es empleado
    public function getEsEmpleadoAttribute()
    {
        return $this->rol === 'empleado';
    }

    // Scope para usuarios activos
    public function scopeActivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope para administradores
    public function scopeAdministradores($query)
    {
        return $query->where('rol', 'administrador');
    }

    // Scope para empleados
    public function scopeEmpleados($query)
    {
        return $query->where('rol', 'empleado');
    }

    // Scope para búsqueda por nombre de usuario
    public function scopePorUsuario($query, $usuario)
    {
        return $query->where('usuario', 'like', "%{$usuario}%");
    }

    // Scope para búsqueda por nombre de persona
    public function scopePorNombre($query, $nombre)
    {
        return $query->whereHas('persona', function($q) use ($nombre) {
            $q->where('nombre', 'like', "%{$nombre}%")
                ->orWhere('apaterno', 'like', "%{$nombre}%")
                ->orWhere('amaterno', 'like', "%{$nombre}%");
        });
    }

    // Método para contar tickets del usuario
    public function getTotalTicketsAttribute()
    {
        return $this->tickets()->count();
    }

    // Método para obtener ventas totales del usuario
    public function getVentasTotalesAttribute()
    {
        return $this->tickets()->sum('total');
    }

    // Método para obtener estadísticas de ventas del mes
    public function ventasEsteMes()
    {
        return $this->tickets()
            ->whereYear('fecha_hora', now()->year)
            ->whereMonth('fecha_hora', now()->month)
            ->sum('total');
    }

    // Método para verificar permisos (simple para proyecto escolar)
    public function puede($accion)
    {
        if ($this->es_administrador) {
            return true;
        }

        // Permisos para empleados
        $permisosEmpleado = [
            'ver_ventas',
            'crear_ventas',
            'ver_clientes',
            'ver_productos'
        ];

        return in_array($accion, $permisosEmpleado);
    }
}
