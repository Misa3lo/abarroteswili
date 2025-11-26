<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Credito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AbonoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $abonos = Abono::with('credito.cliente.persona')
                ->recientes()
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $abonos
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los abonos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credito_id' => 'required|exists:creditos,id',
            'abono' => 'required|numeric|min:0.01|decimal:0,2',
            'fecha_hora' => 'nullable|date'
        ], [
            'credito_id.required' => 'El crédito es obligatorio',
            'credito_id.exists' => 'El crédito seleccionado no existe',
            'abono.required' => 'El monto del abono es obligatorio',
            'abono.numeric' => 'El abono debe ser un número válido',
            'abono.min' => 'El abono debe ser mayor a 0',
            'fecha_hora.date' => 'La fecha debe ser válida'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Obtener el crédito
            $credito = Credito::findOrFail($request->credito_id);

            // Validar que el abono no exceda el adeudo
            if ($request->abono > $credito->adeudo) {
                return response()->json([
                    'success' => false,
                    'message' => 'El abono no puede ser mayor al adeudo actual ($' . number_format($credito->adeudo, 2) . ')'
                ], 422);
            }

            // Crear el abono
            $abonoData = [
                'credito_id' => $request->credito_id,
                'abono' => $request->abono,
                'fecha_hora' => $request->fecha_hora ?? now()
            ];

            $abono = Abono::create($abonoData);

            // Actualizar el adeudo del crédito
            $nuevoAdeudo = $credito->adeudo - $request->abono;
            $credito->update(['adeudo' => $nuevoAdeudo]);

            DB::commit();

            // Cargar relaciones para la respuesta
            $abono->load('credito.cliente.persona');

            return response()->json([
                'success' => true,
                'message' => 'Abono registrado exitosamente',
                'data' => $abono,
                'adeudo_actual' => $nuevoAdeudo
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al registrar el abono: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $abono = Abono::with('credito.cliente.persona')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $abono
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Abono no encontrado'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $abono = Abono::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'abono' => 'sometimes|required|numeric|min:0.01|decimal:0,2',
            'fecha_hora' => 'sometimes|nullable|date'
        ], [
            'abono.required' => 'El monto del abono es obligatorio',
            'abono.numeric' => 'El abono debe ser un número válido',
            'abono.min' => 'El abono debe ser mayor a 0',
            'fecha_hora.date' => 'La fecha debe ser válida'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // Lógica compleja para actualizar abono (revertir y aplicar nuevo)
            // Por simplicidad, en una aplicación real necesitarías más validaciones

            $abono->update($request->only(['abono', 'fecha_hora']));

            DB::commit();

            $abono->load('credito.cliente.persona');

            return response()->json([
                'success' => true,
                'message' => 'Abono actualizado exitosamente',
                'data' => $abono
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el abono: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $abono = Abono::findOrFail($id);

            // Aquí deberías implementar lógica para revertir el abono al crédito
            // Por ahora solo hacemos soft delete
            $abono->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Abono eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el abono: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener abonos por crédito
     */
    public function porCredito($creditoId)
    {
        try {
            $abonos = Abono::with('credito.cliente.persona')
                ->porCredito($creditoId)
                ->recientes()
                ->get();

            $totalAbonado = $abonos->sum('abono');

            return response()->json([
                'success' => true,
                'data' => $abonos,
                'total_abonado' => $totalAbonado
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los abonos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener abonos por rango de fechas
     */
    public function porFechas(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $abonos = Abono::with('credito.cliente.persona')
                ->entreFechas($request->fecha_inicio, $request->fecha_fin)
                ->recientes()
                ->paginate(10);

            $totalPeriodo = $abonos->sum('abono');

            return response()->json([
                'success' => true,
                'data' => $abonos,
                'total_periodo' => $totalPeriodo,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los abonos: ' . $e->getMessage()
            ], 500);
        }
    }
}
