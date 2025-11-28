<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Ticket;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        // Mostrar ventas con información del ticket y producto
        $ventas = Venta::with(['ticket.cliente.persona', 'ticket.usuario.persona', 'producto.departamento'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        // Obtener tickets y productos para selects
        $tickets = Ticket::with(['cliente.persona', 'usuario.persona'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        $productos = Producto::conExistencias()
            ->orderBy('nombre')
            ->get();

        return view('ventas.create', compact('tickets', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            // Obtener el producto
            $producto = Producto::findOrFail($request->producto_id);

            // Verificar que haya suficiente stock
            if (!$producto->puedeVender($request->cantidad)) {
                return back()->withErrors([
                    'cantidad' => 'Stock insuficiente. Existencias disponibles: ' . $producto->existencias
                ])->withInput();
            }

            // Crear la venta
            $venta = Venta::create([
                'ticket_id' => $request->ticket_id,
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'precio' => $request->precio
            ]);

            // Actualizar existencias del producto
            $producto->actualizarExistencias(-$request->cantidad);

            // Recalcular el total del ticket
            $ticket = Ticket::find($request->ticket_id);
            $nuevoTotal = $ticket->ventas()->sum(DB::raw('cantidad * precio'));
            $ticket->update(['total' => $nuevoTotal]);

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar la venta: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Venta $venta)
    {
        $venta->load(['ticket.cliente.persona', 'ticket.usuario.persona', 'producto.departamento']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $venta->load(['ticket', 'producto']);

        $tickets = Ticket::with(['cliente.persona', 'usuario.persona'])
            ->orderBy('fecha_hora', 'desc')
            ->get();

        $productos = Producto::orderBy('nombre')->get();

        return view('ventas.edit', compact('venta', 'tickets', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:0.01',
            'precio' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            // Guardar valores antiguos para ajustes
            $cantidadAnterior = $venta->cantidad;
            $nuevaCantidad = $request->cantidad;
            $diferenciaCantidad = $nuevaCantidad - $cantidadAnterior;

            // Obtener el producto
            $producto = $venta->producto;

            // Si cambió la cantidad, verificar stock
            if ($diferenciaCantidad > 0 && !$producto->puedeVender($diferenciaCantidad)) {
                return back()->withErrors([
                    'cantidad' => 'Stock insuficiente para aumentar la cantidad. Existencias disponibles: ' . $producto->existencias
                ])->withInput();
            }

            // Actualizar la venta
            $venta->update([
                'cantidad' => $nuevaCantidad,
                'precio' => $request->precio
            ]);

            // Ajustar existencias del producto
            if ($diferenciaCantidad != 0) {
                $producto->actualizarExistencias(-$diferenciaCantidad);
            }

            // Recalcular el total del ticket
            $ticket = $venta->ticket;
            $nuevoTotal = $ticket->ventas()->sum(DB::raw('cantidad * precio'));
            $ticket->update(['total' => $nuevoTotal]);

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta actualizada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar la venta: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Venta $venta)
    {
        try {
            DB::beginTransaction();

            $ticket = $venta->ticket;
            $producto = $venta->producto;

            // Restaurar existencias del producto
            $producto->actualizarExistencias($venta->cantidad);

            // Eliminar la venta
            $venta->delete();

            // Recalcular el total del ticket
            $nuevoTotal = $ticket->ventas()->sum(DB::raw('cantidad * precio'));
            $ticket->update(['total' => $nuevoTotal]);

            DB::commit();

            return redirect()->route('ventas.index')
                ->with('success', 'Venta eliminada correctamente. Stock restaurado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('ventas.index')
                ->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    // Método para buscar ventas
    public function search(Request $request)
    {
        $search = $request->get('search');

        $ventas = Venta::with(['ticket.cliente.persona', 'ticket.usuario.persona', 'producto.departamento'])
            ->whereHas('producto', function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            })
            ->orWhereHas('ticket.cliente.persona', function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('apaterno', 'like', "%{$search}%");
            })
            ->orWhereHas('ticket', function($query) use ($search) {
                $query->where('folio', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('ventas.index', compact('ventas', 'search'));
    }

    // Método para ventas por ticket
    public function porTicket($ticketId)
    {
        $ticket = Ticket::with(['cliente.persona', 'usuario.persona', 'metodoPago'])->findOrFail($ticketId);
        $ventas = Venta::with('producto.departamento')
            ->porTicket($ticketId)
            ->orderBy('created_at')
            ->get();

        return view('ventas.por-ticket', compact('ventas', 'ticket'));
    }

    // Método para ventas por producto
    public function porProducto($productoId)
    {
        $producto = Producto::findOrFail($productoId);
        $ventas = Venta::with(['ticket.cliente.persona', 'ticket.usuario.persona'])
            ->porProducto($productoId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('ventas.por-producto', compact('ventas', 'producto'));
    }

    // Método para reporte de ventas por fecha
    public function reportePorFechas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $ventas = Venta::with(['ticket.cliente.persona', 'producto.departamento'])
            ->entreFechas($fechaInicio, $fechaFin)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalVentas = $ventas->sum('subtotal');
        $totalProductosVendidos = $ventas->sum('cantidad');
        $totalGanancia = $ventas->sum('ganancia');

        return view('ventas.reporte-fechas', compact(
            'ventas',
            'totalVentas',
            'totalProductosVendidos',
            'totalGanancia',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // Método para productos más vendidos
    public function productosMasVendidos()
    {
        $productosMasVendidos = Venta::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->groupBy('producto_id')
            ->with('producto.departamento')
            ->orderBy('total_vendido', 'desc')
            ->paginate(15);

        return view('ventas.productos-mas-vendidos', compact('productosMasVendidos'));
    }

    // Método para estadísticas de ventas
    public function estadisticas()
    {
        $totalVentas = Venta::count();
        $totalProductosVendidos = Venta::sum('cantidad');
        $totalIngresos = Venta::get()->sum('subtotal');
        $totalGanancia = Venta::get()->sum('ganancia');

        // Ventas del último mes
        $ventasUltimoMes = Venta::entreFechas(now()->subDays(30), now())->count();
        $ingresosUltimoMes = Venta::entreFechas(now()->subDays(30), now())->get()->sum('subtotal');

        return view('ventas.estadisticas', compact(
            'totalVentas',
            'totalProductosVendidos',
            'totalIngresos',
            'totalGanancia',
            'ventasUltimoMes',
            'ingresosUltimoMes'
        ));
    }
}
