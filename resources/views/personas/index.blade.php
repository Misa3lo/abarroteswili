@extends("layouts.app")

@section("content")
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h2 text-primary fw-bold">
                        <i class="fas fa-address-book me-2"></i>Directorio de Personas
                    </h1>
                    <a href="{{ route('personas.create') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-1"></i> Nueva Persona
                    </a>
                </div>
                <hr class="border-primary opacity-50">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Listado General
                            </h5>
                            <form action="{{ route('personas.search') }}" method="GET" class="d-flex" style="max-width: 400px;">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Buscar por nombre o teléfono..." value="{{ request('search') }}">
                                    <button class="btn btn-light" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    @if(request('search'))
                                        <a href="{{ route('personas.index') }}" class="btn btn-danger" title="Limpiar búsqueda">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Roles</th>
                                    <th width="150">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($personas as $persona)
                                    <tr>
                                        <td class="fw-bold">{{ $persona->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-3">
                                                    {{ $persona->iniciales }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{ $persona->nombre }} {{ $persona->apaterno }}</h6>
                                                    <small class="text-muted">{{ $persona->amaterno }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($persona->telefono)
                                                <a href="tel:{{ $persona->telefono }}" class="text-decoration-none text-dark">
                                                    <i class="fas fa-phone-alt me-1 text-success"></i>
                                                    {{ $persona->telefono_formateado }}
                                                </a>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ Str::limit($persona->direccion, 30) ?? 'Sin dirección' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($persona->es_cliente)
                                                <span class="badge bg-info text-dark mb-1">Cliente</span>
                                            @endif
                                            @if($persona->es_usuario)
                                                <span class="badge bg-warning text-dark mb-1">Usuario ({{ $persona->rol }})</span>
                                            @endif
                                            @if(!$persona->es_cliente && !$persona->es_usuario)
                                                <span class="badge bg-secondary">Sin Rol</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('personas.show', $persona->id) }}"
                                                   class="btn btn-sm btn-info text-white rounded-circle p-2"
                                                   title="Ver Detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('personas.edit', $persona->id) }}"
                                                   class="btn btn-sm btn-primary rounded-circle p-2"
                                                   title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <form action="{{ route('personas.destroy', $persona->id) }}" method="post" class="d-inline">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger rounded-circle p-2"
                                                            title="Eliminar"
                                                            onclick="return confirm('¿Estás seguro? Si tiene relación con cliente o usuario no se eliminará.')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            No se encontraron personas registradas.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-end">
                            {{ $personas->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }
    </style>
@endsection
