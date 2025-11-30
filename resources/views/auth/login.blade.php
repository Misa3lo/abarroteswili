@extends('layouts.login')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <div class="card-header bg-primary text-white text-center">
                <i class="fas fa-shopping-basket fa-2x mb-2"></i>
                <h4 class="mb-0">Acceso a Abarrotes Wili</h4>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                {{-- Formulario de Inicio de Sesión --}}
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="usuario" class="form-label"><i class="fas fa-user me-2"></i> Usuario:</label>
                        <input type="text"
                               name="usuario"
                               id="usuario"
                               class="form-control @error('usuario') is-invalid @enderror"
                               value="{{ old('usuario') }}"
                               required
                               autofocus>
                        @error('usuario')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label"><i class="fas fa-lock me-2"></i> Contraseña:</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i> Entrar
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted text-center">
                Sistema de Punto de Venta v1.0
            </div>
        </div>
    </div>
@endsection
