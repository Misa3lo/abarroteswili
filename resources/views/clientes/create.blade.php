@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Cliente</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('clientes.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <h5 class="text-success mb-3 border-bottom pb-2"><i class="fas fa-search me-2"></i>Seleccionar Persona Existente</h5>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <label for="persona_id" class="form-label fw-bold">Persona a Registrar como Cliente <span class="text-danger">*</span></label>

                                    @if($personas->isEmpty())
                                        <div class="alert alert-warning d-flex align-items-center" role="alert">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <div>
                                                No hay personas disponibles para registrar como clientes.
                                                <a href="{{ route('personas.create') }}" class="alert-link fw-bold">Regístrela aquí primero.</a>
                                            </div>
                                        </div>
                                        <input type="hidden" name="persona_id" value="">
                                    @else
                                        <select class="form-select @error('persona_id') is-invalid @enderror"
                                                name="persona_id" id="persona_id" required>
                                            <option value="" disabled selected>-- Seleccione una Persona --</option>
                                            @foreach($personas as $persona)
                                                <option value="{{ $persona->id }}"
                                                    {{ old('persona_id') == $persona->id ? 'selected' : '' }}>
                                                    {{ $persona->nombre_completo }} (Tel: {{ $persona->telefono ?? 'N/A' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('persona_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    @endif
                                </div>
                            </div>

                            <h5 class="text-success mb-3 border-bottom pb-2 mt-4"><i class="fas fa-wallet me-2"></i>Configuración de Crédito</h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="limite_credito" class="form-label fw-bold">Límite de Crédito ($) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" min="0" class="form-control @error('limite_credito') is-invalid @enderror"
                                               name="limite_credito" value="{{ old('limite_credito', 0) }}" required>
                                    </div>
                                    <small class="text-muted">Monto máximo que puede adeudar el cliente.</small>
                                    @error('limite_credito') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('clientes.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Cancelar</a>
                                <button type="submit" class="btn btn-success" {{ $personas->isEmpty() ? 'disabled' : '' }}>
                                    <i class="fas fa-save me-2"></i>Asignar Rol de Cliente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
