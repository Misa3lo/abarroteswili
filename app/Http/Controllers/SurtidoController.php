<?php

namespace App\Http\Controllers;

use App\Models\Surtido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurtidoController extends Controller
{
    /**
     * Muestra una lista del historial de surtidos. (INDEX)
     */
    public function index()
    {
        // Si el modelo Surtido.php tiene definida const CREATED_AT = 'fecha_hora';
        // podemos usar ->latest() nuevamente.
        $surtidos = Surtido::with('producto')->latest()->get();
        return view('surtidos.index', compact('surtidos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo surtido. (CREATE)
     */
    public function create()
    {
        // AJUSTE: Se necesita la lista de productos para el formulario
        // Ahora usamos 'codigo_barra' en lugar de 'nombre'
        $productos = Producto::orderBy('codigo_barras')->get(['id', 'codigo_barras', 'existencias']);
        return view('surtidos.create', compact('productos'));
    }

    /**
     * Ejecuta el Procedimiento Almacenado para registrar el surtido y actualizar el stock. (STORE)
     */
    public function store(Request $request)
    {
        // 1. Validación
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_entrada' => 'required|numeric|min:0.01',
        ]);

        // 2. Ejecutar el Procedimiento Almacenado
        try {
            $producto = Producto::findOrFail($request->producto_id);
            // OBTENEMOS EL VALOR DEL NUEVO CAMPO
            $codigo_barras = $producto->codigo_barras;

            // Los parámetros que el SP requiere son: (p_codigo_barra, pcantidad, pprecio_entrada)
            DB::statement(
                "CALL registrar_surtido(?, ?, ?)",
                [
                    $codigo_barras, // ¡CAMBIO! Pasamos el código de barras
                    (double) $request->cantidad,
                    (float) $request->precio_entrada
                ]
            );

            return redirect()->route('surtidos.index')
                ->with('success', 'Surtido registrado y existencias actualizadas correctamente. 🚚');

        } catch (\Exception $e) {
            // Manejo de errores de conexión o del propio Procedimiento Almacenado
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al ejecutar el surtido: Verifique la conexión a DB o el SP: ' . $e->getMessage());
        }
    }

    // Deshabilitamos los métodos no necesarios para el flujo de surtido
    public function show() { return abort(404); }
    public function edit() { return abort(404); }
    public function update() { return abort(404); }
    public function destroy() { return abort(404); }
}
