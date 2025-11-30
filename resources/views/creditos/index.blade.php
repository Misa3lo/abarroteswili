@extends('layouts.app')

@section('title', 'Cuentas por Cobrar (Créditos)')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
            <i class="fas fa-hand-holding-usd me-2"></i> Créditos Pendientes
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($clientesConDeuda->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-check-circle me-2"></i> ¡No hay créditos pendientes de cobro!
                </div>
            @else
                <p class="text-muted">A continuación se muestra el saldo total pendiente por cada cliente.</p>
                <div class="accordion" id="accordionDeudas">
                    @foreach($clientesConDeuda as $clientData)
                        @php
                            $cliente = $clientData['cliente'];
                            $totalDeuda = $clientData['saldo_total'];
                            $collapseId = 'collapse-' . $cliente->id;
                        @endphp
                        <div class="accordion-item mb-3 shadow-sm">
                            <h2 class="accordion-header" id="heading{{ $cliente->id }}">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    <i class="fas fa-user-circle me-2"></i>
                                    {{ $cliente->persona->nombre }} {{ $cliente->persona->apaterno }}
                                    <span class="badge bg-danger ms-3 fs-6">TOTAL ADEUDADO: ${{ number_format($totalDeuda, 2) }}</span>
                                </button>
                            </h2>
                            <div id="{{ $collapseId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $cliente->id }}" data-bs-parent="#accordionDeudas">
                                <div class="accordion-body">
                                    <h6 class="border-bottom pb-2 text-primary">Créditos Individuales Pendientes:</h6>
                                    <ul class="list-group">
                                        @foreach($clientData['creditos_pendientes'] as $credito)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-receipt me-1"></i>
                                                    {{-- CORRECCIÓN: Verifica si ticket_id no es nulo --}}
                                                    @if($credito->ticket_id)
                                                        Ticket #{{ $credito->ticket_id }}
                                                    @else
                                                        Crédito #{{ $credito->id }}
                                                    @endif

                                                    <small class="text-muted">({{ $credito->created_at->format('d/m/Y') }})</small>
                                                </div>
                                                {{-- Muestra el adeudo --}}
                                                <span class="fw-bold text-danger me-3">${{ number_format($credito->adeudo, 2) }}</span>
                                                <a href="{{ route('creditos.show', $credito->id) }}" class="btn btn-sm btn-info text-white">
                                                    <i class="fas fa-eye me-1"></i> Ver / Abonar
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
