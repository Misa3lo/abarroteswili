<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodosPago = MetodoPago::all();
        return view('metodos_pago.index', compact('metodosPago'));
    }

    public function create()
    {
        return view('metodos_pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago'
        ]);

        MetodoPago::create([
            "descripcion" => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago creado correctamente');
    }

    public function show(MetodoPago $metodoPago)
    {
        $metodoPago->load('tickets');
        return view('metodos_pago.show', compact('metodoPago'));
    }

    public function edit(MetodoPago $metodoPago)
    {
        return view('metodos_pago.edit', compact('metodoPago'));
    }

    public function update(Request $request, MetodoPago $metodoPago)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion,' . $metodoPago->id
        ]);

        $metodoPago->update([
            "descripcion" => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago actualizado correctamente');
    }

    public function destroy(MetodoPago $metodoPago)
    {
        $metodoPago->delete();
        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago eliminado correctamente');
    }
}
