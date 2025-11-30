<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Muestra el listado de clientes
    public function index()
    {
        // Cargar clientes con su información de persona
        $clientes = Cliente::with('persona')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    // Muestra el formulario para ASOCIAR una persona como nuevo cliente
    public function create()
    {
        // **Lógica Corregida:**
        // Carga personas que NO tienen un registro asociado en la tabla 'clientes'
        $personas = Persona::whereDoesntHave('cliente')
            ->orderBy('apaterno')
            ->orderBy('nombre')
            ->get();

        return view('clientes.create', compact('personas'));
    }

    // Almacena el nuevo cliente usando una persona existente
    public function store(Request $request)
    {
        // **Lógica Corregida:**
        // Solo valida los campos del rol de cliente (persona_id y limite_credito)
        $request->validate([
            // El persona_id debe existir y no debe tener ya un registro en la tabla clientes
            'persona_id' => 'required|exists:personas,id|unique:clientes,persona_id',
            'limite_credito' => 'required|numeric|min:0'
        ]);

        // Crear el cliente asociado a la persona
        Cliente::create([
            'persona_id' => $request->persona_id,
            'limite_credito' => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado y rol asignado correctamente');
    }

    // Muestra un cliente específico
    public function show(Cliente $cliente)
    {
        $cliente->load('persona', 'creditos.abonos');
        return view('clientes.show', compact('cliente'));
    }

    // Muestra el formulario para editar el límite de crédito
    public function edit(Cliente $cliente)
    {
        $cliente->load('persona');
        return view('clientes.edit', compact('cliente'));
    }

    // Actualiza solo el límite de crédito del cliente
    public function update(Request $request, Cliente $cliente)
    {
        // **Lógica Corregida:**
        // Solo valida y actualiza el campo específico de la tabla clientes
        $request->validate([
            'limite_credito' => 'required|numeric|min:0'
        ]);

        // Actualizar solo el cliente (ya no se actualiza la persona)
        $cliente->update([
            'limite_credito' => $request->limite_credito
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Límite de crédito actualizado correctamente');
    }

    // Elimina un cliente (soft delete)
    public function destroy(Cliente $cliente)
    {
        // Soft delete (usando deleted_at)
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente');
    }
}
