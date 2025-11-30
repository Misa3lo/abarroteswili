@extends("layouts.app")

@section("content")
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h2 text-primary fw-bold">
                        <i class="fas fa-users me-2"></i>Gestión de Clientes
                    </h1>
                    <a href="{{ route('clientes.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-1"></i> Nuevo Cliente
                    </a>
                </div>
                <hr class="border-primary opacity-50">
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Listado de Clientes</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Contacto</th>
                            <th>Límite de Crédito</th>
                            <th>Estado de Adeudo</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td class="fw-bold">{{ $cliente->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            {{ substr($cliente->persona->nombre, 0, 1) }}{{ substr($cliente->persona->apaterno, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $cliente->persona->nombre }} {{ $cliente->persona->apaterno }}</h6>
                                            <small class="text-muted">{{ $cliente->persona->amaterno }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <i class="fas fa-phone me-1 text-success"></i> {{ $cliente->persona->telefono ?? 'N/A' }}<br>
                                        <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ Str::limit($cliente->persona->direccion, 20) ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">${{ number_format($cliente->limite_credito, 2) }}</span>
                                </td>
                                <td>
                                    @if($cliente->total_adeudado > 0)
                                        <span class="badge bg-danger">
                                            Adeuda: ${{ number_format($cliente->total_adeudado, 2) }}
                                        </span>
                                    @else
                                        <span class="badge bg-success">Al corriente</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('clientes.show', $cliente->id) }}" class="btn btn-sm btn-info text-white" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-sm btn-warning text-white" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este cliente?')" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">No hay clientes registrados.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light">
                {{ $clientes->links() }}
            </div>
        </div>
    </div>
@endsection
