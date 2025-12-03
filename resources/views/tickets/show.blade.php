@extends('layouts.app')

@section('title', 'Detalle de Ticket #' . $ticket->folio)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-receipt me-2"></i> Detalle de Venta - Folio: **{{ $ticket->folio }}**
                    </h4>
                </div>
                <div class="card-body">

                    <div class="row mb-4 border-bottom pb-3">
                        <div class="col-md-4">
                            <strong>Fecha y Hora:</strong> <br>
                            {{-- CORRECCIÓN AQUI: Usamos fecha_hora --}}
                            {{ $ticket->fecha_hora->format('d/M/Y H:i:s') }}
                        </div>
                        <div class="col-md-4">
                            <strong>Cliente:</strong> <br>
                            @if($ticket->cliente)
                                {{ $ticket->cliente->persona->nombre }} {{ $ticket->cliente->persona->apaterno }}
                            @else
                                Público General
                            @endif
                        </div>
                        <div class="col-md-4">
                            <strong>Atendido por:</strong> <br>
                            {{ $ticket->usuario->name ?? $ticket->usuario->usuario }}
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <strong>Método de Pago:</strong> <br>
                            <span class="badge bg-primary fs-6">{{ $ticket->metodoPago->descripcion }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong>Total de la Venta:</strong> <br>
                            <h3 class="text-success">$ {{ number_format($ticket->total, 2) }}</h3>
                        </div>
                        @if($ticket->metodoPago->descripcion === 'Crédito')
                            <div class="col-md-4">
                                <span class="badge bg-warning text-dark fs-6">Venta a Crédito</span>
                            </div>
                        @endif
                    </div>

                    <h5 class="mt-4"><i class="fas fa-boxes me-1"></i> Productos Vendidos</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                            <tr>
                                <th>Cód. Barras</th>
                                <th>Descripción</th>
                                <th class="text-center">Cant.</th>
                                <th class="text-end">P. Unitario</th> {{-- Nueva Columna --}}
                                <th class="text-end">Subtotal</th>    {{-- Nueva Columna --}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ticket->ventas as $venta)
                                <tr>
                                    <td>{{ $venta->producto->codigo_barras ?? 'N/A' }}</td>
                                    <td>{{ $venta->producto->descripcion ?? 'Producto sin descripción' }}</td>
                                    <td class="text-center">{{ $venta->cantidad }}</td>

                                    {{-- Precio Unitario (Guardado en la tabla ventas como 'precio') --}}
                                    <td class="text-end">
                                        $ {{ number_format($venta->precio, 2) }}
                                    </td>

                                    {{-- Cálculo del Subtotal (Cantidad * Precio) --}}
                                    <td class="text-end fw-bold">
                                        $ {{ number_format($venta->cantidad * $venta->precio, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold fs-5">TOTAL PAGADO:</td>
                                <td class="text-end fw-bold fs-5 text-success">
                                    $ {{ number_format($ticket->total, 2) }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-end mt-4">
                        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                        {{-- Botón opcional para imprimir --}}
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print"></i> Imprimir Ticket
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
