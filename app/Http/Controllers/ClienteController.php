<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with('persona')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        $personas = Persona::all();
        return view('clientes.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'limite_credito' => 'required|numeric|min:0'
        ]);

        Cliente::create([
            "persona_id" => $request->persona_id,
            "limite_credito" => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $personas = Persona::all();
        return view('clientes.edit', compact('cliente', 'personas'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'limite_credito' => 'required|numeric|min:0'
        ]);

        $cliente->update([
            "persona_id" => $request->persona_id,
            "limite_credito" => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente');
    }
}
