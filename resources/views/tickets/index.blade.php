@extends('layouts.app')

@section('title', 'Historial de Ventas')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Listado de Tickets</h5>
        </div>
        <div class="card-body">

            {{-- Mensajes de Session --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Método Pago</th>
                        <th>Total</th>
                        <th>Atendido por</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->folio }}</td>

                            {{-- ✅ CORRECCIÓN: Usar fecha_hora para formatear --}}
                            <td>{{ $ticket->fecha_hora->format('d/M/Y H:i') }}</td>

                            <td>
                                {{-- Manejo seguro del cliente (puede ser null, aunque en tu caso ID 13 es fijo) --}}
                                @if ($ticket->cliente && $ticket->cliente->persona)
                                    {{ $ticket->cliente->persona->nombre }} {{ $ticket->cliente->persona->apaterno }}
                                @else
                                    Público General
                                @endif
                            </td>
                            <td>
                                {{-- Manejo seguro del método de pago --}}
                                {{ $ticket->metodoPago->descripcion ?? 'N/A' }}
                            </td>
                            <td class="fw-bold">${{ number_format($ticket->total, 2) }}</td>
                            <td>
                                {{-- Manejo seguro del usuario --}}
                                {{ $ticket->usuario->usuario ?? 'Usuario Desconocido' }}
                            </td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-info text-white me-2" title="Ver Detalle">
                                    <i class="fas fa-eye"></i>
                                </a>
                                {{-- Si tienes función de imprimir, la pones aquí --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No se encontraron tickets de venta.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
