<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        // Mostrar departamentos con conteo de productos
        $departamentos = Departamento::withCount('productos')
            ->orderBy('nombre')
            ->paginate(10);

        return view('departamentos.index', compact('departamentos'));
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:departamentos,nombre',
            'descripcion' => 'required|string|max:255'
        ]);

        Departamento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado correctamente');
    }

    public function show(Departamento $departamento)
    {
        // Cargar productos del departamento
        $departamento->load(['productos' => function($query) {
            $query->orderBy('nombre');
        }]);

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
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado correctamente');
    }

    public function destroy(Departamento $departamento)
    {
        // Verificar que no tenga productos antes de eliminar
        if ($departamento->productos()->count() > 0) {
            return redirect()->route('departamentos.index')
                ->with('error', 'No se puede eliminar el departamento porque tiene productos asociados');
        }

        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento eliminado correctamente');
    }

    // Método para buscar departamentos
    public function search(Request $request)
    {
        $search = $request->get('search');

        $departamentos = Departamento::withCount('productos')
            ->where('nombre', 'like', "%{$search}%")
            ->orWhere('descripcion', 'like', "%{$search}%")
            ->orderBy('nombre')
            ->paginate(10);

        return view('departamentos.index', compact('departamentos', 'search'));
    }

    // Método para mostrar productos de un departamento
    public function productos(Departamento $departamento)
    {
        $productos = $departamento->productos()
            ->orderBy('nombre')
            ->paginate(15);

        return view('departamentos.productos', compact('departamento', 'productos'));
    }

    // Método para API (si necesitas JSON)
    public function apiIndex()
    {
        $departamentos = Departamento::select('id', 'nombre', 'descripcion')
            ->orderBy('nombre')
            ->get();

        return response()->json($departamentos);
    }
}
