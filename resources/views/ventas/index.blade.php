<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas - Abarrotes Wili</title>
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

        /* Filtros */
        .filters {
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

        /* Tabla de ventas */
        .sales-table {
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

        .status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .status.paid {
            background: #d4edda;
            color: #155724;
        }

        .status.credit {
            background: #fff3cd;
            color: #856404;
        }

        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 12px;
            margin-right: 5px;
        }

        .btn-view {
            background: #17a2b8;
            color: white;
        }

        .btn-print {
            background: #6c757d;
            color: white;
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
            <a href="/gestion-inventario" class="nav-link">
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
            <a href="/ventas" class="nav-link active">
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
        <h2>Historial de Ventas</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
            <button class="btn btn-primary" onclick="location.href='/punto-de-venta'">
                Nueva Venta
            </button>
        </div>
    </header>

    <!-- Filtros -->
    <section class="filters">
        <h3 style="margin-bottom: 20px;">Filtrar Ventas</h3>
        <div class="filter-grid">
            <div class="form-group">
                <label for="date-from">Fecha Desde</label>
                <input type="date" id="date-from" class="form-control">
            </div>
            <div class="form-group">
                <label for="date-to">Fecha Hasta</label>
                <input type="date" id="date-to" class="form-control">
            </div>
            <div class="form-group">
                <label for="payment-method">Método de Pago</label>
                <select id="payment-method" class="form-control">
                    <option value="">Todos</option>
                    <option value="cash">Efectivo</option>
                    <option value="credit">Crédito</option>
                    <option value="card">Tarjeta</option>
                </select>
            </div>
            <div class="form-group">
                <label for="customer">Cliente</label>
                <select id="customer" class="form-control">
                    <option value="">Todos los clientes</option>
                    <option value="1">Juan Pérez López</option>
                    <option value="2">María García Hernández</option>
                    <option value="3">Pedro Ramírez Torres</option>
                </select>
            </div>
        </div>
        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button class="btn btn-primary">Aplicar Filtros</button>
            <button class="btn" style="background: #6c757d; color: white;">Limpiar</button>
        </div>
    </section>

    <!-- Tabla de Ventas -->
    <section class="sales-table">
        <div class="table-header">
            <h3>Lista de Ventas</h3>
            <button class="btn btn-success">
                <i>📥</i> Exportar Reporte
            </button>
        </div>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>Folio</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Método Pago</th>
                    <th>Vendedor</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>T00125</td>
                    <td>2025-01-20 14:30</td>
                    <td>Juan Pérez López</td>
                    <td>$175.50</td>
                    <td>Efectivo</td>
                    <td>Admin</td>
                    <td><span class="status paid">Pagado</span></td>
                    <td>
                        <button class="action-btn btn-view">Ver</button>
                        <button class="action-btn btn-print">Imprimir</button>
                    </td>
                </tr>
                <tr>
                    <td>T00124</td>
                    <td>2025-01-20 13:15</td>
                    <td>María García Hernández</td>
                    <td>$89.75</td>
                    <td>Tarjeta</td>
                    <td>Empleado</td>
                    <td><span class="status paid">Pagado</span></td>
                    <td>
                        <button class="action-btn btn-view">Ver</button>
                        <button class="action-btn btn-print">Imprimir</button>
                    </td>
                </tr>
                <tr>
                    <td>T00123</td>
                    <td>2025-01-20 11:45</td>
                    <td>Pedro Ramírez Torres</td>
                    <td>$245.00</td>
                    <td>Crédito</td>
                    <td>Admin</td>
                    <td><span class="status credit">Crédito</span></td>
                    <td>
                        <button class="action-btn btn-view">Ver</button>
                        <button class="action-btn btn-print">Imprimir</button>
                    </td>
                </tr>
                <tr>
                    <td>T00122</td>
                    <td>2025-01-19 16:20</td>
                    <td>Ana Martínez Ruiz</td>
                    <td>$120.25</td>
                    <td>Efectivo</td>
                    <td>Empleado</td>
                    <td><span class="status paid">Pagado</span></td>
                    <td>
                        <button class="action-btn btn-view">Ver</button>
                        <button class="action-btn btn-print">Imprimir</button>
                    </td>
                </tr>
                <tr>
                    <td>T00121</td>
                    <td>2025-01-19 15:10</td>
                    <td>Luis Sánchez Jiménez</td>
                    <td>$68.90</td>
                    <td>Crédito</td>
                    <td>Admin</td>
                    <td><span class="status credit">Crédito</span></td>
                    <td>
                        <button class="action-btn btn-view">Ver</button>
                        <button class="action-btn btn-print">Imprimir</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <div class="page-info">Mostrando 1-5 de 125 ventas</div>
            <div class="page-numbers">
                <span class="page-number active">1</span>
                <span class="page-number">2</span>
                <span class="page-number">3</span>
                <span class="page-number">...</span>
                <span class="page-number">25</span>
            </div>
        </div>
    </section>
</main>

<script>
    // Navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Funcionalidad básica de filtros
    document.querySelector('.btn-primary').addEventListener('click', function() {
        alert('Filtros aplicados correctamente');
    });
</script>
</body>
</html>
