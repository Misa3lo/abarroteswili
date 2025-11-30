@extends('layouts.app')

@section('title', 'Registrar Surtido (Procedimiento)')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center py-3 rounded-top-4">
                <h4 class="mb-0">
                    🧾 Registrar Surtido (Procedimiento Almacenado)
                </h4>
            </div>

            <div class="card-body p-4">

                {{-- ✅ Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success text-center fw-bold animate__animated animate__fadeInDown">
                        ✅ {{ session('success') }}
                    </div>
                @endif

                {{-- ❌ Mensaje de error --}}
                @if (session('error'))
                    <div class="alert alert-danger text-center fw-bold animate__animated animate__shakeX">
                        ❌ {{ session('error') }}
                    </div>
                @endif

                {{-- ⚠️ Validaciones de formulario --}}
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>⚠️ {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 📝 Formulario de surtido --}}
                <form action="{{ route('surtidos.procedimiento.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="producto_id" class="form-label fw-semibold">🛒 Producto</label>
                            <select name="producto_id" id="producto_id" class="form-select" required>
                                <option value="">Seleccione un producto...</option>
                                @foreach(\App\Models\Producto::all() as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="cantidad" class="form-label fw-semibold">📦 Cantidad</label>
                            <input type="number" step="0.01" min="0.01" name="cantidad" id="cantidad" class="form-control" placeholder="Ej: 10" required>
                        </div>

                        <div class="col-md-3">
                            <label for="precio_entrada" class="form-label fw-semibold">💲 Precio Entrada</label>
                            <input type="number" step="0.01" min="0.01" name="precio_entrada" id="precio_entrada" class="form-control" placeholder="Ej: 25.50" required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success px-5 py-2 rounded-pill shadow-sm">
                            💾 Registrar Surtido
                        </button>
                        <a href="{{ route('surtidos.index') }}" class="btn btn-secondary px-4 py-2 rounded-pill ms-2">
                            🔙 Volver
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Animaciones suaves (opcional) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    {{-- Validación Bootstrap (opcional) --}}
    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
