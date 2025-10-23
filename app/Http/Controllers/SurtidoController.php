<?php

namespace App\Http\Controllers;

use App\Models\Surtido;
use App\Models\Producto;
use Illuminate\Http\Request;

class SurtidoController extends Controller
{
    public function index()
    {
        $surtidos = Surtido::with('producto.departamento')->get();
        return view('surtidos.index', compact('surtidos'));
    }

    public function create()
    {
        $productos = Producto::with('departamento')->get();
        return view('surtidos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'precio_entrada' => 'required|numeric|min:0',
            'cantidad' => 'required|numeric|min:0.01'
        ]);

        // Crear el surtido
        $surtido = Surtido::create([
            "producto_id" => $request->producto_id,
            "precio_entrada" => $request->precio_entrada,
            "cantidad" => $request->cantidad
        ]);

        // Actualizar existencias del producto
        $producto = Producto::find($request->producto_id);
        $producto->existencias += $request->cantidad;
        $producto->precio_compra = $request->precio_entrada; // Actualizar precio de compra
        $producto->save();

        return redirect()->route('surtidos.index')->with('success', 'Surtido registrado correctamente');
    }

    public function show(Surtido $surtido)
    {
        $surtido->load('producto.departamento');
        return view('surtidos.show', compact('surtido'));
    }

    public function edit(Surtido $surtido)
    {
        $productos = Producto::with('departamento')->get();
        return view('surtidos.edit', compact('surtido', 'productos'));
    }

    public function update(Request $request, Surtido $surtido)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'precio_entrada' => 'required|numeric|min:0',
            'cantidad' => 'required|numeric|min:0.01'
        ]);

        // Revertir existencias anteriores
        $productoAnterior = Producto::find($surtido->producto_id);
        $productoAnterior->existencias -= $surtido->cantidad;
        $productoAnterior->save();

        // Actualizar surtido
        $surtido->update([
            "producto_id" => $request->producto_id,
            "precio_entrada" => $request->precio_entrada,
            "cantidad" => $request->cantidad
        ]);

        // Aplicar nuevas existencias
        $productoNuevo = Producto::find($request->producto_id);
        $productoNuevo->existencias += $request->cantidad;
        $productoNuevo->precio_compra = $request->precio_entrada;
        $productoNuevo->save();

        return redirect()->route('surtidos.index')->with('success', 'Surtido actualizado correctamente');
    }

    public function destroy(Surtido $surtido)
    {
        // Revertir existencias antes de eliminar
        $producto = Producto::find($surtido->producto_id);
        $producto->existencias -= $surtido->cantidad;
        $producto->save();

        $surtido->delete();
        return redirect()->route('surtidos.index')->with('success', 'Surtido eliminado correctamente');
    }
}
