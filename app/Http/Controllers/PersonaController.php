<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::all();
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        return view('personas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'nullable|string|max:100',
            'telefono' => 'nullable|numeric|digits_between:10,20',
            'direccion' => 'nullable|string|max:255'
        ]);

        Persona::create([
            "nombre" => $request->nombre,
            "apaterno" => $request->apaterno,
            "amaterno" => $request->amaterno,
            "telefono" => $request->telefono,
            "direccion" => $request->direccion
        ]);

        return redirect()->route('personas.index')->with('success', 'Persona creada correctamente');
    }

    public function show(Persona $persona)
    {
        $persona->load('cliente', 'usuario');
        return view('personas.show', compact('persona'));
    }

    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'nullable|string|max:100',
            'telefono' => 'nullable|numeric|digits_between:10,20',
            'direccion' => 'nullable|string|max:255'
        ]);

        $persona->update([
            "nombre" => $request->nombre,
            "apaterno" => $request->apaterno,
            "amaterno" => $request->amaterno,
            "telefono" => $request->telefono,
            "direccion" => $request->direccion
        ]);

        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente');
    }

    public function destroy(Persona $persona)
    {
        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente');
    }
}
