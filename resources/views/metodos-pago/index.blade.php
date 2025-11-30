@extends('layouts.app')

@section('title', 'Catálogo de Métodos de Pago')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-credit-card me-2"></i> Métodos de Pago Disponibles</span>
            <a href="{{ route('metodos-pago.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-plus"></i> Nuevo Método
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($metodosPago as $metodo)
                        <tr>
                            <td>{{ $metodo->id }}</td>
                            <td>
                                <strong>{{ $metodo->descripcion }}</strong>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('metodos-pago.edit', $metodo->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('metodos-pago.destroy', $metodo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este método de pago? Esto afectará los tickets históricos.');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4">
                                <i class="fas fa-money-check-alt fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay métodos de pago registrados. Añade al menos "Efectivo" y "Crédito".</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
