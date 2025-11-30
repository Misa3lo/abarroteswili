@extends('layouts.app')

@section('title', 'Crear Método de Pago')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="fas fa-plus me-2"></i> Registrar Nuevo Método de Pago
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

            <form action="{{ route('metodos-pago.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción del Método <span class="text-danger">*</span></label>
                    <input type="text"
                           class="form-control"
                           id="descripcion"
                           name="descripcion"
                           value="{{ old('descripcion') }}"
                           placeholder="Ej: Efectivo, Tarjeta de Crédito, Crédito, Vales"
                           required>
                    <div class="form-text">Máximo 50 caracteres. Ej: Efectivo, Crédito.</div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('metodos-pago.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-save"></i> Guardar Método
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
