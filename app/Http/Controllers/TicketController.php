<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\MetodoPago;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        // Mostrar tickets con información relacionada
        $tickets = Ticket::with(['cliente.persona', 'usuario.persona', 'metodoPago', 'ventas'])
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        // Obtener datos para el formulario
        $clientes = Cliente::with('persona')->get();
        $usuarios = Usuario::with('persona')->get();
        $metodosPago = MetodoPago::all();
        $productos = Producto::conExistencias()->orderBy('nombre')->get();

        $folio = Ticket::generarFolio();

        return view('tickets.create', compact('clientes', 'usuarios', 'metodosPago', 'productos', 'folio'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            'ventas' => 'required|array|min:1',
            'ventas.*.producto_id' => 'required|exists:productos,id',
            'ventas.*.cantidad' => 'required|numeric|min:0.01',
            'ventas.*.precio' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            // Crear el ticket
            $ticket = Ticket::create([
                'folio' => Ticket::generarFolio(),
                'usuario_id' => $request->usuario_id,
                'cliente_id' => $request->cliente_id,
                'metodo_pago_id' => $request->metodo_pago_id,
                'total' => 0, // Se calculará después
                'fecha_hora' => now()
            ]);

            $totalTicket = 0;

            // Procesar cada venta
            foreach ($request->ventas as $ventaData) {
                $producto = Producto::find($ventaData['producto_id']);

                // Verificar stock
                if (!$producto->puedeVender($ventaData['cantidad'])) {
                    throw new \Exception("Stock insuficiente para: {$producto->nombre}. Disponible: {$producto->existencias}");
                }

                // Crear la venta
                $venta = Venta::create([
                    'ticket_id' => $ticket->id,
                    'producto_id' => $ventaData['producto_id'],
                    'cantidad' => $ventaData['cantidad'],
                    'precio' => $ventaData['precio']
                ]);

                // Actualizar existencias
                $producto->actualizarExistencias(-$ventaData['cantidad']);

                // Sumar al total
                $totalTicket += $venta->subtotal;
            }

            // Actualizar el total del ticket
            $ticket->update(['total' => $totalTicket]);

            // Si es crédito, crear registro de crédito
            if ($ticket->es_credito) {
                $cliente = $ticket->cliente;

                // Verificar que no exceda el límite de crédito
                $totalAdeudado = $cliente->creditos()->sum('adeudo');
                if (($totalAdeudado + $totalTicket) > $cliente->limite_credito) {
                    throw new \Exception("El cliente excede su límite de crédito. Límite: {$cliente->limite_credito}, Actual: {$totalAdeudado}");
                }

                // Crear crédito
                $cliente->creditos()->create([
                    'adeudo' => $totalTicket
                ]);
            }

            DB::commit();

            return redirect()->route('tickets.show', $ticket)
                ->with('success', 'Ticket creado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al crear el ticket: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Ticket $ticket)
    {
        $ticket->load([
            'cliente.persona',
            'usuario.persona',
            'metodoPago',
            'ventas.producto.departamento'
        ]);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $ticket->load(['ventas.producto']);

        $clientes = Cliente::with('persona')->get();
        $usuarios = Usuario::with('persona')->get();
        $metodosPago = MetodoPago::all();
        $productos = Producto::orderBy('nombre')->get();

        return view('tickets.edit', compact('ticket', 'clientes', 'usuarios', 'metodosPago', 'productos'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            'fecha_hora' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            // Actualizar el ticket
            $ticket->update([
                'usuario_id' => $request->usuario_id,
                'cliente_id' => $request->cliente_id,
                'metodo_pago_id' => $request->metodo_pago_id,
                'fecha_hora' => $request->fecha_hora
            ]);

            DB::commit();

            return redirect()->route('tickets.show', $ticket)
                ->with('success', 'Ticket actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el ticket: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Ticket $ticket)
    {
        try {
            DB::beginTransaction();

            // Restaurar existencias de productos
            foreach ($ticket->ventas as $venta) {
                $venta->producto->actualizarExistencias($venta->cantidad);
            }

            // Si era crédito, eliminar el crédito asociado
            if ($ticket->es_credito) {
                $credito = $ticket->cliente->creditos()
                    ->where('adeudo', $ticket->total)
                    ->first();

                if ($credito) {
                    $credito->delete();
                }
            }

            // Eliminar el ticket (las ventas se eliminarán en cascada por la FK)
            $ticket->delete();

            DB::commit();

            return redirect()->route('tickets.index')
                ->with('success', 'Ticket eliminado correctamente. Stock restaurado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tickets.index')
                ->with('error', 'Error al eliminar el ticket: ' . $e->getMessage());
        }
    }

    // Método para buscar tickets
    public function search(Request $request)
    {
        $search = $request->get('search');

        $tickets = Ticket::with(['cliente.persona', 'usuario.persona', 'metodoPago', 'ventas'])
            ->porFolio($search)
            ->orWhereHas('cliente.persona', function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apaterno', 'like', "%{$search}%");
            })
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('tickets.index', compact('tickets', 'search'));
    }

    // Método para tickets por cliente
    public function porCliente($clienteId)
    {
        $cliente = Cliente::with('persona')->findOrFail($clienteId);
        $tickets = Ticket::with(['usuario.persona', 'metodoPago', 'ventas'])
            ->porCliente($clienteId)
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('tickets.por-cliente', compact('tickets', 'cliente'));
    }

    // Método para tickets por fecha
    public function porFechas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(7)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $tickets = Ticket::with(['cliente.persona', 'usuario.persona', 'metodoPago'])
            ->entreFechas($fechaInicio, $fechaFin)
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        $totalVentas = $tickets->sum('total');
        $totalTickets = $tickets->count();

        return view('tickets.por-fechas', compact(
            'tickets',
            'totalVentas',
            'totalTickets',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // Método para imprimir ticket
    public function imprimir(Ticket $ticket)
    {
        $ticket->load([
            'cliente.persona',
            'usuario.persona',
            'metodoPago',
            'ventas.producto'
        ]);

        return view('tickets.imprimir', compact('ticket'));
    }

    // Método para estadísticas de tickets
    public function estadisticas()
    {
        $totalTickets = Ticket::count();
        $totalVendido = Ticket::sum('total');
        $ticketsHoy = Ticket::whereDate('fecha_hora', today())->count();
        $ventasHoy = Ticket::whereDate('fecha_hora', today())->sum('total');

        // Métodos de pago más usados
        $metodosPagoStats = Ticket::select('metodo_pago_id', DB::raw('COUNT(*) as total_tickets, SUM(total) as total_ventas'))
            ->groupBy('metodo_pago_id')
            ->with('metodoPago')
            ->get();

        // Tickets por día (últimos 7 días)
        $ticketsPorDia = Ticket::select(DB::raw('DATE(fecha_hora) as fecha, COUNT(*) as total_tickets, SUM(total) as total_ventas'))
            ->where('fecha_hora', '>=', now()->subDays(7))
            ->groupBy(DB::raw('DATE(fecha_hora)'))
            ->orderBy('fecha')
            ->get();

        return view('tickets.estadisticas', compact(
            'totalTickets',
            'totalVendido',
            'ticketsHoy',
            'ventasHoy',
            'metodosPagoStats',
            'ticketsPorDia'
        ));
    }
}
