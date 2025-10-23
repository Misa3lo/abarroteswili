<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('persona')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $personas = Persona::doesntHave('usuario')->get();
        return view('usuarios.create', compact('personas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:usuarios,persona_id',
            'usuario' => 'required|string|max:50|unique:usuarios',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:administrador,empleado'
        ]);

        Usuario::create([
            "persona_id" => $request->persona_id,
            "usuario" => $request->usuario,
            "password" => Hash::make($request->password),
            "rol" => $request->rol
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function show(Usuario $usuario)
    {
        $usuario->load('persona', 'tickets');
        return view('usuarios.show', compact('usuario'));
    }

    public function edit(Usuario $usuario)
    {
        $personas = Persona::doesntHave('usuario')->orWhere('id', $usuario->persona_id)->get();
        return view('usuarios.edit', compact('usuario', 'personas'));
    }

    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id|unique:usuarios,persona_id,' . $usuario->id,
            'usuario' => 'required|string|max:50|unique:usuarios,usuario,' . $usuario->id,
            'password' => 'nullable|string|min:6',
            'rol' => 'required|in:administrador,empleado'
        ]);

        $updateData = [
            "persona_id" => $request->persona_id,
            "usuario" => $request->usuario,
            "rol" => $request->rol
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $usuario->update($updateData);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
