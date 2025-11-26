<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Credito extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'creditos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'cliente_id',
        'adeudo',
        'descripcion'
    ];

    protected $dates = ['deleted_at'];

    // Relación con Cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relación con Abonos
    public function abonos()
    {
        return $this->hasMany(Abono::class, 'credito_id');
    }

    // Accesor para el adeudo formateado
    public function getAdeudoFormateadoAttribute()
    {
        return '$' . number_format($this->adeudo, 2);
    }

    // Método para calcular el total abonado
    public function getTotalAbonadoAttribute()
    {
        return $this->abonos()->sum('abono');
    }

    // Método para calcular el saldo pendiente
    public function getSaldoPendienteAttribute()
    {
        return $this->adeudo - $this->total_abonado;
    }

    // Método para verificar si está pagado
    public function getEstaPagadoAttribute()
    {
        return $this->saldo_pendiente <= 0;
    }

    // Método para verificar si está vencido (si tuvieras fecha_vencimiento)
    public function getEstaVencidoAttribute()
    {
        // Si agregas fecha_vencimiento a tu tabla:
        // return $this->fecha_vencimiento && $this->fecha_vencimiento < now();
        return false;
    }

    // Scope para créditos activos (con adeudo > 0)
    public function scopeActivos($query)
    {
        return $query->where('adeudo', '>', 0);
    }

    // Scope para créditos pagados
    public function scopePagados($query)
    {
        return $query->where('adeudo', '<=', 0);
    }

    // Scope para créditos de un cliente
    public function scopePorCliente($query, $clienteId)
    {
        return $query->where('cliente_id', $clienteId);
    }

    // Scope para búsqueda por nombre de cliente
    public function scopePorNombreCliente($query, $nombre)
    {
        return $query->whereHas('cliente.persona', function($q) use ($nombre) {
            $q->where('nombre', 'like', "%{$nombre}%")
                ->orWhere('apaterno', 'like', "%{$nombre}%");
        });
    }

    // Método para registrar un abono
    public function registrarAbono($monto, $fechaHora = null)
    {
        if ($monto > $this->adeudo) {
            throw new \Exception('El abono no puede ser mayor al adeudo actual');
        }

        $abono = Abono::create([
            'credito_id' => $this->id,
            'abono' => $monto,
            'fecha_hora' => $fechaHora ?? now()
        ]);

        $this->decrement('adeudo', $monto);

        return $abono;
    }
}
