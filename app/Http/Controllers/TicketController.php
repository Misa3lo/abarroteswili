<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\MetodoPago;
use App\Models\Ticket;
use App\Models\Venta;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Muestra la interfaz del Punto de Venta (PDV). (CREATE)
     */
    public function create()
    {
        // 1. Obtener datos para la vista
        // CORRECCIÓN 1: Asegurar que se seleccionan todas las columnas que el JS necesita.
        $productos = Producto::select('id', 'codigo_barras', 'descripcion', 'precio_venta', 'existencias')->orderBy('codigo_barras')->get();

        // Cargar clientes con datos personales
        $clientes = Cliente::with('persona')->get();
        $metodosPago = MetodoPago::all();

        // Preparar la lista de productos en formato JSON para JavaScript
        $productosJson = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'codigo_barras' => $producto->codigo_barras,

                // CORRECCIÓN 2: Mapear exactamente a las claves que el JS utiliza.
                'descripcion' => $producto->descripcion,
                'precio_venta' => $producto->precio_venta,
                'existencias' => $producto->existencias,
            ];
        });

        $productosJson = json_encode($productosJson);

        // NOTA: Eliminamos 'productos' del compact para no enviar datos duplicados
        return view('puntoDeVenta', compact('clientes', 'metodosPago', 'productosJson'));
    }

    /**
     * Procesa la venta, registra el ticket, las ventas y actualiza existencias/créditos. (STORE)
     */
    // app/Http/Controllers/TicketController.php

    public function store(Request $request)
    {
        // ACTUALIZADO: ID del cliente Público General existente
        $ID_CLIENTE_PUBLICO = 13;

        // ... (Validación) ...

        $metodoPago = MetodoPago::find($request->metodo_pago_id);

        // Validación de seguridad backend
        if (($request->cliente_id == $ID_CLIENTE_PUBLICO) && ($metodoPago->descripcion !== 'Efectivo')) {
            return redirect()->route('puntoDeVenta')->withInput()->with('error', 'Error de Seguridad: La venta al Público General debe ser en Efectivo.');
        }

        // ... (Resto del código igual que antes) ...

        try {
            DB::beginTransaction();

            $ticket = Ticket::create([
                'folio' => uniqid('T'),
                'usuario_id' => Auth::user()->id,
                // Si viene vacío o nulo, usa el 13
                'cliente_id' => $request->cliente_id ?: $ID_CLIENTE_PUBLICO,
                'metodo_pago_id' => $request->metodo_pago_id,
                'total' => $request->total,
            ]);

            // ... (El resto de la lógica de Crédito y Ventas es correcta) ...

            DB::commit();
            return redirect()->route('tickets.show', $ticket->id)->with('success', 'Venta (Ticket #' . $ticket->id . ') registrada y stock actualizado. 🎉');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('puntoDeVenta')->withInput()->with('error', 'Error al procesar la venta: ' . $e->getMessage());
        }
    }

    // Método para mostrar el ticket después de la venta
    public function show(Ticket $ticket)
    {
        // Cargamos las relaciones necesarias
        $ticket->load('ventas.producto', 'metodoPago', 'cliente.persona');
        return view('tickets.show', compact('ticket'));
    }

    // Los métodos index y destroy puedes implementarlos después
// ✅ CORRECCIÓN: Usamos la columna real 'fecha_hora' para ordenar
    public function index()
    {
        // ✅ CORRECCIÓN: Ordenar por 'fecha_hora' y cargar las relaciones necesarias (eager load)
        $tickets = Ticket::with(['cliente.persona', 'usuario', 'metodoPago'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return view('tickets.index', compact('tickets'));
    }
    public function destroy(Ticket $ticket) { return abort(404); }
}
