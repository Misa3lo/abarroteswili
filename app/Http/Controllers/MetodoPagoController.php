<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    /**
     * Muestra una lista de todos los métodos de pago. (INDEX)
     */
    public function index()
    {
        $metodosPago = MetodoPago::all();
        return view('metodos-pago.index', compact('metodosPago'));
    }

    /**
     * Muestra el formulario para crear un nuevo método de pago. (CREATE)
     */
    public function create()
    {
        return view('metodos-pago.create');
    }

    /**
     * Almacena un método de pago recién creado. (STORE)
     */
    public function store(Request $request)
    {
        $request->validate([
            // La columna es 'descripcion' y debe ser única [cite: 43]
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion',
        ]);

        MetodoPago::create($request->all());

        return redirect()->route('metodos-pago.index')
            ->with('success', 'Método de pago registrado exitosamente. 💳');
    }

    /**
     * Muestra el formulario para editar el método de pago. (EDIT)
     */
    public function edit(MetodoPago $metodoPago)
    {
        return view('metodos-pago.edit', compact('metodoPago'));
    }

    /**
     * Actualiza el método de pago especificado. (UPDATE)
     */
    public function update(Request $request, MetodoPago $metodoPago)
    {
        $request->validate([
            // Ignorar la descripción actual en la regla unique
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion,' . $metodoPago->id,
        ]);

        $metodoPago->update($request->all());

        return redirect()->route('metodos-pago.index')
            ->with('success', 'Método de pago actualizado exitosamente. ✏️');
    }

    /**
     * Elimina el método de pago especificado. (DESTROY)
     */
    public function destroy(MetodoPago $metodoPago)
    {
        try {
            $metodoPago->delete();

            return redirect()->route('metodos-pago.index')
                ->with('success', 'Método de pago eliminado correctamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Manejo de error de Clave Foránea (si tiene tickets asociados) [cite: 72]
            if ($e->errorInfo[1] == 1451) {
                return redirect()->route('metodos-pago.index')
                    ->with('error', 'Error: No se puede eliminar el método de pago porque tiene **Tickets de Venta** asociados. ⛔');
            }
            return redirect()->route('metodos-pago.index')
                ->with('error', 'Error inesperado al intentar eliminar el método de pago.');
        }
    }
}
