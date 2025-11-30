<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc

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
<<<<<<< HEAD
        $metodosPago = DB::table('metodo_pago')->get();
        return view('metodo_pago.index', compact('metodosPago'));
=======
        return $this->hasMany(Ticket::class, 'metodo_pago_id');
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
    }

    // Accesor para verificar si es efectivo
    public function getEsEfectivoAttribute()
    {
<<<<<<< HEAD
        return view('metodo_pago.create');
=======
        return $this->id == 1; // ID 1 = Efectivo en tu BD
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
    }

    // Accesor para verificar si es crédito
    public function getEsCreditoAttribute()
    {
<<<<<<< HEAD
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago'
        ]);

        DB::table('metodo_pago')->insert([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago creado correctamente');
    }

    public function show($id)
    {
        $metodoPago = DB::table('metodo_pago')->where('id', $id)->first();
        return view('metodo_pago.show', compact('metodoPago'));
    }

    public function edit($id)
    {
        $metodoPago = DB::table('metodo_pago')->where('id', $id)->first();
        return view('metodo_pago.edit', compact('metodoPago'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion,' . $id
        ]);

        DB::table('metodo_pago')
            ->where('id', $id)
            ->update(['descripcion' => $request->descripcion]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago actualizado correctamente');
    }

    public function destroy($id)
    {
        DB::table('metodo_pago')->where('id', $id)->delete();
        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago eliminado correctamente');
=======
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
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
    }
}
