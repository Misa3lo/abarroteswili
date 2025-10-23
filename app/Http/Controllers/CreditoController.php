<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function index()
    {
        $creditos = Credito::with('cliente.persona')->get();
        return view('creditos.index', compact('creditos'));
    }

    public function create()
    {
        $clientes = Cliente::with('persona')->get();
        return view('creditos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'adeudo' => 'required|numeric|min:0'
        ]);

        Credito::create([
            "cliente_id" => $request->cliente_id,
            "adeudo" => $request->adeudo
        ]);

        return redirect()->route('creditos.index')->with('success', 'Crédito creado correctamente');
    }

    public function show(Credito $credito)
    {
        $credito->load('cliente.persona', 'abonos');
        return view('creditos.show', compact('credito'));
    }

    public function edit(Credito $credito)
    {
        $clientes = Cliente::with('persona')->get();
        return view('creditos.edit', compact('credito', 'clientes'));
    }

    public function update(Request $request, Credito $credito)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'adeudo' => 'required|numeric|min:0'
        ]);

        $credito->update([
            "cliente_id" => $request->cliente_id,
            "adeudo" => $request->adeudo
        ]);

        return redirect()->route('creditos.index')->with('success', 'Crédito actualizado correctamente');
    }

    public function destroy(Credito $credito)
    {
        $credito->delete();
        return redirect()->route('creditos.index')->with('success', 'Crédito eliminado correctamente');
    }
}
