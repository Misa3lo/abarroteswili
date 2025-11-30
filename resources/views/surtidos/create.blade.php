@extends('layouts.app')

@section('title', 'Registrar Surtido')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="fas fa-truck-loading me-2"></i> Registrar Entrada de Mercancía
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
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('surtidos.store') }}" method="POST">
                @csrf

                <h5 class="mb-3 text-primary"><i class="fas fa-box-open"></i> Producto a Surtir</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="producto_id" class="form-label">Seleccionar Producto <span class="text-danger">*</span></label>
                        <select class="form-select" id="producto_id" name="producto_id" required onchange="updateStock(this)">
                            <option value="">-- Buscar y Seleccionar Producto --</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}"
                                        data-stock="{{ $producto->existencias }}"
                                    {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                                    {{ $producto->codigo_barras }} (Stock: {{ $producto->existencias }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock_actual" class="form-label">Existencias Actuales</label>
                        <input type="text" class="form-control bg-light fw-bold" id="stock_actual" value="0" disabled>
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-boxes"></i> Detalles del Surtido</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="cantidad" class="form-label">Cantidad a Surtir <span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" required>
                        <div class="form-text">Cantidad que está ingresando a inventario.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="precio_entrada" class="form-label">Costo de Entrada por Unidad ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0.01" class="form-control" id="precio_entrada" name="precio_entrada" value="{{ old('precio_entrada') }}" required>
                        <div class="form-text">Este costo se usará para actualizar el costo promedio del producto.</div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('surtidos.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-box-open"></i> Confirmar Surtido
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateStock(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            // Obtiene el stock del atributo data-stock de la opción
            const stock = selectedOption.getAttribute('data-stock');
            document.getElementById('stock_actual').value = stock || '0';
        }

        // Inicializar el stock al cargar la página si hay un valor seleccionado
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('producto_id');
            if (select.value) {
                updateStock(select);
            }
        });
    </script>
@endsection
