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
        // Mostrar surtidos con información del producto
        $surtidos = Surtido::with('producto.departamento')
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('surtidos.index', compact('surtidos'));
    }

    public function create()
    {
        // Obtener productos para el select
        $productos = Producto::orderBy('nombre')->get();
        return view('surtidos.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'precio_entrada' => 'required|numeric|min:0.01',
            'cantidad' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::beginTransaction();

            // Obtener el producto
            $producto = Producto::findOrFail($request->producto_id);

            // Calcular el nuevo precio de venta (25% de ganancia)
            $nuevoPrecioVenta = $request->precio_entrada + ($request->precio_entrada * 0.25);

            // Actualizar el producto
            $producto->update([
                'precio_compra' => $request->precio_entrada,
                'precio_venta' => $nuevoPrecioVenta,
                'existencias' => $producto->existencias + $request->cantidad
            ]);

            // Crear el registro de surtido
            Surtido::create([
                'producto_id' => $request->producto_id,
                'precio_entrada' => $request->precio_entrada,
                'cantidad' => $request->cantidad,
                'fecha_hora' => now()
            ]);

            DB::commit();

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido registrado correctamente. Precio de venta actualizado.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al registrar el surtido: ' . $e->getMessage()])->withInput();
        }
    }

    public function show(Surtido $surtido)
    {
        $surtido->load('producto.departamento');
        return view('surtidos.show', compact('surtido'));
    }

    public function edit(Surtido $surtido)
    {
        $surtido->load('producto');
        $productos = Producto::orderBy('nombre')->get();
        return view('surtidos.edit', compact('surtido', 'productos'));
    }

    public function update(Request $request, Surtido $surtido)
    {
        $request->validate([
            'precio_entrada' => 'required|numeric|min:0.01',
            'cantidad' => 'required|numeric|min:0.01',
            'fecha_hora' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            // Guardar valores antiguos para ajustar existencias
            $cantidadAnterior = $surtido->cantidad;
            $nuevaCantidad = $request->cantidad;
            $diferenciaCantidad = $nuevaCantidad - $cantidadAnterior;

            // Actualizar el surtido
            $surtido->update([
                'precio_entrada' => $request->precio_entrada,
                'cantidad' => $nuevaCantidad,
                'fecha_hora' => $request->fecha_hora
            ]);

            // Si cambió la cantidad, actualizar existencias del producto
            if ($diferenciaCantidad != 0) {
                $surtido->producto->actualizarExistencias($diferenciaCantidad);
            }

            // Si cambió el precio de entrada, recalcular precio de venta
            if ($surtido->precio_entrada != $request->precio_entrada) {
                $nuevoPrecioVenta = $request->precio_entrada + ($request->precio_entrada * 0.25);
                $surtido->producto->update([
                    'precio_compra' => $request->precio_entrada,
                    'precio_venta' => $nuevoPrecioVenta
                ]);
            }

            DB::commit();

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido actualizado correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al actualizar el surtido: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Surtido $surtido)
    {
        try {
            DB::beginTransaction();

            // Restar las existencias del producto antes de eliminar
            $producto = $surtido->producto;
            $producto->actualizarExistencias(-$surtido->cantidad);

            // Eliminar el surtido
            $surtido->delete();

            DB::commit();

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido eliminado correctamente. Existencias ajustadas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('surtidos.index')
                ->with('error', 'Error al eliminar el surtido: ' . $e->getMessage());
        }
    }

    // Método para usar el stored procedure existente
    public function registrarConProcedimiento(Request $request)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:100',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_entrada' => 'required|numeric|min:0.01'
        ]);

        try {
            // Llamar al stored procedure
            DB::statement('CALL registrar_surtido(?, ?, ?)', [
                $request->nombre_producto,
                $request->cantidad,
                $request->precio_entrada
            ]);

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido registrado correctamente usando procedimiento almacenado');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al registrar surtido: ' . $e->getMessage()])->withInput();
        }
    }

    // Método para buscar surtidos
    public function search(Request $request)
    {
        $search = $request->get('search');

        $surtidos = Surtido::with('producto.departamento')
            ->whereHas('producto', function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            })
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('surtidos.index', compact('surtidos', 'search'));
    }

    // Método para surtidos por producto
    public function porProducto($productoId)
    {
        $producto = Producto::findOrFail($productoId);
        $surtidos = Surtido::with('producto.departamento')
            ->porProducto($productoId)
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);

        return view('surtidos.por-producto', compact('surtidos', 'producto'));
    }

    // Método para reporte de surtidos por fecha
    public function reportePorFechas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $surtidos = Surtido::with('producto.departamento')
            ->entreFechas($fechaInicio, $fechaFin)
            ->orderBy('fecha_hora', 'desc')
            ->get();

        $totalCosto = $surtidos->sum('costo_total');
        $totalProductos = $surtidos->count();
        $totalUnidades = $surtidos->sum('cantidad');

        return view('surtidos.reporte-fechas', compact(
            'surtidos',
            'totalCosto',
            'totalProductos',
            'totalUnidades',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // Método para estadísticas de surtidos
    public function estadisticas()
    {
        $totalSurtidos = Surtido::count();
        $totalInversion = Surtido::get()->sum('costo_total');
        $surtidosRecientes = Surtido::recientes(7)->count();

        $productosMasSurtidos = Surtido::select('producto_id', DB::raw('SUM(cantidad) as total_surtido'))
            ->groupBy('producto_id')
            ->with('producto')
            ->orderBy('total_surtido', 'desc')
            ->take(10)
            ->get();

        return view('surtidos.estadisticas', compact(
            'totalSurtidos',
            'totalInversion',
            'surtidosRecientes',
            'productosMasSurtidos'
        ));
    }
}
