@extends('layouts.app')

@section('title', 'Registrar Producto')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="fas fa-plus me-2"></i> Registrar Nuevo Producto
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

            <form action="{{ route('productos.store') }}" method="POST">
                @csrf

                <h5 class="mb-3 text-primary"><i class="fas fa-box"></i> Detalles del Producto</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="Codigo de barras" class="form-label">Codigo de barras del Producto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" value="{{ old('codigo_barras') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="departamento_id" class="form-label">Departamento <span class="text-danger">*</span></label>
                        <select class="form-select" id="departamento_id" name="departamento_id" required>
                            <option value="">-- Seleccione un Departamento --</option>
                            @foreach($departamentos as $depto)
                                <option value="{{ $depto->id }}" {{ old('departamento_id') == $depto->id ? 'selected' : '' }}>
                                    {{ $depto->codigo_barras }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción (Opcional)</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="2">{{ old('descripcion') }}</textarea>
                </div>

                <h5 class="mt-4 mb-3 text-primary"><i class="fas fa-dollar-sign"></i> Precios y Costos</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio_compra" class="form-label">Costo de Compra (Proveedor) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="precio_compra" name="precio_compra" value="{{ old('precio_compra', 0.00) }}" required>
                        <div class="form-text">Precio sin IVA y sin margen de ganancia.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="precio_venta" class="form-label">Precio de Venta (Público) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="precio_venta" name="precio_venta" value="{{ old('precio_venta', 0.00) }}" required>
                        <div class="form-text">Este precio se usará en el punto de venta.</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Existencias Iniciales</label>
                        <input type="text" class="form-control" value="0" disabled>
                        <input type="hidden" name="existencias" value="0">
                        <div class="form-text text-danger">Las existencias se actualizan únicamente en la sección "Surtir".</div>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-success-custom">
                        <i class="fas fa-save"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
