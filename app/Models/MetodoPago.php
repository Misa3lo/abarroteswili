<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
=======
use App\Models\MetodoPago;
use Illuminate\Http\Request;
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc

class MetodoPagoController extends Controller
{
<<<<<<< HEAD
    protected $table = 'metodo_pago';
    protected $primaryKey = 'id';
    protected $fillable = ['descripcion'];
    public $timestamps = false;

    // No usar SoftDeletes si la tabla no tiene deleted_at
=======
    public function index()
    {
        $metodosPago = MetodoPago::withCount('tickets')
            ->withSum('tickets', 'total')
            ->orderBy('descripcion')
            ->paginate(10);

        return view('metodos-pago.index', compact('metodosPago'));
    }

    public function create()
    {
        return view('metodos-pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion'
        ]);

        MetodoPago::create([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')
            ->with('success', 'Método de pago creado correctamente');
    }

    public function show(MetodoPago $metodoPago)
    {
        $metodoPago->load(['tickets' => function($query) {
            $query->orderBy('fecha_hora', 'desc')->limit(20);
        }, 'tickets.cliente.persona', 'tickets.usuario.persona']);

        $estadisticas = $metodoPago->estadisticas_uso;

        return view('metodos-pago.show', compact('metodoPago', 'estadisticas'));
    }

    public function edit(MetodoPago $metodoPago)
    {
        return view('metodos-pago.edit', compact('metodoPago'));
    }

    public function update(Request $request, MetodoPago $metodoPago)
    {
        $request->validate([
            'descripcion' => 'required|string|max:50|unique:metodo_pago,descripcion,' . $metodoPago->id
        ]);

        $metodoPago->update([
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('metodos-pago.index')
            ->with('success', 'Método de pago actualizado correctamente');
    }

    public function destroy(MetodoPago $metodoPago)
    {
        // No permitir eliminar métodos de pago por defecto
        if ($metodoPago->es_efectivo || $metodoPago->es_credito) {
            return redirect()->route('metodos-pago.index')
                ->with('error', 'No se puede eliminar un método de pago del sistema');
        }

        // Verificar que no tenga tickets asociados
        if ($metodoPago->tickets()->count() > 0) {
            return redirect()->route('metodos-pago.index')
                ->with('error', 'No se puede eliminar el método de pago porque tiene tickets asociados');
        }

        $metodoPago->delete();

        return redirect()->route('metodos-pago.index')
            ->with('success', 'Método de pago eliminado correctamente');
    }

    // Método para buscar métodos de pago
    public function search(Request $request)
    {
        $search = $request->get('search');

        $metodosPago = MetodoPago::withCount('tickets')
            ->withSum('tickets', 'total')
            ->porDescripcion($search)
            ->orderBy('descripcion')
            ->paginate(10);

        return view('metodos-pago.index', compact('metodosPago', 'search'));
    }

    // Método para estadísticas de métodos de pago
    public function estadisticas()
    {
        $metodosPago = MetodoPago::withCount('tickets')
            ->withSum('tickets', 'total')
            ->orderBy('tickets_sum_total', 'desc')
            ->get();

        $totalTickets = $metodosPago->sum('tickets_count');
        $totalVendido = $metodosPago->sum('tickets_sum_total');

        return view('metodos-pago.estadisticas', compact('metodosPago', 'totalTickets', 'totalVendido'));
    }

    // Método para reporte de uso por fechas
    public function reporteUso(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', now()->subDays(30)->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', now()->format('Y-m-d'));

        $metodosPago = MetodoPago::withCount(['tickets' => function($query) use ($fechaInicio, $fechaFin) {
            $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
        }])
            ->withSum(['tickets' => function($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
            }], 'total')
            ->orderBy('tickets_sum_total', 'desc')
            ->get();

        $totalTicketsPeriodo = $metodosPago->sum('tickets_count');
        $totalVendidoPeriodo = $metodosPago->sum('tickets_sum_total');

        return view('metodos-pago.reporte-uso', compact(
            'metodosPago',
            'totalTicketsPeriodo',
            'totalVendidoPeriodo',
            'fechaInicio',
            'fechaFin'
        ));
    }

    // Método para API (si necesitas JSON)
    public function apiIndex()
    {
        $metodosPago = MetodoPago::select('id', 'descripcion')
            ->activos()
            ->orderBy('descripcion')
            ->get();

        return response()->json($metodosPago);
    }

    // Método para obtener método de pago por ID (API)
    public function apiShow($id)
    {
        $metodoPago = MetodoPago::find($id);

        if (!$metodoPago) {
            return response()->json(['error' => 'Método de pago no encontrado'], 404);
        }

        return response()->json($metodoPago);
    }
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
}
