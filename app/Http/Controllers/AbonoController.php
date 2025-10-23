<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Credito;
use Illuminate\Http\Request;

class AbonoController extends Controller
{
    public function index()
    {
        $abonos = Abono::with('credito.cliente.persona')->get();
        return view('abonos.index', compact('abonos'));
    }

    public function create()
    {
        $creditos = Credito::with('cliente.persona')->get();
        return view('abonos.create', compact('creditos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'credito_id' => 'required|exists:creditos,id',
            'abono' => 'required|numeric|min:0.01'
        ]);

        Abono::create([
            "credito_id" => $request->credito_id,
            "abono" => $request->abono
        ]);

        return redirect()->route('abonos.index')->with('success', 'Abono registrado correctamente');
    }

    public function show(Abono $abono)
    {
        return view('abonos.show', compact('abono'));
    }

    public function edit(Abono $abono)
    {
        $creditos = Credito::with('cliente.persona')->get();
        return view('abonos.edit', compact('abono', 'creditos'));
    }

    public function update(Request $request, Abono $abono)
    {
        $request->validate([
            'credito_id' => 'required|exists:creditos,id',
            'abono' => 'required|numeric|min:0.01'
        ]);

        $abono->update([
            "credito_id" => $request->credito_id,
            "abono" => $request->abono
        ]);

        return redirect()->route('abonos.index')->with('success', 'Abono actualizado correctamente');
    }

    public function destroy(Abono $abono)
    {
        $abono->delete();
        return redirect()->route('abonos.index')->with('success', 'Abono eliminado correctamente');
    }
}
