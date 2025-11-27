<?php

namespace App\Http\Controllers;

use App\Models\Surtido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ¡Necesario para el Stored Procedure!

class SurtidoController extends Controller
{
    /**
     * Muestra la lista de surtidos Y la lista de productos (para el formulario en la misma vista).
     */
    public function index()
    {
        // 1. Obtener la lista de surtidos (para la tabla principal)
        $surtidos = Surtido::with('producto.departamento')->get();
        
        // 2. Obtener la lista de productos (¡CORRECCIÓN! Para el formulario de registro en index.blade.php)
        $productos = Producto::select('id', 'nombre')->get();

        // 3. Pasar AMBAS variables a la vista
        return view('surtidos.index', compact('surtidos', 'productos'));
    }

    /**
     * Muestra el formulario de registro (si se decide usar una vista separada).
     */
    public function create()
    {
        // Extraemos solo el ID y el nombre de los productos
        $productos = Producto::select('id', 'nombre')->get(); 
        
        return view('surtidos.create', compact('productos'));
    }

    /**
     * Valida los datos y llama al procedimiento almacenado 'registrar_surtido'.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'precio_entrada' => 'required|numeric|min:0.01',
            'cantidad' => 'required|numeric|min:0.01'
        ], [
            'producto_id.required' => 'Debe seleccionar un producto.',
            'precio_entrada.min' => 'El precio de entrada debe ser mayor a 0.',
            'cantidad.min' => 'La cantidad debe ser mayor a 0.'
        ]);

        // 2. Obtener el nombre del producto (requerido por tu Procedimiento Almacenado)
        $producto = Producto::find($request->producto_id);

        if (!$producto) {
            return redirect()->back()->withInput()->with('error', 'Producto no encontrado.');
        }

        $nombre_producto = $producto->nombre;
        $cantidad = $request->cantidad;
        $precio_entrada = $request->precio_entrada;
        
        // 3. Preparar y ejecutar la llamada al Stored Procedure
        $query = "CALL registrar_surtido(?, ?, ?)";

        try {
            // Se usa DB::select para capturar el resultado/mensaje que devuelve el SP
            $results = DB::select($query, [$nombre_producto, $cantidad, $precio_entrada]);
            
            // Revisar si el SP devolvió un mensaje de error (ej: 'Error: El precio debe ser > 0')
            if (isset($results[0]->resultado) && str_contains($results[0]->resultado, 'Error')) {
                 return redirect()->route('surtidos.index')->withInput()->with('error', $results[0]->resultado);
                 // Redirigimos a index ya que es donde tienes el formulario
            }
            
        } catch (\Exception $e) {
            // Manejo de errores de base de datos generales (ej: conexión)
            return redirect()->route('surtidos.index')->withInput()->with('error', 'Error del sistema: No se pudo registrar el surtido. Verifique la conexión a la DB.');
        }

        // 4. Redirección exitosa
        return redirect()->route('surtidos.index')->with('success', 'Surtido registrado correctamente usando el procedimiento almacenado.');
    }

    // --- Métodos CRUD restantes (Mantienen la lógica original con Eloquent) ---

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
    
    // Ruta adicional que habías agregado, puedes eliminarla si usas el método store()
    public function registrarConProcedimiento()
    {
        // Esta lógica ha sido integrada en el método store(), por lo que este método 
        // y su ruta asociada ('surtidos.registrar') son redundantes y pueden eliminarse.
    }
}