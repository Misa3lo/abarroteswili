<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodosPago = DB::table('metodo_pago')->get();
        return view('metodo_pago.index', compact('metodosPago'));
    }

    public function create()
    {
        return view('metodo_pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago'
        ]);

        DB::table('metodo_pago')->insert([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago creado correctamente');
    }

    public function show($id)
    {
        $metodoPago = DB::table('metodo_pago')->where('id', $id)->first();
        return view('metodo_pago.show', compact('metodoPago'));
    }

    public function edit($id)
    {
        $metodoPago = DB::table('metodo_pago')->where('id', $id)->first();
        return view('metodo_pago.edit', compact('metodoPago'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion,' . $id
        ]);

        DB::table('metodo_pago')
            ->where('id', $id)
            ->update(['descripcion' => $request->descripcion]);

        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago actualizado correctamente');
    }

    public function destroy($id)
    {
        DB::table('metodo_pago')->where('id', $id)->delete();
        return redirect()->route('metodos-pago.index')->with('success', 'Método de pago eliminado correctamente');
    }
}
