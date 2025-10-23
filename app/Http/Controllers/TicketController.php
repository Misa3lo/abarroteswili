<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\MetodoPago;
use App\Models\Producto;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['usuario.persona', 'cliente.persona', 'metodoPago', 'ventas.producto'])->get();
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $usuarios = Usuario::with('persona')->get();
        $clientes = Cliente::with('persona')->get();
        $metodosPago = MetodoPago::all();
        $productos = Producto::where('existencias', '>', 0)->get();

        return view('tickets.create', compact('usuarios', 'clientes', 'metodosPago', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|string|max:50|unique:tickets',
            'usuario_id' => 'required|exists:usuarios,id',
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            'total' => 'required|numeric|min:0'
        ]);

        Ticket::create([
            "folio" => $request->folio,
            "usuario_id" => $request->usuario_id,
            "cliente_id" => $request->cliente_id,
            "metodo_pago_id" => $request->metodo_pago_id,
            "total" => $request->total
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['usuario.persona', 'cliente.persona', 'metodoPago', 'ventas.producto.departamento']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $usuarios = Usuario::with('persona')->get();
        $clientes = Cliente::with('persona')->get();
        $metodosPago = MetodoPago::all();

        return view('tickets.edit', compact('ticket', 'usuarios', 'clientes', 'metodosPago'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'folio' => 'required|string|max:50|unique:tickets,folio,' . $ticket->id,
            'usuario_id' => 'required|exists:usuarios,id',
            'cliente_id' => 'required|exists:clientes,id',
            'metodo_pago_id' => 'required|exists:metodo_pago,id',
            'total' => 'required|numeric|min:0'
        ]);

        $ticket->update([
            "folio" => $request->folio,
            "usuario_id" => $request->usuario_id,
            "cliente_id" => $request->cliente_id,
            "metodo_pago_id" => $request->metodo_pago_id,
            "total" => $request->total
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente');
    }
}
