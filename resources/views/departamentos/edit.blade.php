@extends('layouts.app')

@section('title', 'Editar Departamento')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-edit me-2"></i> Editar Departamento: **{{ $departamento->nombre }}**
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('departamentos.update', $departamento->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Departamento <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control @error('nombre') is-invalid @enderror"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre', $departamento->nombre) }}"
                           required>
                    @error('nombre')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror"
                              id="descripcion"
                              name="descripcion"
                              rows="3">{{ old('descripcion', $departamento->descripcion) }}</textarea>
                    @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('departamentos.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">
                        <i class="fas fa-sync-alt"></i> Actualizar Departamento
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
