<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        // Cargar clientes con su información de persona
        $clientes = Cliente::with('persona')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'limite_credito' => 'required|numeric|min:0'
        ]);

        // Crear primero la persona
        $persona = Persona::create([
            'nombre' => $request->nombre,
            'apaterno' => $request->apaterno,
            'amaterno' => $request->amaterno,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        // Crear el cliente asociado a la persona
        Cliente::create([
            'persona_id' => $persona->id,
            'limite_credito' => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        // Cargar relaciones para mostrar
        $cliente->load('persona', 'creditos.abonos');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $cliente->load('persona');
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255',
            'limite_credito' => 'required|numeric|min:0'
        ]);

        // Actualizar la persona
        $cliente->persona->update([
            'nombre' => $request->nombre,
            'apaterno' => $request->apaterno,
            'amaterno' => $request->amaterno,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        // Actualizar el cliente
        $cliente->update([
            'limite_credito' => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        // Soft delete (usando deleted_at)
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}
