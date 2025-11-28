@extends("layouts.app")
@section("content")
    <div class="container-fluid py-4">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                    <h1 class="h2 text-primary fw-bold">
                        <i class="fas fa-users me-2"></i>Gestión de Clientes
                    </h1>
                    <a href="{{url('clientes/create')}}" class="btn btn-success">
                        <i class="fas fa-plus-circle me-1"></i> Nuevo Cliente
                    </a>
                </div>
                <hr class="border-primary opacity-50">
            </div>
        </div>

        <!-- Tarjeta de Listado -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-list me-2"></i>Listado de Clientes
                            </h5>
                            <div class="input-group" style="width: 300px;">
                                <input type="text" class="form-control" placeholder="Buscar cliente...">
                                <button class="btn btn-light" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Cliente</th>
                                    <th>Contacto</th>
                                    <th>Dirección</th>
                                    <th>Límite Crédito</th>
                                    <th>Estado</th>
                                    <th width="150">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($clientes as $cliente)
                                    <tr>
                                        <td class="fw-bold">{{$cliente->id}}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-3">
                                                    {{ substr($cliente->persona->nombre, 0, 1) }}{{ substr($cliente->persona->apaterno, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">{{$cliente->persona->nombre}} {{$cliente->persona->apaterno}} {{$cliente->persona->amaterno}}</h6>
                                                    <small class="text-muted">Cliente desde: {{$cliente->created_at->format('d/m/Y')}}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div><i class="fas fa-phone me-2 text-primary"></i>{{$cliente->persona->telefono ?? 'N/A'}}</div>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{$cliente->persona->direccion ?? 'Sin dirección'}}</small>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success">${{number_format($cliente->limite_credito, 2)}}</span>
                                        </td>
                                        <td>
                                            @if($cliente->creditos->where('adeudo', '>', 0)->count() > 0)
                                                <span class="badge bg-warning">Con Crédito</span>
                                            @else
                                                <span class="badge bg-success">Al Corriente</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{route('clientes.edit', $cliente->id)}}"
                                                   class="btn btn-sm btn-primary rounded-circle p-2"
                                                   data-bs-toggle="tooltip"
                                                   title="Editar">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <form action="{{route('clientes.destroy', $cliente->id)}}" method="post" class="d-inline">
                                                    @csrf
                                                    @method("DELETE")
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger rounded-circle p-2"
                                                            data-bs-toggle="tooltip"
                                                            title="Eliminar"
                                                            onclick="return confirm('¿Estás seguro de eliminar este cliente?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Mostrando {{$clientes->count()}} clientes
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
@endsection
