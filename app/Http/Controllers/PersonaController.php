<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    /**
     * Muestra una lista de todas las personas. (INDEX)
     */
    public function index()
    {
        $personas = Persona::all();
        return view('personas.index', compact('personas'));
    }

    /**
     * Muestra el formulario para crear una nueva persona. (CREATE)
     */
    public function create()
    {
        return view('personas.create');
    }

    /**
     * Almacena una persona recién creada en el almacenamiento. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 2. Creación
        Persona::create($request->all());

        // 3. Redirección (por ahora, volvemos al índice)
        return redirect()->route('personas.index')
            ->with('success', 'Persona creada exitosamente.');
    }

    /**
     * Muestra el formulario para editar la persona especificada. (EDIT)
     */
    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    /**
     * Actualiza la persona especificada en el almacenamiento. (UPDATE)
     */
    public function update(Request $request, Persona $persona)
    {
        // 1. Validación
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        // 2. Actualización
        $persona->update($request->all());

        // 3. Redirección
        return redirect()->route('personas.index')
            ->with('success', 'Persona actualizada exitosamente.');
    }

    /**
     * Elimina la persona especificada del almacenamiento. (DESTROY)
     */
    public function destroy(Persona $persona)
    {
        // Cuidado: Si esta persona es un cliente o un usuario, la FK fallará.
        try {
            $persona->delete();
            return redirect()->route('personas.index')
                ->with('success', 'Persona eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('personas.index')
                ->with('error', 'Error: No se puede eliminar la persona porque está asociada a un cliente o usuario.');
        }
    }
}
