@extends('layouts.app')

@section('title', 'Registrar Usuario')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="fas fa-user-plus me-2"></i> Formulario de Registro de Usuario
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

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <h5 class="mb-3 text-primary"><i class="fas fa-id-card"></i> Datos Personales</h5>
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

                <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-user-lock"></i> Datos de Acceso al Sistema</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="usuario" class="form-label">Usuario (Login) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="usuario" name="usuario" value="{{ old('usuario') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="rol" class="form-label">Rol del Usuario <span class="text-danger">*</span></label>
                        <select class="form-select" id="rol" name="rol" required>
                            <option value="">Seleccione un Rol</option>
                            <option value="administrador" {{ old('rol') == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="empleado" {{ old('rol') == 'empleado' ? 'selected' : '' }}>Empleado</option>
                        </select>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-save"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
