<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos',
            'descripcion' => 'required|string|max:255'
        ]);

        Departamento::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado correctamente');
    }

    public function show(Departamento $departamento)
    {
        $departamento->load('productos');
        return view('departamentos.show', compact('departamento'));
    }

    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    public function update(Request $request, Departamento $departamento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre,' . $departamento->id,
            'descripcion' => 'required|string|max:255'
        ]);

        $departamento->update([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado correctamente');
    }

    public function destroy(Departamento $departamento)
    {
        $departamento->delete();
        return redirect()->route('departamentos.index')->with('success', 'Departamento eliminado correctamente');
    }
}
