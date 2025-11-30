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
            'monto_abono' => 'required|numeric|min:0.01',
        ]);

        $montoAbono = (float) $request->monto_abono;
        $saldoPendiente = (float) $credito->adeudo;

        if ($montoAbono > $saldoPendiente) {
            return back()->with('error', 'El monto del abono ($' . number_format($montoAbono, 2) . ') no puede ser mayor al saldo pendiente de $' . number_format($saldoPendiente, 2));
        }

        try {
            DB::beginTransaction();

            // En la tabla 'abonos' SÍ existe la columna 'fecha_hora', por eso esto es correcto.
            Abono::create([
                'credito_id' => $credito->id,
                'abono' => $montoAbono,
                'fecha_hora' => now(),
            ]);

            $credito->decrement('adeudo', $montoAbono);

            DB::commit();

            $credito->refresh();

            return redirect()->route('creditos.show', $credito->id)
                ->with('success', 'Abono de $' . number_format($montoAbono, 2) . ' registrado con éxito. Nuevo saldo pendiente: $' . number_format($credito->adeudo, 2));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al procesar el abono: ' . $e->getMessage());
        }
    }
}
