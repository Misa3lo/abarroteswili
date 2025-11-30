@extends('layouts.app')

@section('title', 'Registrar Cliente')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="fas fa-user-plus me-2"></i> Formulario de Registro de Cliente
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

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf

                <h5 class="mb-3 text-primary"><i class="fas fa-info-circle"></i> Datos Personales</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nombre" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="apaterno" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="apaterno" name="apaterno" value="{{ old('apaterno') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="amaterno" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amaterno" name="amaterno" value="{{ old('amaterno') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" value="{{ old('telefono') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="{{ old('direccion') }}">
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-credit-card"></i> Datos de Cliente</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="limite_credito" class="form-label">Límite de Crédito ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="limite_credito" name="limite_credito" value="{{ old('limite_credito', 0.00) }}" required>
                        <div class="form-text">Monto máximo que se le puede fiar al cliente.</div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-save"></i> Guardar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
