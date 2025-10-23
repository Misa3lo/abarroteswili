<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - Abarrotes Wili</title>
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

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 14px;
        }

        /* Formulario de Producto */
        .product-form {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 2px solid #ecf0f1;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        /* Búsqueda y Filtros */
        .search-section {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .search-box {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .search-input {
            flex: 1;
            padding: 10px;
            border: 2px solid #ecf0f1;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Tabla de Inventario */
        .inventory-table {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-container {
            overflow-x: auto;
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

        .product-name {
            font-weight: 500;
            color: #2c3e50;
        }

        .product-category {
            color: #7f8c8d;
            font-size: 14px;
        }

        .stock-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .stock-status.good {
            background: #d4edda;
            color: #155724;
        }

        .stock-status.low {
            background: #fff3cd;
            color: #856404;
        }

        .stock-status.out {
            background: #f8d7da;
            color: #721c24;
        }

        .price {
            font-weight: 600;
            color: #27ae60;
        }

        .cost {
            color: #7f8c8d;
            font-size: 14px;
        }

        .action-btns {
            display: flex;
            gap: 5px;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            color: white;
        }

        .btn-edit {
            background: #17a2b8;
        }

        .btn-delete {
            background: #e74c3c;
        }

        .btn-stock {
            background: #f39c12;
        }

        /* Paginación */
        .pagination {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ecf0f1;
        }

        .page-info {
            color: #6c757d;
        }

        .page-numbers {
            display: flex;
            gap: 5px;
        }

        .page-number {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            cursor: pointer;
            color: #3498db;
        }

        .page-number.active {
            background: #3498db;
            color: white;
            border-color: #3498db;
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
            <a href="/gestion-inventario" class="nav-link active">
                <i>📦</i> Inventario
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-clientes" class="nav-link">
                <i>👥</i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a href="/productos" class="nav-link">
                <i>🏷️</i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a href="/ventas" class="nav-link">
                <i>💰</i> Ventas
            </a>
        </li>
        <li class="nav-item">
            <a href="/creditos" class="nav-link">
                <i>💳</i> Créditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/usuarios" class="nav-link">
                <i>👤</i> Usuarios
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
        <h2>Gestión de Inventario</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
            <button class="btn btn-primary" onclick="showProductForm()">
                <i>➕</i> Nuevo Producto
            </button>
        </div>
    </header>

    <!-- Estadísticas Rápidas -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">1,247</div>
            <div class="stat-label">Total Productos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">23</div>
            <div class="stat-label">Stock Bajo</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">5</div>
            <div class="stat-label">Agotados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">$45,820</div>
            <div class="stat-label">Valor Inventario</div>
        </div>
    </div>

    <!-- Formulario de Producto -->
    <section class="product-form" id="productForm">
        <h3 class="form-title">Registrar Nuevo Producto</h3>
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre del Producto *</label>
                <input type="text" id="nombre" class="form-control" placeholder="Ej. Arroz Integral">
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" class="form-control" rows="2" placeholder="Descripción del producto"></textarea>
            </div>
            <div class="form-group">
                <label for="departamento">Departamento *</label>
                <select id="departamento" class="form-control">
                    <option value="">Seleccionar departamento</option>
                    <option value="1">Abarrotes</option>
                    <option value="2">Lácteos</option>
                    <option value="3">Bebidas</option>
                    <option value="4">Limpieza</option>
                    <option value="5">Botanas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="precio-compra">Precio de Compra *</label>
                <input type="number" id="precio-compra" class="form-control" placeholder="0.00" step="0.01">
            </div>
            <div class="form-group">
                <label for="precio-venta">Precio de Venta *</label>
                <input type="number" id="precio-venta" class="form-control" placeholder="0.00" step="0.01">
            </div>
            <div class="form-group">
                <label for="existencias">Existencias Iniciales *</label>
                <input type="number" id="existencias" class="form-control" placeholder="0">
            </div>
            <div class="form-group">
                <label for="stock-minimo">Stock Mínimo</label>
                <input type="number" id="stock-minimo" class="form-control" placeholder="10" value="10">
            </div>
        </div>
        <div class="form-actions">
            <button type="button" class="btn" onclick="hideProductForm()">Cancelar</button>
            <button type="button" class="btn btn-success">Guardar Producto</button>
        </div>
    </section>

    <!-- Búsqueda y Filtros -->
    <section class="search-section">
        <div class="filter-grid">
            <div class="form-group">
                <label for="filtro-departamento">Departamento</label>
                <select id="filtro-departamento" class="form-control">
                    <option value="">Todos los departamentos</option>
                    <option value="1">Abarrotes</option>
                    <option value="2">Lácteos</option>
                    <option value="3">Bebidas</option>
                    <option value="4">Limpieza</option>
                    <option value="5">Botanas</option>
                </select>
            </div>
            <div class="form-group">
                <label for="filtro-stock">Estado de Stock</label>
                <select id="filtro-stock" class="form-control">
                    <option value="">Todos</option>
                    <option value="good">Stock Bueno</option>
                    <option value="low">Stock Bajo</option>
                    <option value="out">Agotados</option>
                </select>
            </div>
        </div>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar producto por nombre, código o descripción...">
            <button class="btn btn-primary">Buscar</button>
            <button class="btn" style="background: #6c757d; color: white;">Limpiar</button>
        </div>
    </section>

    <!-- Tabla de Inventario -->
    <section class="inventory-table">
        <div class="table-header">
            <h3>Inventario de Productos</h3>
            <div class="table-actions">
                <button class="btn btn-warning" onclick="location.href='/surtidos'">
                    <i>📦</i> Realizar Surtido
                </button>
                <button class="btn" style="background: #6c757d; color: white;">
                    <i>📥</i> Exportar
                </button>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Departamento</th>
                    <th>Precios</th>
                    <th>Existencias</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>PR001</td>
                    <td>
                        <div class="product-name">Arroz Integral</div>
                        <div class="product-category">Granos básicos</div>
                    </td>
                    <td>Abarrotes</td>
                    <td>
                        <div class="price">$25.00</div>
                        <div class="cost">Compra: $18.50</div>
                    </td>
                    <td>45 unidades</td>
                    <td><span class="stock-status good">Disponible</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-stock">Stock</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PR002</td>
                    <td>
                        <div class="product-name">Leche Entera 1L</div>
                        <div class="product-category">Lácteo líquido</div>
                    </td>
                    <td>Lácteos</td>
                    <td>
                        <div class="price">$22.00</div>
                        <div class="cost">Compra: $16.00</div>
                    </td>
                    <td>8 unidades</td>
                    <td><span class="stock-status low">Stock Bajo</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-stock">Stock</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PR003</td>
                    <td>
                        <div class="product-name">Refresco Cola 2L</div>
                        <div class="product-category">Bebida carbonatada</div>
                    </td>
                    <td>Bebidas</td>
                    <td>
                        <div class="price">$28.00</div>
                        <div class="cost">Compra: $20.00</div>
                    </td>
                    <td>0 unidades</td>
                    <td><span class="stock-status out">Agotado</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-stock">Stock</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PR004</td>
                    <td>
                        <div class="product-name">Jabón de Barra</div>
                        <div class="product-category">Limpieza personal</div>
                    </td>
                    <td>Limpieza</td>
                    <td>
                        <div class="price">$12.00</div>
                        <div class="cost">Compra: $8.00</div>
                    </td>
                    <td>15 unidades</td>
                    <td><span class="stock-status good">Disponible</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-stock">Stock</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>PR005</td>
                    <td>
                        <div class="product-name">Papas Fritas</div>
                        <div class="product-category">Snack salado</div>
                    </td>
                    <td>Botanas</td>
                    <td>
                        <div class="price">$18.00</div>
                        <div class="cost">Compra: $12.50</div>
                    </td>
                    <td>5 unidades</td>
                    <td><span class="stock-status low">Stock Bajo</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-stock">Stock</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <div class="page-info">Mostrando 1-5 de 1247 productos</div>
            <div class="page-numbers">
                <span class="page-number active">1</span>
                <span class="page-number">2</span>
                <span class="page-number">3</span>
                <span class="page-number">...</span>
                <span class="page-number">250</span>
            </div>
        </div>
    </section>
</main>

<script>
    // Mostrar/ocultar formulario
    function showProductForm() {
        document.getElementById('productForm').style.display = 'block';
    }

    function hideProductForm() {
        document.getElementById('productForm').style.display = 'none';
    }

    // Ocultar formulario inicialmente
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('productForm').style.display = 'none';
    });

    // Navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Funcionalidad básica de botones
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Editar producto - Funcionalidad en desarrollo');
        });
    });

    document.querySelectorAll('.btn-stock').forEach(btn => {
        btn.addEventListener('click', function() {
            alert('Ajustar stock - Funcionalidad en desarrollo');
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            if(confirm('¿Está seguro de eliminar este producto?')) {
                alert('Producto eliminado');
            }
        });
    });
</script>
</body>
</html>
