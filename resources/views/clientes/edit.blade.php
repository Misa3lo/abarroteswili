@extends("layouts.app")
@section("content")
    <div class="container-fluid py-4">
        <!-- Encabezado -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ url('/clientes') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                    <h1 class="h2 text-primary fw-bold">
                        <i class="fas fa-user-edit me-2"></i>Editar Cliente
                    </h1>
                    <div></div> <!-- Espacio para alinear -->
                </div>
                <hr class="border-primary opacity-50">
            </div>
        </div>

        <!-- Formulario -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">
                            <i class="fas fa-user-circle me-2"></i>Editar Información del Cliente
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{route('clientes.update', $cliente->id)}}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$cliente->persona->nombre}}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="apaterno" class="form-label">Apellido Paterno *</label>
                                    <input type="text" class="form-control" id="apaterno" name="apaterno" value="{{$cliente->persona->apaterno}}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="amaterno" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control" id="amaterno" name="amaterno" value="{{$cliente->persona->amaterno}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" value="{{$cliente->persona->telefono}}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="limite_credito" class="form-label">Límite de Crédito *</label>
                                    <input type="number" class="form-control" id="limite_credito" name="limite_credito" step="0.01" min="0" value="{{$cliente->limite_credito}}" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <textarea class="form-control" id="direccion" name="direccion" rows="3">{{$cliente->persona->direccion}}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{route('clientes.index')}}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Actualizar Cliente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
