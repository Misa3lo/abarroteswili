@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="card shadow-sm col-md-10 mx-auto">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Persona</h4>
            </div>
            <div class="card-body p-4">
                <form method="post" action="{{ route('personas.update', $persona->id) }}" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <label for="nombre" class="form-label fw-bold">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   name="nombre" id="nombre" value="{{ old('nombre', $persona->nombre) }}" required maxlength="100">
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="apaterno" class="form-label fw-bold">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('apaterno') is-invalid @enderror"
                                   name="apaterno" id="apaterno" value="{{ old('apaterno', $persona->apaterno) }}" required maxlength="100">
                            @error('apaterno')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="amaterno" class="form-label fw-bold">Apellido Materno</label>
                            <input type="text" class="form-control @error('amaterno') is-invalid @enderror"
                                   name="amaterno" id="amaterno" value="{{ old('amaterno', $persona->amaterno) }}" maxlength="100">
                            @error('amaterno')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <label for="telefono" class="form-label fw-bold">Teléfono / Celular</label>
                            <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                                   name="telefono" id="telefono" value="{{ old('telefono', $persona->telefono) }}" maxlength="15">
                            @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="direccion" class="form-label fw-bold">Dirección Completa</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                   name="direccion" id="direccion" value="{{ old('direccion', $persona->direccion) }}" maxlength="255">
                            @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Actualizar Datos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
