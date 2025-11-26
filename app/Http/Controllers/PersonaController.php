<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::with(['cliente', 'usuario'])
            ->orderBy('nombre')
            ->paginate(15);

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
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255'
        ]);

        Persona::create($request->all());

        return redirect()->route('personas.index')
            ->with('success', 'Persona creada correctamente');
    }

    public function show(Persona $persona)
    {
        $persona->load(['cliente.creditos.abonos', 'usuario.tickets']);
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
            'telefono' => 'nullable|string|max:15',
            'direccion' => 'nullable|string|max:255'
        ]);

        $persona->update($request->all());

        return redirect()->route('personas.index')
            ->with('success', 'Persona actualizada correctamente');
    }

    public function destroy(Persona $persona)
    {
        // Verificar que no tenga cliente o usuario asociado
        if ($persona->es_cliente || $persona->es_usuario) {
            return redirect()->route('personas.index')
                ->with('error', 'No se puede eliminar la persona porque tiene cliente o usuario asociado');
        }

        $persona->delete();

        return redirect()->route('personas.index')
            ->with('success', 'Persona eliminada correctamente');
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $personas = Persona::with(['cliente', 'usuario'])
            ->porNombre($search)
            ->orWherePorTelefono($search)
            ->orderBy('nombre')
            ->paginate(15);

        return view('personas.index', compact('personas', 'search'));
    }

    // Método para personas que son clientes
    public function clientes()
    {
        $personas = Persona::with('cliente')
            ->clientes()
            ->orderBy('nombre')
            ->paginate(15);

        return view('personas.clientes', compact('personas'));
    }

    // Método para personas que son usuarios
    public function usuarios()
    {
        $personas = Persona::with('usuario')
            ->usuarios()
            ->orderBy('nombre')
            ->paginate(15);

        return view('personas.usuarios', compact('personas'));
    }
}
