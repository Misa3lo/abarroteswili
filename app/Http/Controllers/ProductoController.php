<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Departamento;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Obtenemos productos con su relación de departamento
        $productos = Producto::with('departamento')->get();
        
        // TAMBIÉN obtenemos los departamentos para poder llenar el select del formulario
        $departamentos = Departamento::all(); 

        // Retornamos la vista (que crearemos en el paso 3) pasando ambas variables
        return view('productos.index', compact('productos', 'departamentos'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('productos.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:productos',
            'descripcion' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'departamento_id' => 'required|exists:departamentos,id',
            'existencias' => 'required|numeric|min:0'
        ]);

        Producto::create([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "precio_venta" => $request->precio_venta,
            "precio_compra" => $request->precio_compra,
            "departamento_id" => $request->departamento_id,
            "existencias" => $request->existencias
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    public function show(Producto $producto)
    {
        $producto->load('departamento', 'surtidos', 'ventas');
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $departamentos = Departamento::all();
        return view('productos.edit', compact('producto', 'departamentos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'departamento_id' => 'required|exists:departamentos,id',
            'existencias' => 'required|numeric|min:0'
        ]);

        $producto->update([
            "nombre" => $request->nombre,
            "descripcion" => $request->descripcion,
            "precio_venta" => $request->precio_venta,
            "precio_compra" => $request->precio_compra,
            "departamento_id" => $request->departamento_id,
            "existencias" => $request->existencias
        ]);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }
}
