<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Muestra una lista de todos los departamentos. (INDEX)
     */
    public function index()
    {
        // Obtiene todos los departamentos de la base de datos
        $departamentos = Departamento::all();
        // Carga la vista 'departamentos.index' y le pasa la lista de departamentos
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Muestra el formulario para crear un nuevo departamento. (CREATE)
     */
    public function create()
    {
        return view('departamentos.create');
    }

    /**
     * Almacena un departamento recién creado en el almacenamiento. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación (Mínima, por ser proyecto escolar)
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Creación del registro
        Departamento::create($request->all());

        // 3. Redirección
        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento creado exitosamente.');
    }

    /**
     * Muestra el departamento especificado. (SHOW - Opcional para este CRUD)
     */
    public function show(Departamento $departamento)
    {
        // En catálogos simples, show no es tan usado, pero lo dejamos por si acaso.
        return view('departamentos.show', compact('departamento'));
    }

    /**
     * Muestra el formulario para editar el departamento especificado. (EDIT)
     */
    public function edit(Departamento $departamento)
    {
        return view('departamentos.edit', compact('departamento'));
    }

    /**
     * Actualiza el departamento especificado en el almacenamiento. (UPDATE)
     */
    public function update(Request $request, Departamento $departamento)
    {
        // 1. Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // 2. Actualización
        $departamento->update($request->all());

        // 3. Redirección
        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento actualizado exitosamente.');
    }

    /**
     * Elimina el departamento especificado del almacenamiento. (DESTROY)
     */
    public function destroy(Departamento $departamento)
    {
        try {
            // Intenta eliminar el departamento
            $departamento->delete();

            // Si tiene éxito
            return redirect()->route('departamentos.index')
                ->with('success', 'Departamento eliminado correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Si ocurre un error de restricción de clave foránea (FK)
            $errorCode = $e->errorInfo[1];

            // El código de error 1451 es común para 'Cannot delete or update a parent row: a foreign key constraint fails'
            if ($errorCode == 1451) {
                return redirect()->route('departamentos.index')
                    ->with('error', 'Error: No se puede eliminar el departamento porque **tiene productos asociados**. Debes reasignar o eliminar esos productos primero.');
            }

            // Para cualquier otro error
            return redirect()->route('departamentos.index')
                ->with('error', 'Error inesperado al intentar eliminar el departamento.');
        } catch (\Exception $e) {
            return redirect()->route('departamentos.index')
                ->with('error', 'Error interno del servidor.');
        }
    }
}
