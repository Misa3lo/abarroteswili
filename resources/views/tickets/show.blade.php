@extends('layouts.app')

@section('title', 'Ticket de Venta #' . $ticket->id)

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-receipt me-2"></i> Ticket de Venta</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5 class="mb-0">ABARROTES WILI</h5>
                        <p class="mb-0">¡Gracias por tu compra!</p>
                    </div>

                    <p><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
                    <p><strong>Fecha/Hora:</strong> {{ $ticket->fecha_hora->format('d/m/Y H:i:s') }}</p>
                    <p><strong>Atendido por:</strong> Usuario ID #{{ $ticket->usuario_id }}</p>
                    <p><strong>Cliente:</strong> {{ $ticket->cliente->persona->nombre ?? 'Público General' }}</p>
                    <p><strong>Método de Pago:</strong> {{ $ticket->metodoPago->descripcion }}</p>

                    <hr>
                    <h6 class="fw-bold">Detalle de Productos</h6>
                    <table class="table table-sm table-borderless">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cant.</th>
                            <th class="text-end">Precio Unit.</th>
                            <th class="text-end">Importe</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ticket->ventas as $venta)
                            <tr>
                                <td>{{ $venta->producto->codigo_barras ?? 'Producto Eliminado' }}</td>
                                <td class="text-center">{{ $venta->cantidad }}</td>
                                <td class="text-end">$ {{ number_format($venta->precio_unitario, 2) }}</td>
                                <td class="text-end">$ {{ number_format($venta->cantidad * $venta->precio_unitario, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h4 class="text-end text-success">TOTAL: $ {{ number_format($ticket->total, 2) }}</h4>

                    @if($ticket->metodoPago->descripcion === 'Crédito')
                        <div class="alert alert-info text-center fw-bold mt-3">
                            Venta registrada como **CRÉDITO** por el total de ${{ number_format($ticket->total, 2) }}.
                        </div>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('puntoDeVenta') }}" class="btn btn-primary">
                            <i class="fas fa-cash-register me-2"></i> Nueva Venta
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
