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
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">Registrar Abono</div>
            <div class="card-body">

                {{-- Mensaje de éxito/error --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($credito->estado !== 'Pagado')
                    <form action="{{ route('creditos.storeAbono', $credito) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="abono" class="form-label">Monto del Abono</label>
                            <input type="number"
                                   class="form-control @error('abono') is-invalid @enderror"
                                   id="abono"
                                   name="abono"
                                   min="0.01"
                                   step="0.01"
                                   placeholder="Ej: 50.00"
                                   required>
                            @error('abono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-money-bill-wave me-1"></i> Confirmar Abono
                        </button>
                    </form>
                @else
                    <div class="alert alert-info text-center">
                        Este crédito ya ha sido **Pagado** en su totalidad.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
