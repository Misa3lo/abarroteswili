<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Abono;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditoController extends Controller
{
    /**
     * Muestra todos los créditos con saldo pendiente, agrupados por cliente. (INDEX)
     */
    public function index()
    {
        // CORRECCIÓN CRÍTICA: Usar 'created_at' en lugar de 'fecha_hora' para ordenar.
        $creditos = Credito::where('adeudo', '>', 0)
            ->with('cliente.persona', 'ticket')
            ->orderBy('created_at', 'asc')
            ->get();

        // 2. Agruparlos por cliente para mostrar un resumen en la vista
        $clientesConDeuda = $creditos->groupBy('cliente_id')->map(function ($items, $clientId) {
            return [
                'cliente' => $items->first()->cliente,
                'saldo_total' => $items->sum('adeudo'),
                'creditos_pendientes' => $items
            ];
        })->sortByDesc('saldo_total');

        return view('creditos.index', compact('clientesConDeuda'));
    }

    /**
     * Muestra el detalle de un crédito específico, su historial de abonos y el formulario de pago. (SHOW)
     */
    public function show(Credito $credito)
    {
        $credito->load('cliente.persona', 'ticket.ventas.producto', 'abonos');

        return view('creditos.show', compact('credito'));
    }

    /**
     * Procesa un abono (pago) a un crédito específico, actualizando el saldo. (STORE ABONO)
     */
    public function storeAbono(Request $request, Credito $credito)
    {
        $request->validate([
            'abono' => 'required|numeric|min:0.01',
        ]);

        $montoAbono = (float)$request->abono;

        // 1. Validar que el crédito esté pendiente
        if ($credito->adeudo <= 0) { // <--- USAR 'adeudo'
            return back()->with('error', 'El crédito ya se encuentra liquidado. No se puede registrar un abono.');
        }

        // Validación de seguridad: El abono no puede ser mayor que el saldo pendiente
        // USAR 'adeudo'
        if ($montoAbono > $credito->adeudo) {
            return back()->with('error', 'Error: El monto del abono ($' . number_format($montoAbono, 2) . ') es mayor que el saldo pendiente ($' . number_format($credito->adeudo, 2) . ').');
        }

        try {
            DB::beginTransaction();

            // 2. CREACIÓN DEL ABONO
            Abono::create([
                'credito_id' => $credito->id,
                'abono' => $montoAbono,
                'fecha_hora' => now(), // Correcto, usa la hora actual
            ]);

            // 3. ACTUALIZACIÓN DEL SALDO DEL CRÉDITO
            $nuevoSaldo = $credito->adeudo - $montoAbono;

            // Actualizar el saldo (Credito.php necesita 'estado' en $fillable)
            $credito->update([
                'adeudo' => $nuevoSaldo,
                'estado' => ($nuevoSaldo <= 0.01) ? 'Pagado' : 'Pendiente', // Correcto
            ]);

            DB::commit();

            return back()->with('success', 'Abono de $' . number_format($montoAbono, 2) . ' registrado exitosamente. Saldo pendiente actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();

            // 🚨 CAMBIO DE DIAGNÓSTICO: Detener el script y mostrar el error real de la DB
            // Esto revelará si es un problema de Foreign Key, columna NULL, etc.
            dd("Fallo de Transacción: " . $e->getMessage());
        }
    }

}
