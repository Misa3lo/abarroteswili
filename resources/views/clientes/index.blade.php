@extends('layouts.app')

@section('title', 'Gestión de Clientes')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users me-2"></i> Listado de Clientes</span>
            <a href="{{ route('clientes.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-user-plus"></i> Nuevo Cliente
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Límite de Crédito</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->id }}</td>
                            <td>
                                <strong>{{ $cliente->persona->nombre }} {{ $cliente->persona->apaterno }}</strong>
                                ({{ $cliente->persona->amaterno }})
                            </td>
                            <td>{{ $cliente->persona->telefono ?? 'N/A' }}</td>
                            <td>{{ $cliente->persona->direccion ?? 'Sin especificar' }}</td>
                            <td>$ {{ number_format($cliente->limite_credito, 2) }}</td>
                            <td class="text-end">
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('ATENCIÓN: Se eliminarán los datos de la persona asociada. ¿Estás seguro?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-user-times fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay clientes registrados aún.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
