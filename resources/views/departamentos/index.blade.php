@extends('layouts.app')

@section('title', 'Departamentos')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-tags me-2"></i> Gestión de Departamentos</span>
            <a href="{{ route('departamentos.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-plus"></i> Nuevo Departamento
            </a>
        </div>
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($departamentos as $depto)
                        <tr>
                            <td>{{ $depto->id }}</td>
                            <td>
                                <strong>{{ $depto->nombre }}</strong>
                            </td>
                            <td>{{ $depto->descripcion }}</td>
                            <td class="text-end">
                                <a href="{{ route('departamentos.edit', $depto->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('departamentos.destroy', $depto->id) }}" method="POST" class="d-inline on-delete-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este departamento?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay departamentos registrados aún.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
