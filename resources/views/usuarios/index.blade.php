@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-user-tie me-2"></i> Listado de Usuarios (Empleados)</span>
            <a href="{{ route('usuarios.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Usuario (Login)</th>
                        <th>Rol</th>
                        <th>Teléfono</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>
                                <strong>{{ $usuario->persona->nombre }} {{ $usuario->persona->apaterno }}</strong>
                            </td>
                            <td>{{ $usuario->usuario }}</td>
                            <td>
                                @if($usuario->rol == 'administrador')
                                    <span class="badge bg-danger"><i class="fas fa-crown"></i> Administrador</span>
                                @else
                                    <span class="badge bg-success"><i class="fas fa-briefcase"></i> Empleado</span>
                                @endif
                            </td>
                            <td>{{ $usuario->persona->telefono ?? 'N/A' }}</td>
                            <td class="text-end">
                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('ATENCIÓN: Se eliminará al usuario y sus datos personales. ¿Estás seguro?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay usuarios registrados en el sistema.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
