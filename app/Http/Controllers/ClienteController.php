<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Importar para manejar transacciones

class ClienteController extends Controller
{
    /**
     * Muestra una lista de todos los clientes. (INDEX)
     */
    public function index()
    {
        // Cargamos los clientes con su información de Persona para mostrarla en la tabla
        $clientes = Cliente::with('persona')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente. (CREATE)
     */
    public function create()
    {
        // La vista de creación es un formulario simple de Persona + Límite de Crédito
        return view('clientes.create');
    }

    /**
     * Almacena un cliente recién creado. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación de ambos sets de datos
        $request->validate([
            // Datos de la tabla personas
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            // Dato de la tabla clientes
            'limite_credito' => 'required|numeric|min:0',
        ]);

        // 2. Transacción de Base de Datos
        try {
            DB::transaction(function () use ($request) {
                // A. Crear la Persona
                $persona = Persona::create([
                    'nombre' => $request->nombre,
                    'apaterno' => $request->apaterno,
                    'amaterno' => $request->amaterno,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                ]);

                // B. Crear el Cliente usando el ID de la persona
                Cliente::create([
                    'persona_id' => $persona->id,
                    'limite_credito' => $request->limite_credito,
                ]);
            });

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente y datos personales creados exitosamente. 👤');

        } catch (\Exception $e) {
            // Manejo de errores de transacción
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al crear el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar el cliente. (EDIT)
     */
    public function edit(Cliente $cliente)
    {
        // Necesitamos cargar la relación Persona para editar sus datos
        $cliente->load('persona');
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza el cliente especificado. (UPDATE)
     */
    public function update(Request $request, Cliente $cliente)
    {
        // 1. Validación
        $request->validate([
            // Datos de la tabla personas
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            // Dato de la tabla clientes
            'limite_credito' => 'required|numeric|min:0',
        ]);

        // 2. Transacción de Base de Datos para actualizar ambas tablas
        try {
            DB::transaction(function () use ($request, $cliente) {
                // A. Actualizar la Persona asociada
                $cliente->persona->update([
                    'nombre' => $request->nombre,
                    'apaterno' => $request->apaterno,
                    'amaterno' => $request->amaterno,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion,
                ]);

                // B. Actualizar el Cliente
                $cliente->update([
                    'limite_credito' => $request->limite_credito,
                ]);
            });

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente y datos personales actualizados. ✏️');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el cliente: ' . $e->getMessage());
        }
    }

    /**
     * Elimina el cliente especificado. (DESTROY)
     */
    public function destroy(Cliente $cliente)
    {
        try {
            DB::transaction(function () use ($cliente) {
                // 1. Obtener la Persona ID antes de eliminar el Cliente
                $persona_id = $cliente->persona_id;

                // 2. Eliminar el Cliente
                $cliente->delete();

                // 3. Eliminar la Persona (si ya no está asociada a un Usuario)
                Persona::where('id', $persona_id)->delete();

                // Nota: Esto falla si la persona también es un 'usuario' (FK: fk_usuarios_personas)
            });

            return redirect()->route('clientes.index')
                ->with('success', 'Cliente eliminado correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Error de Clave Foránea (el cliente tiene créditos o tickets)
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('clientes.index')
                    ->with('error', 'Error: No se puede eliminar el cliente porque tiene **Créditos o Tickets** asociados.');
            }
            // Error si la persona es también un usuario
            if ($e->errorInfo[1] == 1451 && str_contains($e->getMessage(), 'fk_usuarios_personas')) {
                return redirect()->route('clientes.index')
                    ->with('error', 'Error: La persona asociada a este cliente es también un **Usuario** del sistema y no puede ser eliminada.');
            }
            return redirect()->route('clientes.index')
                ->with('error', 'Error inesperado al eliminar el cliente.');
        }
    }
}
