<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; // ¡Importante para las contraseñas!

class UsuarioController extends Controller
{
    /**
     * Muestra una lista de todos los usuarios. (INDEX)
     */
    public function index()
    {
        // Cargamos los usuarios con su información de Persona para mostrarla
        $usuarios = Usuario::with('persona')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario. (CREATE)
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Almacena un usuario recién creado. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            // Persona fields
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            // Usuario fields
            'usuario' => 'required|string|max:50|unique:usuarios,usuario',
            'password' => 'required|string|min:6|confirmed', // 'confirmed' busca 'password_confirmation'
            'rol' => 'required|in:administrador,empleado',
        ]);

        // 2. Transacción de Base de Datos
        try {
            DB::transaction(function () use ($request) {
                // A. Crear la Persona
                $persona = Persona::create($request->only([
                    'nombre', 'apaterno', 'amaterno', 'telefono', 'direccion'
                ]));

                // B. Crear el Usuario usando el ID de la persona y HASHEANDO la contraseña
                Usuario::create([
                    'persona_id' => $persona->id,
                    'usuario' => $request->usuario,
                    'password' => Hash::make($request->password), // Contraseña cifrada
                    'rol' => $request->rol,
                ]);
            });

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario registrado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al registrar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para editar el usuario. (EDIT)
     */
    public function edit(Usuario $usuario)
    {
        $usuario->load('persona');
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Actualiza el usuario especificado. (UPDATE)
     */
    public function update(Request $request, Usuario $usuario)
    {
        // 1. Validación
        $request->validate([
            // Persona fields
            'nombre' => 'required|string|max:100',
            'apaterno' => 'required|string|max:100',
            'amaterno' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            // Usuario fields: Ignorar el ID actual para la regla unique
            'usuario' => 'required|string|max:50|unique:usuarios,usuario,' . $usuario->id,
            'password' => 'nullable|string|min:6|confirmed', // Contraseña es OPCIONAL
            'rol' => 'required|in:administrador,empleado',
        ]);

        // 2. Transacción de Base de Datos
        try {
            DB::transaction(function () use ($request, $usuario) {
                // A. Actualizar la Persona asociada
                $usuario->persona->update($request->only([
                    'nombre', 'apaterno', 'amaterno', 'telefono', 'direccion'
                ]));

                // B. Preparar datos de Usuario
                $data = $request->only(['usuario', 'rol']);

                // C. Actualizar contraseña SOLO si se proporcionó una nueva
                if ($request->filled('password')) {
                    $data['password'] = Hash::make($request->password);
                }

                $usuario->update($data);
            });

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    /**
     * Elimina el usuario especificado. (DESTROY)
     */
    public function destroy(Usuario $usuario)
    {
        try {
            DB::transaction(function () use ($usuario) {
                $persona_id = $usuario->persona_id;

                // NOTA: Si el usuario ya generó tickets, MySQL bloqueará la eliminación (FK).

                // 1. Eliminar el registro de Usuario
                $usuario->delete();

                // 2. Eliminar la Persona asociada (fallará si esta Persona es también Cliente)
                Persona::where('id', $persona_id)->delete();
            });

            return redirect()->route('usuarios.index')
                ->with('success', 'Usuario y datos personales eliminados correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo específico de errores de Clave Foránea (Tickets o Cliente)
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('usuarios.index')
                    ->with('error', 'Error: No se puede eliminar el usuario porque tiene **Tickets de venta asociados** o la **Persona asociada es también un Cliente**.');
            }
            return redirect()->route('usuarios.index')
                ->with('error', 'Error inesperado al intentar eliminar el usuario.');
        }
    }
}
