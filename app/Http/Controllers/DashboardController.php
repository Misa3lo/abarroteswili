<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Ticket;
use App\Models\Producto;
use App\Models\Credito;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Muestra el resumen de métricas clave (Dashboard).
     */
    public function index()
    {
        // 1. Definir el periodo (Hoy)
        $hoy = Carbon::today();

        // 2. Métricas de Ventas de Hoy
        // Usamos 'fecha_hora' (corregido previamente)
        $ticketsDeHoy = Ticket::whereDate('fecha_hora', $hoy)->get();

        // La columna para el total es 'total' [cite: 70]
        $ventasHoy = $ticketsDeHoy->sum('total');
        $numTicketsHoy = $ticketsDeHoy->count();

        // 3. Métricas de Deudas (Créditos)
        $adeudoTotalPendiente = Credito::where('adeudo', '>', 0)->sum('adeudo');
        $creditosPendientes = Credito::where('adeudo', '>', 0)->count();

        // 4. Métricas de Inventario (Bajo Stock)
        // CORRECCIÓN: 'stock_minimo' NO EXISTE en la tabla 'productos'.
        // Usamos un valor fijo de 5 como umbral para 'Bajo Stock' (temporalmente).
        $productosBajoStock = Producto::where('existencias', '>', 0)
            ->where('existencias', '<=', 5)
            ->count();

        // 5. Productos Agotados
        // La columna de stock se llama 'existencias'
        $productosAgotados = Producto::where('existencias', 0)->count();

        $data = [
            'ventasHoy' => $ventasHoy,
            'numTicketsHoy' => $numTicketsHoy,
            'adeudoTotalPendiente' => $adeudoTotalPendiente,
            'creditosPendientes' => $creditosPendientes,
            'productosBajoStock' => $productosBajoStock,
            'productosAgotados' => $productosAgotados,
        ];

        return view('dashboard.index', compact('data'));
    }
}
