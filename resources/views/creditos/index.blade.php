<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Créditos - Abarrotes Wili</title>
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

        .stat-card.pendiente {
            border-left-color: #e74c3c;
        }

        .stat-card.pagado {
            border-left-color: #27ae60;
        }

        .stat-card.vencido {
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

        .status-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .status-pagado {
            background: #d4edda;
            color: #155724;
        }

        .status-vencido {
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

        .credit-info {
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
            <a href="/clientes" class="nav-link">
                <i>👥</i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a href="/creditos" class="nav-link active">
                <i>💳</i> Créditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/abonos" class="nav-link">
                <i>💵</i> Abonos
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
        <h2>Gestión de Créditos</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number">$3,850</div>
            <div class="stat-label">Total en Créditos</div>
        </div>
        <div class="stat-card pendiente">
            <div class="stat-number">$2,150</div>
            <div class="stat-label">Pendiente por Cobrar</div>
        </div>
        <div class="stat-card pagado">
            <div class="stat-number">$1,700</div>
            <div class="stat-label">Total Pagado</div>
        </div>
        <div class="stat-card vencido">
            <div class="stat-number">$450</div>
            <div class="stat-label">Créditos Vencidos</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Crédito</div>
        <div class="tab" onclick="showTab('lista')">Lista de Créditos</div>
        <div class="tab" onclick="showTab('reportes')">Reportes</div>
    </div>

    <!-- Formulario de Nuevo Crédito -->
    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Crédito</h3>
        <form id="creditoForm">
            <div class="form-grid">
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
                    <label for="ticket_id">Ticket Relacionado</label>
                    <select id="ticket_id" name="ticket_id">
                        <option value="">Seleccione un ticket</option>
                        <option value="1">TICK-003 - $220.00</option>
                        <option value="2">TICK-006 - $95.00</option>
                        <option value="3">TICK-009 - $210.00</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="limite_credito">Límite de Crédito del Cliente</label>
                    <input type="text" id="limite_credito" readonly value="$1,000.00" style="background: #ecf0f1;">
                </div>

                <div class="form-group">
                    <label for="adeudo">Monto del Adeudo *</label>
                    <input type="number" id="adeudo" name="adeudo" step="0.01" min="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento">
                </div>

                <div class="form-group">
                    <label for="estado">Estado del Crédito</label>
                    <select id="estado" name="estado">
                        <option value="pendiente">Pendiente</option>
                        <option value="pagado">Pagado</option>
                        <option value="vencido">Vencido</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Crédito
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Créditos -->
    <div id="lista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Créditos Registrados</h3>
            <button class="btn btn-primary" onclick="exportarCreditos()">
                <i>📄</i> Exportar Reporte
            </button>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar por cliente, estado...">
            <button>🔍 Buscar</button>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Ticket</th>
                <th>Adeudo Total</th>
                <th>Pagado</th>
                <th>Saldo Pendiente</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Juan Pérez López</td>
                <td>TICK-003</td>
                <td>$220.00</td>
                <td>$80.00</td>
                <td>$140.00</td>
                <td><span class="status-badge status-pendiente">Pendiente</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="location.href='/abonos'">
                            <i>💵</i> Abonar
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>María García Hernández</td>
                <td>TICK-006</td>
                <td>$95.00</td>
                <td>$45.00</td>
                <td>$50.00</td>
                <td><span class="status-badge status-pendiente">Pendiente</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="location.href='/abonos'">
                            <i>💵</i> Abonar
                        </button>
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Pedro Ramírez Torres</td>
                <td>TICK-009</td>
                <td>$210.00</td>
                <td>$100.00</td>
                <td>$110.00</td>
                <td><span class="status-badge status-pendiente">Pendiente</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm" onclick="location.href='/abonos'">
                            <i>💵</i> Abonar
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

    <!-- Reportes -->
    <div id="reportes-tab" class="table-container" style="display: none;">
        <h3 class="form-title">Reportes de Créditos</h3>

        <div class="credit-info">
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Total de Créditos Activos:</span>
                    <span class="info-value">8</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Monto Total Pendiente:</span>
                    <span class="info-value">$2,150.00</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Clientes con Crédito:</span>
                    <span class="info-value">6</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Promedio por Crédito:</span>
                    <span class="info-value">$268.75</span>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" onclick="generarReporte('pendientes')">
                <i>📊</i> Reporte de Pendientes
            </button>
            <button class="btn btn-warning" onclick="generarReporte('vencidos')">
                <i>⚠️</i> Reporte de Vencidos
            </button>
            <button class="btn btn-secondary" onclick="generarReporte('completo')">
                <i>📋</i> Reporte Completo
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
        document.getElementById('reportes-tab').style.display = 'none';

        // Remover clase active de todos los tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Mostrar tab seleccionado y agregar clase active
        document.getElementById(tabName + '-tab').style.display = 'block';
        event.target.classList.add('active');
    }

    // Simulación de datos de clientes
    const clientes = {
        1: { limite_credito: 1000.00 },
        2: { limite_credito: 500.00 },
        3: { limite_credito: 1500.00 },
        4: { limite_credito: 800.00 },
        5: { limite_credito: 2000.00 }
    };

    // Actualizar información cuando se selecciona un cliente
    document.getElementById('cliente_id').addEventListener('change', function() {
        const clienteId = this.value;
        const cliente = clientes[clienteId];

        if (cliente) {
            document.getElementById('limite_credito').value = `$${cliente.limite_credito.toFixed(2)}`;
        } else {
            document.getElementById('limite_credito').value = "$0.00";
        }
    });

    // Manejar envío del formulario
    document.getElementById('creditoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const clienteId = document.getElementById('cliente_id').value;
        const adeudo = document.getElementById('adeudo').value;

        if (clienteId && adeudo > 0) {
            alert('Crédito registrado exitosamente!');
            limpiarFormulario();
        } else {
            alert('Por favor complete todos los campos requeridos');
        }
    });

    function limpiarFormulario() {
        document.getElementById('creditoForm').reset();
        document.getElementById('limite_credito').value = "$0.00";
    }

    function exportarCreditos() {
        alert('Generando reporte de créditos...');
    }

    function generarReporte(tipo) {
        alert(`Generando reporte de créditos ${tipo}...`);
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
