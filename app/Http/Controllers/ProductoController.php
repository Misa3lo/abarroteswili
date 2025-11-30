<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource. (INDEX)
     */
    public function index()
    {
        // CORRECCIÓN: Eager Load la relación 'departamento'
        // Esto carga todos los departamentos de los productos en UNA SOLA consulta extra.
        $productos = Producto::with('departamento')->latest()->get();

        return view('productos.index', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto. (CREATE)
     */
    public function create()
    {
        // Necesitamos la lista de departamentos para el select
        $departamentos = Departamento::all();
        return view('productos.create', compact('departamentos'));
    }

    /**
     * Almacena un producto recién creado. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'codigo_barras' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0|gte:precio_compra', // Precio de venta debe ser >= de compra
            'departamento_id' => 'required|exists:departamentos,id',
            // La existencia inicial se fuerza a 0, el stock se gestiona por surtidos.
        ]);

        // 2. Creación del registro
        Producto::create(array_merge($request->all(), ['existencias' => 0]));

        // 3. Redirección
        return redirect()->route('productos.index')
            ->with('success', 'Producto registrado exitosamente. 📦');
    }

    /**
     * Muestra el formulario para editar el producto. (EDIT)
     */
    public function edit(Producto $producto)
    {
        $departamentos = Departamento::all();
        return view('productos.edit', compact('producto', 'departamentos'));
    }

    /**
     * Actualiza el producto especificado. (UPDATE)
     */
    public function update(Request $request, Producto $producto)
    {
        // 1. Validación
        $request->validate([
            'codigo_barras' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0|gte:precio_compra',
            'departamento_id' => 'required|exists:departamentos,id',
            // Existencias no se valida aquí porque se actualiza desde Surtidos/Ventas
        ]);

        // 2. Actualización
        $producto->update($request->all());

        // 3. Redirección
        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente. ✏️');
    }

    /**
     * Elimina el producto especificado. (DESTROY)
     */
    public function destroy(Producto $producto)
    {
        try {
            // Intentamos eliminar el producto
            $producto->delete();

            return redirect()->route('productos.index')
                ->with('success', 'Producto eliminado correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo de error de Clave Foránea (si tiene surtidos o ventas asociadas)
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('productos.index')
                    ->with('error', 'Error: No se puede eliminar el producto porque tiene **Surtidos o Ventas** históricas asociadas.');
            }
            return redirect()->route('productos.index')
                ->with('error', 'Error inesperado al intentar eliminar el producto.');
        }
    }
}
