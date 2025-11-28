<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Surtidos - Abarrotes Wili</title>
    <style>
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

        .stat-card.total {
            border-left-color: #3498db;
        }

        .stat-card.mensual {
            border-left-color: #27ae60;
        }

        .stat-card.productos {
            border-left-color: #f39c12;
        }

        .stat-card.inversion {
            border-left-color: #9b59b6;
        }

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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .product-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .info-label {
            font-weight: 500;
            color: #7f8c8d;
        }

        .info-value {
            font-weight: 600;
            color: #2c3e50;
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

        .btn-primary {
            background: #27ae60;
            color: white;
        }

        .btn-primary:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .btn-secondary:hover {
            background: #7f8c8d;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-completado {
            background: #d4edda;
            color: #155724;
        }

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-cancelado {
            background: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

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

        /* Surtido Items */
        .surtido-items {
            margin-bottom: 20px;
        }

        .surtido-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border-left: 4px solid #3498db;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-info h4 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .item-details {
            color: #7f8c8d;
            font-size: 14px;
        }

        .item-total {
            font-weight: bold;
            color: #27ae60;
            font-size: 16px;
        }

        .surtido-summary {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .summary-item {
            text-align: center;
        }

        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }

        .summary-label {
            color: #7f8c8d;
            font-size: 14px;
        }
    </style>
</head>
<body>
<!-- Sidebar Navigation -->
<nav class="sidebar">
    <div class="logo">
        <h1>Abarrotes <span>Wili</span></h1>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">
                <i>📊</i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/punto-de-venta" class="nav-link">
                <i>🛒</i> Punto de Venta
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-inventario" class="nav-link">
                <i>📦</i> Inventario
            </a>
        </li>
        <li class="nav-item">
            <a href="/productos" class="nav-link">
                <i>🏷️</i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a href="/surtidos" class="nav-link active">
                <i>📥</i> Surtidos
            </a>
        </li>
        <li class="nav-item">
            <a href="/login" class="nav-link" style="color: #e74c3c;">
                <i>🚪</i> Cerrar Sesión
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<main class="main-content">
    <!-- Header -->
    <header class="header">
        <h2>Gestión de Surtidos</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number">15</div>
            <div class="stat-label">Surtidos Totales</div>
        </div>
        <div class="stat-card mensual">
            <div class="stat-number">8</div>
            <div class="stat-label">Este Mes</div>
        </div>
        <div class="stat-card productos">
            <div class="stat-number">542</div>
            <div class="stat-label">Productos Surtidos</div>
        </div>
        <div class="stat-card inversion">
            <div class="stat-number">$8,450</div>
            <div class="stat-label">Inversión Total</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Surtido</div>
        <div class="tab" onclick="showTab('lista')">Historial</div>
        <div class="tab" onclick="showTab('rapido')">Surtido Rápido</div>
    </div>

    <!-- Formulario de Nuevo Surtido -->
    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Surtido</h3>
        <form id="surtidoForm">
            <div class="form-section">
                <h4 class="section-title">Selección de Productos</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="producto_id">Producto *</label>
                        <select id="producto_id" name="producto_id" required>
                            <option value="">Seleccione un producto</option>
                            <option value="1">Arroz kg</option>
                            <option value="2">Frijol kg</option>
                            <option value="3">Aceite lt</option>
                            <option value="6">Leche entera lt</option>
                            <option value="9">Coca-Cola 600ml</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="precio_entrada">Precio de Entrada *</label>
                        <input type="number" id="precio_entrada" name="precio_entrada" step="0.01" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad *</label>
                        <input type="number" id="cantidad" name="cantidad" step="0.01" min="0.01" required>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="agregarProducto()">
                        <i>➕</i> Agregar Producto
                    </button>
                </div>
            </div>

            <!-- Productos agregados -->
            <div class="form-section">
                <h4 class="section-title">Productos a Surtir</h4>
                <div class="surtido-items" id="productos-agregados">
                    <!-- Los productos se agregarán aquí dinámicamente -->
                    <div class="surtido-item">
                        <div class="item-info">
                            <h4>Arroz kg</h4>
                            <div class="item-details">Precio: $18.00 | Cantidad: 50</div>
                        </div>
                        <div class="item-total">$900.00</div>
                    </div>
                </div>

                <div class="surtido-summary">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-value">3</div>
                            <div class="summary-label">Productos</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value">150</div>
                            <div class="summary-label">Total Unidades</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value">$2,150</div>
                            <div class="summary-label">Inversión Total</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar Todo
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Surtido
                </button>
            </div>
        </form>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">📦 Lista de Surtidos</h4>
        <a href="{{ route('surtidos.procedimiento') }}" class="btn btn-success shadow-sm px-4 py-2 rounded-pill">
            ⚙️ Registrar por Procedimiento
        </a>
    </div>

    <!-- Historial de Surtidos -->
    <div id="lista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Historial de Surtidos</h3>
            <button class="btn btn-primary" onclick="exportarSurtidos()">
                <i>📄</i> Exportar Reporte
            </button>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar surtido...">
            <button>🔍 Buscar</button>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Fecha/Hora</th>
                <th>Productos</th>
                <th>Cantidad Total</th>
                <th>Inversión</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>25/10/2024 10:30</td>
                <td>Arroz, Frijol, Aceite</td>
                <td>120 unidades</td>
                <td>$900.00</td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>24/10/2024 15:45</td>
                <td>Leche, Yogurt, Queso</td>
                <td>85 unidades</td>
                <td>$1,250.00</td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>23/10/2024 09:15</td>
                <td>Refrescos, Jugos, Agua</td>
                <td>200 unidades</td>
                <td>$850.00</td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Surtido Rápido -->
    <div id="rapido-tab" class="form-container" style="display: none;">
        <h3 class="form-title">Surtido Rápido - Productos con Stock Bajo</h3>

        <div class="product-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Productos con stock bajo:</span>
                    <span class="info-value">8 productos</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Inversión estimada:</span>
                    <span class="info-value">$1,850.00</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Unidades necesarias:</span>
                    <span class="info-value">215 unidades</span>
                </div>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="surtido_rapido">Seleccionar Productos</label>
                <select id="surtido_rapido" multiple size="6" style="height: 150px;">
                    <option value="2" selected>Frijol kg (8 unidades - surtir 40)</option>
                    <option value="19" selected>Pan blanco kg (0 unidades - surtir 20)</option>
                    <option value="12" selected>Jabón de barra (5 unidades - surtir 25)</option>
                    <option value="16">Sabritas 45g (60 unidades - surtir 40)</option>
                    <option value="17">Cacahuates 100g (45 unidades - surtir 30)</option>
                    <option value="23">Manzana kg (25 unidades - surtir 25)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="proveedor">Proveedor</label>
                <select id="proveedor">
                    <option value="">Seleccione proveedor</option>
                    <option value="1">Distribuidora Central</option>
                    <option value="2">Mayoreo ABC</option>
                    <option value="3">Proveedores Unidos</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-secondary" onclick="deseleccionarTodo()">
                <i>❌</i> Deseleccionar Todo
            </button>
            <button class="btn btn-primary" onclick="realizarSurtidoRapido()">
                <i>🚀</i> Realizar Surtido Rápido
            </button>
        </div>
    </div>
</main>

<script>
    // Funcionalidad de tabs
    function showTab(tabName) {
        // Ocultar todos los tabs
        document.getElementById('nuevo-tab').style.display = 'none';
        document.getElementById('lista-tab').style.display = 'none';
        document.getElementById('rapido-tab').style.display = 'none';

        // Remover clase active de todos los tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Mostrar tab seleccionado y agregar clase active
        document.getElementById(tabName + '-tab').style.display = 'block';
        event.target.classList.add('active');
    }

    // Simulación de datos de productos
    const productos = {
        1: { nombre: "Arroz kg", precio_compra: 18.00, existencias: 50 },
        2: { nombre: "Frijol kg", precio_compra: 24.00, existencias: 8 },
        3: { nombre: "Aceite lt", precio_compra: 35.00, existencias: 30 },
        6: { nombre: "Leche entera lt", precio_compra: 16.00, existencias: 35 },
        9: { nombre: "Coca-Cola 600ml", precio_compra: 12.00, existencias: 100 }
    };

    // Actualizar información del producto seleccionado
    document.getElementById('producto_id').addEventListener('change', function() {
        const productoId = this.value;
        const producto = productos[productoId];

        if (producto) {
            document.getElementById('precio_entrada').value = producto.precio_compra;
        } else {
            document.getElementById('precio_entrada').value = '';
        }
    });

    let productosAgregados = [];

    function agregarProducto() {
        const productoId = document.getElementById('producto_id').value;
        const precioEntrada = document.getElementById('precio_entrada').value;
        const cantidad = document.getElementById('cantidad').value;

        if (productoId && precioEntrada && cantidad) {
            const producto = productos[productoId];
            const total = precioEntrada * cantidad;

            productosAgregados.push({
                id: productoId,
                nombre: producto.nombre,
                precio_entrada: parseFloat(precioEntrada),
                cantidad: parseFloat(cantidad),
                total: total
            });

            actualizarListaProductos();
            limpiarCamposProducto();
        } else {
            alert('Por favor complete todos los campos del producto');
        }
    }

    function actualizarListaProductos() {
        const container = document.getElementById('productos-agregados');
        container.innerHTML = '';

        let totalUnidades = 0;
        let totalInversion = 0;

        productosAgregados.forEach(producto => {
            const item = document.createElement('div');
            item.className = 'surtido-item';
            item.innerHTML = `
                    <div class="item-info">
                        <h4>${producto.nombre}</h4>
                        <div class="item-details">Precio: $${producto.precio_entrada.toFixed(2)} | Cantidad: ${producto.cantidad}</div>
                    </div>
                    <div class="item-total">$${producto.total.toFixed(2)}</div>
                `;
            container.appendChild(item);

            totalUnidades += producto.cantidad;
            totalInversion += producto.total;
        });

        // Actualizar resumen
        document.querySelector('.summary-grid').innerHTML = `
                <div class="summary-item">
                    <div class="summary-value">${productosAgregados.length}</div>
                    <div class="summary-label">Productos</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">${totalUnidades}</div>
                    <div class="summary-label">Total Unidades</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">$${totalInversion.toFixed(2)}</div>
                    <div class="summary-label">Inversión Total</div>
                </div>
            `;
    }

    function limpiarCamposProducto() {
        document.getElementById('producto_id').value = '';
        document.getElementById('precio_entrada').value = '';
        document.getElementById('cantidad').value = '';
    }

    function limpiarFormulario() {
        productosAgregados = [];
        actualizarListaProductos();
        limpiarCamposProducto();
    }

    // Manejar envío del formulario
    document.getElementById('surtidoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (productosAgregados.length > 0) {
            alert('Surtido registrado exitosamente!');
            limpiarFormulario();
        } else {
            alert('Por favor agregue al menos un producto al surtido');
        }
    });

    function exportarSurtidos() {
        alert('Generando reporte de surtidos...');
    }

    function deseleccionarTodo() {
        const select = document.getElementById('surtido_rapido');
        for (let i = 0; i < select.options.length; i++) {
            select.options[i].selected = false;
        }
    }

    function realizarSurtidoRapido() {
        const selectedOptions = document.getElementById('surtido_rapido').selectedOptions;
        if (selectedOptions.length > 0) {
            alert(`Realizando surtido rápido para ${selectedOptions.length} productos...`);
        } else {
            alert('Por favor seleccione al menos un producto');
        }
    }

    // Navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>
</body>
</html>
