<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AbonoController;

// Grupo de rutas API con prefijo y middleware
Route::middleware(['api'])->prefix('v1')->group(function () {

    // Rutas para Clientes
    Route::apiResource('clientes', ClienteController::class);
    Route::get('clientes/{id}/historial-compras', [ClienteController::class, 'historialCompras']);
    Route::get('clientes/{id}/estado-credito', [ClienteController::class, 'estadoCredito']);
    Route::get('clientes/buscar/autocomplete', [ClienteController::class, 'buscar']);

    // Rutas para Abonos
    Route::apiResource('abonos', AbonoController::class);
    Route::get('abonos/credito/{creditoId}', [AbonoController::class, 'porCredito']);
    Route::post('abonos/por-fechas', [AbonoController::class, 'porFechas']);

    // Rutas para otros modelos (las agregaremos según los vayamos creando)
    // Route::apiResource('creditos', CreditoController::class);
    // Route::apiResource('productos', ProductoController::class);
    // Route::apiResource('usuarios', UsuarioController::class);
    // etc...
});
