<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Cliente;
use App\Models\MetodoPago;
use App\Models\Ticket;
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

        // 🚨 CAMBIO CRÍTICO: Obtener clientes con el saldo total pendiente
        // 1. Cargamos la relación 'persona'.
        // 2. Usamos withSum para calcular la suma de 'adeudo' de los créditos pendientes.
        $clientes = Cliente::with('persona')
            ->withSum([
                'creditos' => function ($query) {
                    $query->where('adeudo', '>', 0); // Solo créditos con saldo pendiente
                }
            ], 'adeudo') // Suma la columna 'adeudo'
            ->get();

        // El resultado de withSum se guarda en una columna llamada 'creditos_sum_adeudo'

        $productos = Producto::select('id', 'codigo_barras', 'descripcion', 'precio_venta', 'existencias')->orderBy('codigo_barras')->get();
        $metodosPago = MetodoPago::all();

// Mapeo de la colección para JavaScript (¡Asegúrate de que el mapping exista!)
        $productosJson = $productos->map(function ($producto) {
            return [
                'id' => $producto->id,
                'codigo_barras' => $producto->codigo_barras,
                'descripcion' => $producto->descripcion, // ¡CLAVE NECESARIA!
                'precio' => $producto->precio_venta,      // Usamos 'precio'
                'stock' => $producto->existencias,        // Usamos 'stock'
            ];
        });

        return view('puntoDeVenta', compact('productos', 'clientes', 'metodosPago', 'productosJson'));
    }

    /**
     * Procesa la venta, registra el ticket, las ventas y actualiza existencias/créditos. (STORE)
     */
    // app/Http/Controllers/TicketController.php

    public function store(Request $request)
    {
        // 1. VALIDACIÓN
        $request->validate([
            'total' => 'required|numeric',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            // Validamos que llegue el array de items del carrito
            'cart_items' => 'required|array|min:1',
        ]);

        // AJUSTE CRÍTICO: Definir los IDs importantes para la lógica de negocio.
        $ID_METODO_CREDITO = 2;
        $ID_CLIENTE_PUBLICO = 13; // Usamos 13 que es tu ID real de público general

        DB::beginTransaction();

        try {
            // CORRECCIÓN USUARIO: Usamos Auth::user()->id para obtener el número, no el nombre
            $usuarioId = Auth::user()->id;

            // 1. CREACIÓN DEL TICKET
            $ticket = Ticket::create([
                'folio' => uniqid('T'),
                'usuario_id' => $usuarioId, // ✅ Corregido: ID numérico
                'cliente_id' => $request->cliente_id ?? $ID_CLIENTE_PUBLICO,
                'metodo_pago_id' => $request->metodo_pago_id,
                'total' => $request->total, // Usamos 'total' que viene del input hidden 'input_total'
            ]);

            // 2. REGISTRO DE VENTA Y DECREMENTO DE STOCK
            // CORRECCIÓN ARRAY: Usamos 'cart_items' que es como se llama en el HTML/JS
            foreach ($request->cart_items as $item) {
                // Verificar que el producto exista antes de usarlo
                $producto = Producto::find($item['producto_id']);

                if ($producto) {
                    \App\Models\Venta::create([
                        'ticket_id' => $ticket->id,
                        'producto_id' => $item['producto_id'],
                        'cantidad' => $item['cantidad'],
                        'precio' => $item['precio_unitario'], // En tu DB la columna es 'precio', no 'precio_unitario'
                    ]);

                    $producto->decrement('existencias', $item['cantidad']);
                }
            }

            // 3. REGISTRO DE CRÉDITO (LÓGICA NUEVA)
            if ((int)$request->metodo_pago_id === $ID_METODO_CREDITO && (int)$ticket->cliente_id !== $ID_CLIENTE_PUBLICO) {
                if ($request->total > 0) {
                    Credito::create([
                        'cliente_id' => $ticket->cliente_id,
                        'ticket_id' => $ticket->id,
                        'monto_original' => $ticket->total,
                        'adeudo' => $ticket->total,
                    ]);
                }
            }

            DB::commit();

            // 🚨 REDIRECCIÓN AL TICKET RECIÉN CREADO
            return redirect()->route('tickets.show', $ticket->id)
                ->with('success', 'Venta procesada con éxito. Ticket #' . $ticket->id);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error("Error al procesar la venta: " . $e->getMessage());

            return redirect()->route('puntoDeVenta')
                ->with('error', 'Error al finalizar la venta: ' . $e->getMessage());
        }
    }

    // Método para mostrar el ticket después de la venta
    public function show(Ticket $ticket)
    {
        // Cargamos las relaciones necesarias
        $ticket->load('ventas.producto', 'metodoPago', 'cliente.persona');
        return view('tickets.show', compact('ticket')); // <-- ¡Esta es la vista a revisar!
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
