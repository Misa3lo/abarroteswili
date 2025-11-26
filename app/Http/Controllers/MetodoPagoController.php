<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MetodoPago extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'metodo_pago';
    protected $primaryKey = 'id';

    protected $fillable = [
        'descripcion'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'metodo_pago_id');
    }

    // Accesor para verificar si es efectivo
    public function getEsEfectivoAttribute()
    {
        return $this->id == 1; // ID 1 = Efectivo en tu BD
    }

    // Accesor para verificar si es crédito
    public function getEsCreditoAttribute()
    {
        return $this->id == 2; // ID 2 = Crédito en tu BD
    }

    // Accesor para la descripción en mayúsculas
    public function getDescripcionMayusculaAttribute()
    {
        return strtoupper($this->descripcion);
    }

    // Scope para método activos
    public function scopeActivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    // Scope para búsqueda por descripción
    public function scopePorDescripcion($query, $descripcion)
    {
        return $query->where('descripcion', 'like', "%{$descripcion}%");
    }

    // Método para contar tickets por este método de pago
    public function getTotalTicketsAttribute()
    {
        return $this->tickets()->count();
    }

    // Método para calcular el monto total por este método de pago
    public function getMontoTotalAttribute()
    {
        return $this->tickets()->sum('total');
    }

    // Método para obtener estadísticas de uso
    public function getEstadisticasUsoAttribute()
    {
        $totalTicketsGlobal = Ticket::count();
        $totalTicketsMetodo = $this->total_tickets;

        if ($totalTicketsGlobal > 0) {
            $porcentaje = ($totalTicketsMetodo / $totalTicketsGlobal) * 100;
        } else {
            $porcentaje = 0;
        }

        return [
            'total_tickets' => $totalTicketsMetodo,
            'monto_total' => $this->monto_total,
            'porcentaje_uso' => round($porcentaje, 2)
        ];
    }

    // Método estático para obtener método de pago por defecto (Efectivo)
    public static function obtenerEfectivo()
    {
        return self::find(1);
    }

    // Método estático para obtener método de pago por crédito
    public static function obtenerCredito()
    {
        return self::find(2);
    }

    // Método para obtener tickets recientes de este método
    public function ticketsRecientes($limite = 10)
    {
        return $this->tickets()
            ->with(['cliente.persona', 'usuario.persona'])
            ->orderBy('fecha_hora', 'desc')
            ->limit($limite)
            ->get();
    }
}
