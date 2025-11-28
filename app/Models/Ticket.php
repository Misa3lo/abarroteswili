<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tickets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'folio',
        'usuario_id',
        'cliente_id',
        'metodo_pago_id',
        'total',
        'fecha_hora'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con Método de Pago
    // En el modelo Ticket, agregar esta relación si no existe:
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

    // Relación con Ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'ticket_id');
    }

    // Accesor para el total formateado
    public function getTotalFormateadoAttribute()
    {
        return '$' . number_format($this->total, 2);
    }

    // Accesor para la fecha formateada
    public function getFechaLegibleAttribute()
    {
        return $this->fecha_hora->format('d/m/Y H:i');
    }

    // Accesor para el nombre del cliente
    public function getNombreClienteAttribute()
    {
        return $this->cliente ? $this->cliente->nombre_completo : 'Cliente no encontrado';
    }

    // Accesor para el nombre del usuario (cajero)
    public function getNombreUsuarioAttribute()
    {
        return $this->usuario ? $this->usuario->persona->nombre_completo : 'Usuario no encontrado';
    }

    // Accesor para el método de pago
    public function getMetodoPagoNombreAttribute()
    {
        return $this->metodoPago ? $this->metodoPago->descripcion : 'Método no encontrado';
    }

    // Accesor para verificar si es pago con crédito
    public function getEsCreditoAttribute()
    {
        return $this->metodo_pago_id == 2; // ID 2 = Crédito en tu BD
    }

    // Accesor para contar productos vendidos en el ticket
    public function getTotalProductosAttribute()
    {
        return $this->ventas()->sum('cantidad');
    }

    // Scope para tickets de un cliente específico
    public function scopePorCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    // Scope para tickets de un usuario específico
    public function scopePorUsuario($query, $usuarioId)
    {
        return $query->where('usuario_id', $usuarioId);
    }

    // Scope para tickets por método de pago
    public function scopePorMetodoPago($query, $metodoPagoId)
    {
        return $query->where('metodo_pago_id', $metodoPagoId);
    }

    // Scope para tickets en un rango de fechas
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
    }

    // Scope para tickets con crédito
    public function scopeConCredito($query)
    {
        return $query->where('metodo_pago_id', 2);
    }

    // Scope para tickets con efectivo
    public function scopeConEfectivo($query)
    {
        return $query->where('metodo_pago_id', 1);
    }

    // Scope para búsqueda por folio
    public function scopePorFolio($query, $folio)
    {
        return $query->where('folio', 'like', "%{$folio}%");
    }

    // Método para generar folio automático
    public static function generarFolio()
    {
        $ultimoTicket = self::orderBy('id', 'desc')->first();
        $numero = $ultimoTicket ? intval(substr($ultimoTicket->folio, 5)) + 1 : 1;
        return 'TICK-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Método para calcular la ganancia total del ticket
    public function getGananciaTotalAttribute()
    {
        return $this->ventas->sum('ganancia');
    }

    // Método para obtener los productos del ticket
    public function getProductosAttribute()
    {
        return $this->ventas->map(function($venta) {
            return [
                'producto' => $venta->producto,
                'cantidad' => $venta->cantidad,
                'precio' => $venta->precio,
                'subtotal' => $venta->subtotal
            ];
        });
    }
}
