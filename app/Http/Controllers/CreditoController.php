<?php

namespace App\Http\Controllers;

use App\Models\Credito;
use App\Models\Cliente;
use App\Models\Abono;
use Illuminate\Http\Request;

class CreditoController extends Controller
{
    public function index()
    {
        // Mostrar créditos con información del cliente y abonos
        $creditos = Credito::with(['cliente.persona', 'abonos'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('creditos.index', compact('creditos'));
    }

    public function create()
    {
        // Obtener clientes activos para el select
        $clientes = Cliente::with('persona')
            ->whereHas('persona') // Solo clientes con persona asociada
            ->get();

        return view('creditos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'adeudo' => 'required|numeric|min:0.01',
            'descripcion' => 'nullable|string|max:255'
        ]);

        // Verificar que el cliente no exceda su límite de crédito
        $cliente = Cliente::with('creditos')->findOrFail($request->cliente_id);
        $totalAdeudado = $cliente->creditos->sum('adeudo');

        if (($totalAdeudado + $request->adeudo) > $cliente->limite_credito) {
            return back()->withErrors([
                'adeudo' => 'El cliente excedería su límite de crédito. Límite: $' .
                    number_format($cliente->limite_credito, 2) .
                    ', Actual: $' . number_format($totalAdeudado, 2)
            ])->withInput();
        }

        // Crear el crédito
        Credito::create([
            'cliente_id' => $request->cliente_id,
            'adeudo' => $request->adeudo,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('creditos.index')
            ->with('success', 'Crédito registrado correctamente');
    }

    public function show(Credito $credito)
    {
        // Cargar relaciones para mostrar
        $credito->load(['cliente.persona', 'abonos']);

        return view('creditos.show', compact('credito'));
    }

    public function edit(Credito $credito)
    {
        $credito->load(['cliente.persona']);
        $clientes = Cliente::with('persona')->get();

        return view('creditos.edit', compact('credito', 'clientes'));
    }

    public function update(Request $request, Credito $credito)
    {
        $request->validate([
            'adeudo' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string|max:255'
        ]);

        // Si se reduce el adeudo, verificar que no sea menor al total abonado
        $totalAbonado = $credito->abonos()->sum('abono');
        if ($request->adeudo < $totalAbonado) {
            return back()->withErrors([
                'adeudo' => 'El adeudo no puede ser menor al total abonado ($' .
                    number_format($totalAbonado, 2) . ')'
            ])->withInput();
        }

        $credito->update([
            'adeudo' => $request->adeudo,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('creditos.index')
            ->with('success', 'Crédito actualizado correctamente');
    }

    public function destroy(Credito $credito)
    {
        // Verificar que no tenga abonos antes de eliminar
        if ($credito->abonos()->count() > 0) {
            return redirect()->route('creditos.index')
                ->with('error', 'No se puede eliminar un crédito que tiene abonos registrados');
        }

        $credito->delete();

        return redirect()->route('creditos.index')
            ->with('success', 'Crédito eliminado correctamente');
    }

    // Método para mostrar créditos activos
    public function activos()
    {
        $creditos = Credito::with(['cliente.persona', 'abonos'])
            ->activos() // Usando el scope del modelo
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('creditos.activos', compact('creditos'));
    }

    // Método para mostrar créditos de un cliente específico
    public function porCliente($clienteId)
    {
        $cliente = Cliente::with(['persona', 'creditos.abonos'])
            ->findOrFail($clienteId);

        $creditos = $cliente->creditos()->orderBy('created_at', 'desc')->get();

        return view('creditos.por-cliente', compact('cliente', 'creditos'));
    }

    // Método para registrar un abono desde el controlador de créditos
    public function registrarAbono(Request $request, Credito $credito)
    {
        $request->validate([
            'abono' => 'required|numeric|min:0.01|max:' . $credito->adeudo,
            'fecha_hora' => 'nullable|date'
        ]);

        // Crear el abono
        Abono::create([
            'credito_id' => $credito->id,
            'abono' => $request->abono,
            'fecha_hora' => $request->fecha_hora ?? now()
        ]);

        // Actualizar el adeudo del crédito
        $credito->decrement('adeudo', $request->abono);

        return redirect()->route('creditos.show', $credito)
            ->with('success', 'Abono registrado correctamente');
    }

    // Método para ver el historial de abonos de un crédito
    public function historialAbonos(Credito $credito)
    {
        $credito->load(['cliente.persona', 'abonos']);
        $abonos = $credito->abonos()->orderBy('fecha_hora', 'desc')->get();

        return view('creditos.historial-abonos', compact('credito', 'abonos'));
    }
}
