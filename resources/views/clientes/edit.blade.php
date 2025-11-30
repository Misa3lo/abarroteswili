@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Cliente</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('clientes.update', $cliente->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <h5 class="text-warning mb-3 border-bottom pb-2"><i class="fas fa-address-card me-2"></i>Datos Personales</h5>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="nombre" class="form-label fw-bold">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre', $cliente->persona->nombre) }}" required>
                                    @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="apaterno" class="form-label fw-bold">Apellido Paterno <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('apaterno') is-invalid @enderror" name="apaterno" value="{{ old('apaterno', $cliente->persona->apaterno) }}" required>
                                    @error('apaterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="amaterno" class="form-label fw-bold">Apellido Materno</label>
                                    <input type="text" class="form-control @error('amaterno') is-invalid @enderror" name="amaterno" value="{{ old('amaterno', $cliente->persona->amaterno) }}">
                                    @error('amaterno') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label fw-bold">Teléfono</label>
                                    <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono', $cliente->persona->telefono) }}">
                                    @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="direccion" class="form-label fw-bold">Dirección</label>
                                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="{{ old('direccion', $cliente->persona->direccion) }}">
                                    @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <h5 class="text-warning mb-3 border-bottom pb-2 mt-4"><i class="fas fa-wallet me-2"></i>Configuración de Crédito</h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="limite_credito" class="form-label fw-bold">Límite de Crédito ($) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('limite_credito') is-invalid @enderror" name="limite_credito" value="{{ old('limite_credito', $cliente->limite_credito) }}" required>
                                    </div>
                                    @error('limite_credito') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-2"></i>Actualizar Cliente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
