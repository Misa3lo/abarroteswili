<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Departamento;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Mostrar productos con información del departamento
        $productos = Producto::with('departamento')
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        // Obtener departamentos para el select
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('productos.create', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:productos,nombre',
            'descripcion' => 'required|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'departamento_id' => 'required|exists:departamentos,id',
            'existencias' => 'required|numeric|min:0'
        ]);

        // Validar que el precio de venta sea mayor al de compra
        if ($request->precio_venta <= $request->precio_compra) {
            return back()->withErrors([
                'precio_venta' => 'El precio de venta debe ser mayor al precio de compra'
            ])->withInput();
        }

        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'departamento_id' => $request->departamento_id,
            'existencias' => $request->existencias
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function show(Producto $producto)
    {
        // Cargar relaciones para mostrar
        $producto->load(['departamento', 'surtidos', 'ventas.ticket']);
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        return view('productos.edit', compact('producto', 'departamentos'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:productos,nombre,' . $producto->id,
            'descripcion' => 'required|string|max:255',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'departamento_id' => 'required|exists:departamentos,id',
            'existencias' => 'required|numeric|min:0'
        ]);

        // Validar que el precio de venta sea mayor al de compra
        if ($request->precio_venta <= $request->precio_compra) {
            return back()->withErrors([
                'precio_venta' => 'El precio de venta debe ser mayor al precio de compra'
            ])->withInput();
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_compra' => $request->precio_compra,
            'precio_venta' => $request->precio_venta,
            'departamento_id' => $request->departamento_id,
            'existencias' => $request->existencias
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        // Verificar que no tenga surtidos o ventas antes de eliminar
        if ($producto->surtidos()->count() > 0 || $producto->ventas()->count() > 0) {
            return redirect()->route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque tiene historial de surtidos o ventas');
        }

        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente');
    }

    // Método para buscar productos
    public function search(Request $request)
    {
        $search = $request->get('search');

        $productos = Producto::with('departamento')
            ->where('nombre', 'like', "%{$search}%")
            ->orWhere('descripcion', 'like', "%{$search}%")
            ->orWhereHas('departamento', function($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%");
            })
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.index', compact('productos', 'search'));
    }

    // Método para productos con existencias
    public function conExistencias()
    {
        $productos = Producto::with('departamento')
            ->conExistencias()
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.con-existencias', compact('productos'));
    }

    // Método para productos agotados
    public function agotados()
    {
        $productos = Producto::with('departamento')
            ->agotados()
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.agotados', compact('productos'));
    }

    // Método para productos bajo stock
    public function bajoStock()
    {
        $productos = Producto::with('departamento')
            ->bajoStock()
            ->orderBy('existencias', 'asc')
            ->paginate(15);

        return view('productos.bajo-stock', compact('productos'));
    }

    // Método para productos por departamento
    public function porDepartamento($departamentoId)
    {
        $departamento = Departamento::findOrFail($departamentoId);
        $productos = Producto::with('departamento')
            ->porDepartamento($departamentoId)
            ->orderBy('nombre')
            ->paginate(15);

        return view('productos.por-departamento', compact('productos', 'departamento'));
    }

    // Método para actualizar existencias rápido
    public function actualizarExistencias(Request $request, Producto $producto)
    {
        $request->validate([
            'cantidad' => 'required|numeric'
        ]);

        $producto->actualizarExistencias($request->cantidad);

        return redirect()->route('productos.show', $producto)
            ->with('success', 'Existencias actualizadas correctamente');
    }

    // Método para estadísticas de productos
    public function estadisticas()
    {
        $totalProductos = Producto::count();
        $totalConExistencias = Producto::conExistencias()->count();
        $totalAgotados = Producto::agotados()->count();
        $totalBajoStock = Producto::bajoStock()->count();
        $valorTotalInventario = Producto::withExistencias()->get()->sum('valor_inventario');

        $productosMasVendidos = Producto::withCount('ventas')
            ->orderBy('ventas_count', 'desc')
            ->take(10)
            ->get();

        return view('productos.estadisticas', compact(
            'totalProductos',
            'totalConExistencias',
            'totalAgotados',
            'totalBajoStock',
            'valorTotalInventario',
            'productosMasVendidos'
        ));
    }

    // En el modelo Producto, agregar esta relación:
    public function surtidos()
    {
        return $this->hasMany(Surtido::class, 'producto_id');
    }

}
