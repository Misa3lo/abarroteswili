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
        // AJUSTE CRÍTICO: Usar 'codigo_barras' en la consulta SQL
        $productos = Producto::select('id', 'codigo_barras', 'precio_venta', 'existencias')->orderBy('codigo_barras')->get();

        // Cargar clientes con datos personales
        $clientes = Cliente::with('persona')->get();
        $metodosPago = MetodoPago::all();

        // Preparar la lista de productos en formato JSON para JavaScript
        $productosJson = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                // AJUSTE CRÍTICO: Usar la clave 'codigo_barras' en el JSON para el JS
                'codigo_barras' => $producto->codigo_barras,
                'precio' => $producto->precio_venta,
                'stock' => $producto->existencias,
            ];
        });

        return view('puntoDeVenta', compact('productos', 'clientes', 'metodosPago', 'productosJson'));
    }

    /**
     * Procesa la venta, registra el ticket, las ventas y actualiza existencias/créditos. (STORE)
     */
    public function store(Request $request)
    {
        // ... (Validación sin cambios)
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            'total' => 'required|numeric|min:0.01',
            'cart_items' => 'required|array|min:1',
            'cart_items.*.producto_id' => 'required|exists:productos,id',
            'cart_items.*.cantidad' => 'required|integer|min:1',
            'cart_items.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $metodoPago = MetodoPago::find($request->metodo_pago_id);
        $esCredito = ($metodoPago->descripcion === 'Crédito');

        try {
            DB::beginTransaction();

            // ... (Creación de Ticket y Crédito)

            // --- 2.3 Procesar Líneas de Venta y Stock ---
            foreach ($request->cart_items as $item) {
                $producto = Producto::lockForUpdate()->find($item['producto_id']);

                // Verificación final de Stock
                if ($producto->existencias < $item['cantidad']) {
                    DB::rollBack();
                    // AJUSTE: Usar 'codigo_barras' en el mensaje de error
                    return redirect()->route('puntoDeVenta')->with('error', 'Error: Stock insuficiente para el producto ' . $producto->codigo_barras . '. Stock actual: ' . $producto->existencias);
                }

                // ... (Registro de Venta y decremento de stock)
                Venta::create([
                    'ticket_id' => $ticket->id,
                    'producto_id' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                ]);

                $producto->decrement('existencias', $item['cantidad']);
            }

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
    public function index() { return view('tickets.index', ['tickets' => Ticket::latest()->get()]); }
    public function destroy(Ticket $ticket) { return abort(404); }
}
