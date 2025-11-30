@extends('layouts.app')

@section('title', 'Dashboard - Resumen Diario')

@section('content')
    <h1 class="mb-4 text-primary">Resumen del Día ({{ now()->format('d/m/Y') }})</h1>

    <div class="row">

        {{-- Tarjeta 1: Ventas del Día --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Ventas de Hoy
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($data['ventasHoy'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 2: Tickets del Día --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Tickets Emitidos
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($data['numTicketsHoy']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 3: Deuda Pendiente Total --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Deuda por Cobrar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($data['adeudoTotalPendiente'], 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tarjeta 4: Productos Agotados --}}
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card shadow-sm border-left-danger h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Productos Agotados
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($data['productosAgotados']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- FILA DE NOTIFICACIONES DE INVENTARIO --}}
    <div class="row mt-3">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i> Alertas de Stock
                </div>
                <div class="card-body">
                    <p>Necesitas atención inmediata en las siguientes áreas:</p>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Productos Agotados (Stock = 0):
                            <span class="badge bg-danger rounded-pill">{{ number_format($data['productosAgotados']) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Productos Bajo Mínimo de Stock:
                            <span class="badge bg-warning text-dark rounded-pill">{{ number_format($data['productosBajoStock']) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Clientes con Crédito Pendiente:
                            <span class="badge bg-info rounded-pill">{{ number_format($data['creditosPendientes']) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Espacio para Gráficas o Noticias --}}
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-light text-dark">
                    <i class="fas fa-chart-bar me-2"></i> Gráfico de Ventas (Placeholder)
                </div>
                <div class="card-body text-center py-5">
                    <p class="text-muted">Aquí se mostraría la gráfica de ventas semanales o mensuales.</p>

                </div>
            </div>
        </div>
    </div>
@endsection
