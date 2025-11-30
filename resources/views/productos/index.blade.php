@extends('layouts.app')

@section('title', 'Inventario de Productos')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-box-open me-2"></i> Inventario de Productos</span>
            <a href="{{ route('productos.create') }}" class="btn btn-light btn-sm text-primary fw-bold">
                <i class="fas fa-plus"></i> Nuevo Producto
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Codigo de barras / Descripción</th>
                        <th>Departamento</th>
                        <th>Costo Compra</th>
                        <th>Precio Venta</th>
                        <th>Existencias</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td>{{ $producto->id }}</td>
                            <td>
                                <strong>{{ $producto->codigo_barras }}</strong>
                                <br><small class="text-muted">{{ $producto->descripcion }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $producto->departamento->nombre ?? 'Sin Dep.' }}</span>
                            </td>
                            <td>$ {{ number_format($producto->precio_compra, 2) }}</td>
                            <td>$ {{ number_format($producto->precio_venta, 2) }}</td>
                            <td>
                                @if($producto->existencias <= 5)
                                    <span class="badge bg-danger">{{ $producto->existencias }}</span>
                                @else
                                    <span class="badge bg-success">{{ $producto->existencias }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este producto? Esto podría afectar la integridad de las ventas históricas.');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-boxes fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No hay productos registrados en el inventario.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
