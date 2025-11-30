@extends('layouts.app')

@section('title', 'Detalle de Crédito #' . $credito->id)

@section('content')
    <div class="row">
        {{-- Columna 1: Detalle del Crédito y Abonos --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <i class="fas fa-info-circle me-2"></i> Detalle de Crédito #{{ $credito->id }}
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <h4 class="text-primary border-bottom pb-2">Cliente: {{ $credito->cliente->persona->nombre }} {{ $credito->cliente->persona->apaterno }}</h4>
                    <p><strong>Monto Original:</strong> ${{ number_format($credito->monto_original, 2) }}</p>
                    <p><strong>Fecha de Deuda:</strong> {{ $credito->created_at->format('d/m/Y H:i') }}</p>

                    {{-- CORRECCIÓN PARA EL ERROR: Verificar si ticket_id existe antes de generar la URL --}}
                    @if($credito->ticket_id)
                        <p><strong>Ticket Asociado:</strong> <a href="{{ route('tickets.show', $credito->ticket_id) }}">#{{ $credito->ticket_id }}</a></p>
                    @else
                        <p class="text-muted"><strong>Ticket Asociado:</strong> No disponible (Crédito antiguo).</p>
                    @endif
                    {{-- FIN DE LA CORRECCIÓN --}}

                    <hr>
                    <div class="alert alert-danger text-center fw-bold fs-3">
                        SALDO PENDIENTE: ${{ number_format($credito->adeudo, 2) }}
                    </div>

                    <h5 class="mt-4 border-bottom pb-2">Historial de Abonos</h5>
                    @if($credito->abonos->isEmpty())
                        <p class="text-muted">Aún no se han registrado abonos a este crédito.</p>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($credito->abonos->sortBy('fecha_hora') as $abono)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span><i class="fas fa-calendar-alt me-2"></i> {{ $abono->fecha_hora->format('d/m/Y H:i') }}</span>
                                    <span class="fw-bold text-success">+ ${{ number_format($abono->abono, 2) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    @if($credito->adeudo <= 0.01)
                        <div class="alert alert-success mt-4 fw-bold text-center">
                            <i class="fas fa-thumbs-up me-2"></i> ¡Crédito liquidado!
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna 2: Formulario de Abono --}}
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-money-check-alt me-2"></i> Registrar Abono
                </div>
                <div class="card-body">
                    @if($credito->adeudo > 0)
                        <form action="{{ route('creditos.storeAbono', $credito->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="monto_abono" class="form-label fw-bold">Monto a Abonar</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0.01"
                                           max="{{ number_format($credito->adeudo, 2, '.', '') }}"
                                           class="form-control @error('monto_abono') is-invalid @enderror"
                                           id="monto_abono" name="monto_abono"
                                           value="{{ old('monto_abono', number_format($credito->adeudo, 2, '.', '')) }}" required autofocus>
                                    @error('monto_abono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="form-text text-muted">Máximo: ${{ number_format($credito->adeudo, 2) }}</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success py-2 fw-bold">
                                    <i class="fas fa-check"></i> Registrar Pago
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- Muestra que el crédito está liquidado --}}
                        <div class="alert alert-secondary text-center">Este crédito ya fue liquidado.</div>
                    @endif
                </div>
            </div>
            <div class="d-grid mt-3">
                <a href="{{ route('creditos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Volver a Créditos
                </a>
            </div>
        </div>
    </div>
@endsection
