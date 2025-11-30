@extends('layouts.app')

@section('title', 'Editar Método de Pago')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark">
            <i class="fas fa-edit me-2"></i> Editando Método: **{{ $metodoPago->descripcion }}**
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

            <form action="{{ route('metodos-pago.update', $metodoPago->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Método <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control"
                           id="descripcion"
                           name="descripcion"
                           value="{{ old('descripcion', $metodoPago->descripcion) }}"
                           required>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('metodos-pago.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning text-dark fw-bold">
                        <i class="fas fa-sync-alt"></i> Actualizar Método
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
