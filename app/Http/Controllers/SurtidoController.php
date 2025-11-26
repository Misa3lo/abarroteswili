<?php

namespace App\Http\Controllers;

use App\Models\Surtido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            // Obtener el nombre del producto
            $producto = Producto::findOrFail($request->producto_id);

            // Llamar al procedimiento almacenado
            $result = DB::select('CALL registrar_surtido(?, ?, ?)', [
                $producto->nombre,
                $request->cantidad,
                $request->precio_entrada
            ]);

            $mensaje = $result[0]->resultado ?? 'Surtido registrado correctamente';

            return redirect()->route('surtidos.index')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al registrar surtido: ' . $e->getMessage())
                ->withInput();
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

        try {
            // Para actualizar, primero eliminamos el surtido anterior
            // y luego creamos uno nuevo con el procedimiento

            // Obtener producto anterior para revertir existencias
            $productoAnterior = Producto::find($surtido->producto_id);
            $productoAnterior->existencias -= $surtido->cantidad;
            $productoAnterior->save();

            // Eliminar el surtido anterior
            $surtido->delete();

            // Crear nuevo surtido con el procedimiento
            $producto = Producto::findOrFail($request->producto_id);

            $result = DB::select('CALL registrar_surtido(?, ?, ?)', [
                $producto->nombre,
                $request->cantidad,
                $request->precio_entrada
            ]);

            $mensaje = $result[0]->resultado ?? 'Surtido actualizado correctamente';

            return redirect()->route('surtidos.index')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar surtido: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Surtido $surtido)
    {
        try {
            // Revertir existencias antes de eliminar
            $producto = Producto::find($surtido->producto_id);
            $producto->existencias -= $surtido->cantidad;
            $producto->save();

            $surtido->delete();

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido eliminado correctamente');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar surtido: ' . $e->getMessage());
        }
    }

    // Método adicional para surtido rápido
    public function surtidoRapido(Request $request)
    {
        $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:0.01',
            'productos.*.precio_entrada' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->productos as $productoSurtido) {
                $producto = Producto::findOrFail($productoSurtido['id']);

                $result = DB::select('CALL registrar_surtido(?, ?, ?)', [
                    $producto->nombre,
                    $productoSurtido['cantidad'],
                    $productoSurtido['precio_entrada']
                ]);

                $mensaje = $result[0]->resultado ?? '';
                if (str_contains($mensaje, 'Error')) {
                    throw new \Exception($mensaje);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Surtido rápido realizado correctamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error en surtido rápido: ' . $e->getMessage()
            ], 500);
        }
    }
}
