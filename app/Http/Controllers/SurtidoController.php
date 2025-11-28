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

        try {
            // Obtener el nombre del producto (ya que el procedimiento lo requiere)
            $producto = DB::table('productos')->where('id', $request->producto_id)->value('nombre');

            // Llamar al procedimiento almacenado
            $resultado = DB::select('CALL registrar_surtido(?, ?, ?)', [
                $producto,
                $request->cantidad,
                $request->precio_entrada
            ]);

            // Mostrar el mensaje devuelto desde el procedimiento
            $mensaje = $resultado[0]->resultado ?? 'Sin respuesta';

            return redirect()->route('surtidos.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
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
