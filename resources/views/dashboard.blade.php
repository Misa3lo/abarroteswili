<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago - Abarrotes Wili</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .nav-link {
            color: #bdc3c7;
            padding: 12px 15px;
            border-radius: 8px;
        }
        .nav-link:hover, .nav-link.active {
            background: #34495e;
            color: white;
        }
    </style>
</head>
<body>
<!-- Sidebar -->
<nav class="sidebar">
    <div class="logo text-center py-3 border-bottom">
        <h4>Abarrotes <span class="text-primary">Wili</span></h4>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">📊 Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="/metodos-pago" class="nav-link active">💳 Métodos de Pago</a>
        </li>
        <li class="nav-item">
            <a href="/productos" class="nav-link">🏷️ Productos</a>
        </li>
        <li class="nav-item">
            <a href="/ventas" class="nav-link">💰 Ventas</a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<main class="main-content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>💳 Métodos de Pago</h2>
            <a href="{{ route('metodos-pago.create') }}" class="btn btn-primary mb-3">➕ Nuevo Método</a>
                ➕ Nuevo Método de Pago
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
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
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('metodo-pago.show', $metodo) }}" class="btn btn-info">
                                            👁️ Ver
                                        </a>
                                        <a href="{{ route('metodo-pago.edit', $metodo) }}" class="btn btn-warning">
                                            ✏️ Editar
                                        </a>
                                        <form action="{{ route('metodo-pago.destroy', $metodo) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('¿Eliminar {{ $metodo->descripcion }}?')">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
