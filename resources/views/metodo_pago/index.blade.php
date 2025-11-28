<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>💳 Métodos de Pago</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('metodos-pago.create') }}" class="btn btn-primary mb-3">➕ Nuevo Método</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($metodosPago as $metodo)
            <tr>
                <td>{{ $metodo->id }}</td>
                <td>{{ $metodo->descripcion }}</td>
                <td>
                    <a href="{{ route('metodos-pago.edit', $metodo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('metodos-pago.destroy', $metodo->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
