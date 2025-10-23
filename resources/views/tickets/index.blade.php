<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tickets - Abarrotes Wili</title>
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

        .stat-card.hoy {
            border-left-color: #27ae60;
        }

        .stat-card.credito {
            border-left-color: #e74c3c;
        }

        .stat-card.efectivo {
            border-left-color: #f39c12;
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

        .btn-info {
            background: #3498db;
            color: white;
        }

        .btn-info:hover {
            background: #2980b9;
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

        .payment-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .payment-efectivo {
            background: #d4edda;
            color: #155724;
        }

        .payment-credito {
            background: #fff3cd;
            color: #856404;
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

        /* Ticket Preview */
        .ticket-preview {
            background: white;
            border: 2px dashed #bdc3c7;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-family: 'Courier New', monospace;
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ecf0f1;
            padding-bottom: 15px;
        }

        .ticket-items {
            margin-bottom: 20px;
        }

        .ticket-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .ticket-total {
            border-top: 2px solid #2c3e50;
            padding-top: 10px;
            margin-top: 10px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
        }

        .ticket-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #7f8c8d;
        }

        /* Ticket Items */
        .ticket-items-list {
            margin-bottom: 20px;
        }

        .ticket-item-row {
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

        .ticket-summary {
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
            <a href="/ventas" class="nav-link">
                <i>💰</i> Ventas
            </a>
        </li>
        <li class="nav-item">
            <a href="/tickets" class="nav-link active">
                <i>🎫</i> Tickets
            </a>
        </li>
        <li class="nav-item">
            <a href="/clientes" class="nav-link">
                <i>👥</i> Clientes
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
        <h2>Gestión de Tickets</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number">25</div>
            <div class="stat-label">Tickets Totales</div>
        </div>
        <div class="stat-card hoy">
            <div class="stat-number">8</div>
            <div class="stat-label">Hoy</div>
        </div>
        <div class="stat-card credito">
            <div class="stat-number">6</div>
            <div class="stat-label">A Crédito</div>
        </div>
        <div class="stat-card efectivo">
            <div class="stat-number">19</div>
            <div class="stat-label">En Efectivo</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Ticket</div>
        <div class="tab" onclick="showTab('historial')">Historial</div>
        <div class="tab" onclick="showTab('busqueda')">Búsqueda</div>
    </div>

    <!-- Formulario de Nuevo Ticket -->
    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Ticket</h3>
        <form id="ticketForm">
            <div class="form-section">
                <h4 class="section-title">Información del Ticket</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="folio">Folio *</label>
                        <input type="text" id="folio" name="folio" value="TICK-026" readonly style="background: #ecf0f1;">
                    </div>

                    <div class="form-group">
                        <label for="cliente_id">Cliente *</label>
                        <select id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccione un cliente</option>
                            <option value="1">Juan Pérez López</option>
                            <option value="2">María García Hernández</option>
                            <option value="3">Pedro Ramírez Torres</option>
                            <option value="4">Ana Martínez Ruiz</option>
                            <option value="5">Luis Sánchez Jiménez</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="metodo_pago_id">Método de Pago *</label>
                        <select id="metodo_pago_id" name="metodo_pago_id" required>
                            <option value="">Seleccione método</option>
                            <option value="1">Efectivo</option>
                            <option value="2">Crédito</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="usuario_id">Vendedor *</label>
                        <select id="usuario_id" name="usuario_id" required>
                            <option value="">Seleccione vendedor</option>
                            <option value="3" selected>empleado</option>
                            <option value="1">admin</option>
                            <option value="2">supervisor</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Agregar Productos</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="producto_id">Producto</label>
                        <select id="producto_id" name="producto_id">
                            <option value="">Seleccione producto</option>
                            <option value="1">Arroz kg - $25.00</option>
                            <option value="2">Frijol kg - $32.00</option>
                            <option value="3">Aceite lt - $45.00</option>
                            <option value="6">Leche entera lt - $22.00</option>
                            <option value="9">Coca-Cola 600ml - $18.00</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" step="0.01" min="0.01" value="1">
                    </div>

                    <div class="form-group">
                        <label for="precio">Precio Unitario</label>
                        <input type="number" id="precio" name="precio" step="0.01" min="0" readonly style="background: #ecf0f1;">
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
                <h4 class="section-title">Productos en el Ticket</h4>
                <div class="ticket-items-list" id="productos-agregados">
                    <div class="ticket-item-row">
                        <div class="item-info">
                            <h4>Arroz kg</h4>
                            <div class="item-details">Cantidad: 2 | Precio: $25.00</div>
                        </div>
                        <div class="item-total">$50.00</div>
                    </div>
                    <div class="ticket-item-row">
                        <div class="item-info">
                            <h4>Leche entera lt</h4>
                            <div class="item-details">Cantidad: 1 | Precio: $22.00</div>
                        </div>
                        <div class="item-total">$22.00</div>
                    </div>
                </div>

                <div class="ticket-summary">
                    <div class="summary-grid">
                        <div class="summary-item">
                            <div class="summary-value">2</div>
                            <div class="summary-label">Productos</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value">3</div>
                            <div class="summary-label">Total Unidades</div>
                        </div>
                        <div class="summary-item">
                            <div class="summary-value">$72.00</div>
                            <div class="summary-label">Total Ticket</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista Previa del Ticket -->
            <div class="form-section">
                <h4 class="section-title">Vista Previa del Ticket</h4>
                <div class="ticket-preview">
                    <div class="ticket-header">
                        <h3>Abarrotes Wili</h3>
                        <p>Folio: TICK-026</p>
                        <p>Fecha: 25/10/2024 14:30</p>
                    </div>
                    <div class="ticket-items">
                        <div class="ticket-item">
                            <span>Arroz kg x2</span>
                            <span>$50.00</span>
                        </div>
                        <div class="ticket-item">
                            <span>Leche entera lt x1</span>
                            <span>$22.00</span>
                        </div>
                    </div>
                    <div class="ticket-total">
                        <span>TOTAL:</span>
                        <span>$72.00</span>
                    </div>
                    <div class="ticket-footer">
                        <p>¡Gracias por su compra!</p>
                        <p>Vuelva pronto</p>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar Todo
                </button>
                <button type="button" class="btn btn-info" onclick="imprimirTicket()">
                    <i>🖨️</i> Imprimir Ticket
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Guardar Ticket
                </button>
            </div>
        </form>
    </div>

    <!-- Historial de Tickets -->
    <div id="historial-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Historial de Tickets</h3>
            <button class="btn btn-primary" onclick="exportarTickets()">
                <i>📄</i> Exportar Reporte
            </button>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar por folio, cliente...">
            <button>🔍 Buscar</button>
        </div>

        <table>
            <thead>
            <tr>
                <th>Folio</th>
                <th>Fecha/Hora</th>
                <th>Cliente</th>
                <th>Vendedor</th>
                <th>Total</th>
                <th>Método Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>TICK-025</td>
                <td>25/10/2024 12:15</td>
                <td>Luis Sánchez</td>
                <td>empleado</td>
                <td>$175.00</td>
                <td><span class="payment-badge payment-efectivo">Efectivo</span></td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🖨️</i> Reimprimir
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>TICK-024</td>
                <td>25/10/2024 11:30</td>
                <td>Ana Martínez</td>
                <td>empleado</td>
                <td>$155.00</td>
                <td><span class="payment-badge payment-efectivo">Efectivo</span></td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🖨️</i> Reimprimir
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>TICK-023</td>
                <td>25/10/2024 10:45</td>
                <td>Pedro Ramírez</td>
                <td>empleado</td>
                <td>$80.00</td>
                <td><span class="payment-badge payment-efectivo">Efectivo</span></td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🖨️</i> Reimprimir
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>TICK-022</td>
                <td>24/10/2024 16:20</td>
                <td>María García</td>
                <td>empleado</td>
                <td>$135.00</td>
                <td><span class="payment-badge payment-credito">Crédito</span></td>
                <td><span class="status-badge status-completado">Completado</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🖨️</i> Reimprimir
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Búsqueda de Tickets -->
    <div id="busqueda-tab" class="table-container" style="display: none;">
        <h3 class="form-title">Búsqueda Avanzada de Tickets</h3>

        <div class="form-grid">
            <div class="form-group">
                <label for="busqueda_folio">Folio</label>
                <input type="text" id="busqueda_folio" placeholder="Buscar por folio...">
            </div>
            <div class="form-group">
                <label for="busqueda_cliente">Cliente</label>
                <input type="text" id="busqueda_cliente" placeholder="Buscar por cliente...">
            </div>
            <div class="form-group">
                <label for="busqueda_fecha">Fecha</label>
                <input type="date" id="busqueda_fecha">
            </div>
            <div class="form-group">
                <label for="busqueda_metodo">Método de Pago</label>
                <select id="busqueda_metodo">
                    <option value="">Todos los métodos</option>
                    <option value="1">Efectivo</option>
                    <option value="2">Crédito</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-secondary" onclick="limpiarBusqueda()">
                <i>🗑️</i> Limpiar
            </button>
            <button class="btn btn-primary" onclick="ejecutarBusqueda()">
                <i>🔍</i> Buscar
            </button>
        </div>
    </div>
</main>

<script>
    // Funcionalidad de tabs
    function showTab(tabName) {
        // Ocultar todos los tabs
        document.getElementById('nuevo-tab').style.display = 'none';
        document.getElementById('historial-tab').style.display = 'none';
        document.getElementById('busqueda-tab').style.display = 'none';

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
        1: { nombre: "Arroz kg", precio: 25.00 },
        2: { nombre: "Frijol kg", precio: 32.00 },
        3: { nombre: "Aceite lt", precio: 45.00 },
        6: { nombre: "Leche entera lt", precio: 22.00 },
        9: { nombre: "Coca-Cola 600ml", precio: 18.00 }
    };

    // Actualizar precio cuando se selecciona producto
    document.getElementById('producto_id').addEventListener('change', function() {
        const productoId = this.value;
        const producto = productos[productoId];

        if (producto) {
            document.getElementById('precio').value = producto.precio;
        } else {
            document.getElementById('precio').value = '';
        }
    });

    let productosAgregados = [
        { id: 1, nombre: "Arroz kg", precio: 25.00, cantidad: 2, total: 50.00 },
        { id: 6, nombre: "Leche entera lt", precio: 22.00, cantidad: 1, total: 22.00 }
    ];

    function agregarProducto() {
        const productoId = document.getElementById('producto_id').value;
        const cantidad = document.getElementById('cantidad').value;
        const precio = document.getElementById('precio').value;

        if (productoId && cantidad && precio) {
            const producto = productos[productoId];
            const total = precio * cantidad;

            productosAgregados.push({
                id: productoId,
                nombre: producto.nombre,
                precio: parseFloat(precio),
                cantidad: parseFloat(cantidad),
                total: total
            });

            actualizarListaProductos();
            actualizarVistaPrevia();
            limpiarCamposProducto();
        } else {
            alert('Por favor complete todos los campos del producto');
        }
    }

    function actualizarListaProductos() {
        const container = document.getElementById('productos-agregados');
        container.innerHTML = '';

        let totalUnidades = 0;
        let totalTicket = 0;

        productosAgregados.forEach(producto => {
            const item = document.createElement('div');
            item.className = 'ticket-item-row';
            item.innerHTML = `
                    <div class="item-info">
                        <h4>${producto.nombre}</h4>
                        <div class="item-details">Cantidad: ${producto.cantidad} | Precio: $${producto.precio.toFixed(2)}</div>
                    </div>
                    <div class="item-total">$${producto.total.toFixed(2)}</div>
                `;
            container.appendChild(item);

            totalUnidades += producto.cantidad;
            totalTicket += producto.total;
        });

        // Actualizar resumen
        document.querySelector('.ticket-summary .summary-grid').innerHTML = `
                <div class="summary-item">
                    <div class="summary-value">${productosAgregados.length}</div>
                    <div class="summary-label">Productos</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">${totalUnidades}</div>
                    <div class="summary-label">Total Unidades</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value">$${totalTicket.toFixed(2)}</div>
                    <div class="summary-label">Total Ticket</div>
                </div>
            `;
    }

    function actualizarVistaPrevia() {
        const ticketItems = document.querySelector('.ticket-items');
        let totalTicket = 0;

        ticketItems.innerHTML = '';

        productosAgregados.forEach(producto => {
            const item = document.createElement('div');
            item.className = 'ticket-item';
            item.innerHTML = `
                    <span>${producto.nombre} x${producto.cantidad}</span>
                    <span>$${producto.total.toFixed(2)}</span>
                `;
            ticketItems.appendChild(item);
            totalTicket += producto.total;
        });

        document.querySelector('.ticket-total').innerHTML = `
                <span>TOTAL:</span>
                <span>$${totalTicket.toFixed(2)}</span>
            `;
    }

    function limpiarCamposProducto() {
        document.getElementById('producto_id').value = '';
        document.getElementById('cantidad').value = '1';
        document.getElementById('precio').value = '';
    }

    function limpiarFormulario() {
        productosAgregados = [];
        actualizarListaProductos();
        actualizarVistaPrevia();
        limpiarCamposProducto();
        document.getElementById('ticketForm').reset();
        document.getElementById('folio').value = 'TICK-026';
    }

    function imprimirTicket() {
        alert('Imprimiendo ticket...');
        // Aquí iría la lógica para imprimir el ticket
    }

    // Manejar envío del formulario
    document.getElementById('ticketForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (productosAgregados.length > 0) {
            alert('Ticket guardado exitosamente!');
            // Aquí se generaría un nuevo folio automáticamente
            const nuevoFolio = 'TICK-' + (parseInt(document.getElementById('folio').value.split('-')[1]) + 1).toString().padStart(3, '0');
            document.getElementById('folio').value = nuevoFolio;
            limpiarFormulario();
        } else {
            alert('Por favor agregue al menos un producto al ticket');
        }
    });

    function exportarTickets() {
        alert('Generando reporte de tickets...');
    }

    function ejecutarBusqueda() {
        alert('Ejecutando búsqueda...');
    }

    function limpiarBusqueda() {
        document.getElementById('busqueda_folio').value = '';
        document.getElementById('busqueda_cliente').value = '';
        document.getElementById('busqueda_fecha').value = '';
        document.getElementById('busqueda_metodo').value = '';
    }

    // Inicializar
    actualizarListaProductos();
    actualizarVistaPrevia();

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
