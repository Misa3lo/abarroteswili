<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos - Abarrotes Wili</title>
    <style>
        /* --- INICIO DE ESTILOS EXTRAÍDOS --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f6fa;
            color: #2c3e50;
        }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .logo span {
            color: #3498db;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin: 5px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: #34495e;
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            border-left: 4px solid #3498db;
        }

        .stat-card.total { border-left-color: #3498db; }
        .stat-card.stock-bajo { border-left-color: #e74c3c; }
        .stat-card.agotados { border-left-color: #f39c12; }
        .stat-card.ganancia { border-left-color: #27ae60; }

        .stat-number {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            background: white;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 0;
        }

        .tab {
            padding: 15px 25px;
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .tab.active {
            border-bottom-color: #3498db;
            color: #3498db;
        }

        /* Form Styles */
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 0 0 10px 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        /* Buttons */
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary { background: #27ae60; color: white; }
        .btn-primary:hover { background: #219a52; transform: translateY(-2px); }

        .btn-secondary { background: #95a5a6; color: white; }
        .btn-secondary:hover { background: #7f8c8d; }

        .btn-danger { background: #e74c3c; color: white; }
        .btn-danger:hover { background: #c0392b; }

        .btn-warning { background: #f39c12; color: white; }
        .btn-warning:hover { background: #e67e22; }
        
        .btn-sm { padding: 6px 12px; font-size: 12px; }

        /* Table Styles */
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ecf0f1; }
        th { background: #f8f9fa; font-weight: 600; color: #2c3e50; }
        tr:hover { background: #f8f9fa; }

        /* Status Badges */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        .status-disponible { background: #d4edda; color: #155724; }
        .status-bajo-stock { background: #fff3cd; color: #856404; }
        .status-agotado { background: #f8d7da; color: #721c24; }

        .action-buttons { display: flex; gap: 8px; }

        /* Search Box */
        .search-box {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-box input {
            flex: 1;
            padding: 10px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
        }
        .search-box button {
            padding: 10px 20px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Product Cards (Visual Catalog) */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .product-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .product-card.stock-bajo { border-left-color: #f39c12; }
        .product-card.agotado { border-left-color: #e74c3c; }

        .product-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .product-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .product-department { font-size: 14px; color: #7f8c8d; }
        .product-price { font-size: 20px; font-weight: bold; color: #27ae60; }
        .product-stock { font-size: 14px; margin: 10px 0; }
        .product-description {
            color: #5d6d7e;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .stock-bar {
            height: 6px;
            background: #ecf0f1;
            border-radius: 3px;
            margin: 10px 0;
            overflow: hidden;
        }

        .stock-fill {
            height: 100%;
            border-radius: 3px;
            transition: width 0.3s ease;
        }
        .stock-fill.alto { background: #27ae60; width: 90%; }
        .stock-fill.medio { background: #f39c12; width: 45%; }
        .stock-fill.bajo { background: #e74c3c; width: 15%; }

        /* --- FIN DE ESTILOS EXTRAÍDOS --- */

        /* Estilos para alertas de Laravel (Agregados adicionales) */
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; color: white; }
        .alert-success { background-color: #27ae60; }
        .alert-danger { background-color: #e74c3c; }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="logo"><h1>Abarrotes <span>Wili</span></h1></div>
    <ul class="nav-menu">
        <li class="nav-item"><a href="{{ route('productos.index') }}" class="nav-link active"><i>🏷️</i> Productos</a></li>
    </ul>
</nav>

<main class="main-content">
    <header class="header">
        <h2>Gestión de Productos</h2>
        <div class="user-info"><div class="user-avatar">AW</div><span>Administrador</span></div>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number">{{ $productos->count() }}</div>
            <div class="stat-label">Total de Productos</div>
        </div>
        </div>

    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Producto</div>
        <div class="tab" onclick="showTab('lista')">Lista de Productos</div>
        <div class="tab" onclick="showTab('catalogo')">Catálogo Visual</div>
    </div>

    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Producto</h3>
        
        <form id="productoFormLaravel" action="{{ route('productos.store') }}" method="POST">
            @csrf 

            <div class="form-section">
                <h4 class="section-title">Información Básica</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nombre">Nombre del Producto *</label>
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="departamento_id">Departamento *</label>
                        <select id="departamento_id" name="departamento_id" required>
                            <option value="">Seleccione un departamento</option>
                            @foreach($departamentos as $dep)
                                <option value="{{ $dep->id }}" {{ old('departamento_id') == $dep->id ? 'selected' : '' }}>
                                    {{ $dep->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Descripción *</label>
                        <textarea id="descripcion" name="descripcion" required>{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Precios y Existencias</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="precio_compra">Precio de Compra *</label>
                        <input type="number" id="precio_compra" name="precio_compra" step="0.01" value="{{ old('precio_compra') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_venta">Precio de Venta *</label>
                        <input type="number" id="precio_venta" name="precio_venta" step="0.01" value="{{ old('precio_venta') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="existencias">Existencias Iniciales *</label>
                        <input type="number" id="existencias" name="existencias" step="0.01" value="{{ old('existencias') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="document.getElementById('productoFormLaravel').reset()">
                    <i>🗑️</i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Producto
                </button>
            </div>
        </form>
    </div>

    <div id="lista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Productos Registrados</h3>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Precio Venta</th>
                <th>Existencias</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>

            <tbody>
            @forelse($productos as $producto)
            <tr>
                <td>{{ $producto->id }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->departamento->nombre ?? 'Sin Depto' }}</td>
                <td>${{ number_format($producto->precio_venta, 2) }}</td>
                <td>{{ $producto->existencias }}</td>
                <td>
                    @php
                        $estado = $producto->estado_stock;
                        $clase = match($estado) {
                            'Disponible' => 'status-disponible',
                            'Bajo Stock' => 'status-bajo-stock',
                            'Agotado' => 'status-agotado',
                            default => ''
                        };
                    @endphp
                    <span class="status-badge {{ $clase }}">{{ $estado }}</span>
                </td>

                <td>
                    <div class="action-buttons">
                        <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">
                            ✏️ Editar
                        </a>

                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                🗑️
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;">No hay productos registrados aún.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div id="catalogo-tab" class="table-container" style="display:none;">
        <div class="products-grid">
            @foreach($productos as $producto)
                <div class="product-card {{ $producto->existencias == 0 ? 'agotado' : ($producto->existencias < 10 ? 'stock-bajo' : '') }}">
                    <div class="product-header">
                        <div>
                            <div class="product-name">{{ $producto->nombre }}</div>
                            <div class="product-department">{{ $producto->departamento->nombre ?? 'General' }}</div>
                        </div>
                        <div class="product-price">${{ number_format($producto->precio_venta, 2) }}</div>
                    </div>
                    <div class="product-stock">{{ $producto->existencias }} unidades</div>
                </div>
            @endforeach
        </div>
    </div>
</main>

<script>
function showTab(tabName) {
    document.getElementById('nuevo-tab').style.display = 'none';
    document.getElementById('lista-tab').style.display = 'none';
    document.getElementById('catalogo-tab').style.display = 'none';

    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

    document.getElementById(tabName + '-tab').style.display = 'block';
    // Aquí puedes agregar la lógica para poner la clase active al botón presionado si lo deseas
}

document.getElementById('precio_compra').addEventListener('input', calcularGanancia);
document.getElementById('precio_venta').addEventListener('input', calcularGanancia);

function calcularGanancia() {
    const precioCompra = parseFloat(document.getElementById('precio_compra').value) || 0;
    const precioVenta  = parseFloat(document.getElementById('precio_venta').value) || 0;

    if (precioCompra > 0 && precioVenta > 0) {
        const ganancia = ((precioVenta - precioCompra) / precioCompra * 100).toFixed(1);
        console.log("Ganancia: " + ganancia + "%");
    }
}
</script>

</body>
</html>
