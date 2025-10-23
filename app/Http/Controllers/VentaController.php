<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Ticket;
use App\Models\Producto;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with(['ticket', 'producto.departamento'])->get();
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $tickets = Ticket::with(['cliente.persona', 'usuario.persona'])->get();
        $productos = Producto::where('existencias', '>', 0)->get();
        return view('ventas.create', compact('tickets', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio' => 'required|numeric|min:0'
        ]);

        // Verificar existencias
        $producto = Producto::find($request->producto_id);
        if ($producto->existencias < $request->cantidad) {
            return back()->with('error', 'No hay suficientes existencias del producto. Existencias disponibles: ' . $producto->existencias);
        }

        // Crear la venta
        Venta::create([
            "ticket_id" => $request->ticket_id,
            "producto_id" => $request->producto_id,
            "cantidad" => $request->cantidad,
            "precio" => $request->precio
        ]);

        // Actualizar existencias del producto
        $producto->existencias -= $request->cantidad;
        $producto->save();

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load(['ticket.cliente.persona', 'ticket.usuario.persona', 'producto.departamento']);
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $tickets = Ticket::with(['cliente.persona', 'usuario.persona'])->get();
        $productos = Producto::where('existencias', '>', 0)->get();
        return view('ventas.edit', compact('venta', 'tickets', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio' => 'required|numeric|min:0'
        ]);

        // Revertir existencias anteriores
        $productoAnterior = Producto::find($venta->producto_id);
        $productoAnterior->existencias += $venta->cantidad;
        $productoAnterior->save();

        // Verificar existencias nuevas
        $productoNuevo = Producto::find($request->producto_id);
        if ($productoNuevo->existencias < $request->cantidad) {
            return back()->with('error', 'No hay suficientes existencias del producto. Existencias disponibles: ' . $productoNuevo->existencias);
        }

        // Actualizar venta
        $venta->update([
            "ticket_id" => $request->ticket_id,
            "producto_id" => $request->producto_id,
            "cantidad" => $request->cantidad,
            "precio" => $request->precio
        ]);

        // Aplicar nuevas existencias
        $productoNuevo->existencias -= $request->cantidad;
        $productoNuevo->save();

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente');
    }

    public function destroy(Venta $venta)
    {
        // Revertir existencias antes de eliminar
        $producto = Producto::find($venta->producto_id);
        $producto->existencias += $venta->cantidad;
        $producto->save();

        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente');
    }
}
