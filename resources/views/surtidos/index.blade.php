@extends('layouts.app')

@section('title', 'Historial de Surtidos')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-truck-loading me-2"></i> Historial de Entrada de Mercancía</span>
            <a href="{{ route('surtidos.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-plus"></i> Registrar Nuevo Surtido
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Cantidad Surtida</th>
                        <th>Costo de Entrada</th>
                        <th>Fecha y Hora</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($surtidos as $surtido)
                        <tr>
                            <td>{{ $surtido->id }}</td>
                            <td>
                                <strong>{{ $surtido->producto->codigo_barras ?? 'Producto Desconocido' }}</strong>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $surtido->cantidad }} unidades</span>
                            </td>
                            <td>$ {{ number_format($surtido->precio_entrada, 2) }}</td>
                            <td>
                                {{ $surtido->created_at ? $surtido->created_at->format('d/m/Y H:i') : 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay registros de surtidos aún.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
