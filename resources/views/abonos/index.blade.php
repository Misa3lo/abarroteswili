<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Abonos - Abarrotes Wili</title>
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

        /* Form Styles */
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
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

        /* Table Styles */
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .table-header {
            display: flex;
            justify-content: between;
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

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
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
            <a href="/creditos" class="nav-link">
                <i>💳</i> Créditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/abonos" class="nav-link active">
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
        <h2>Gestión de Abonos</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Formulario de Registro -->
    <div class="form-container">
        <h3 class="form-title">Registrar Nuevo Abono</h3>
        <form id="abonoForm">
            <div class="form-grid">
                <div class="form-group">
                    <label for="credito_id">Crédito *</label>
                    <select id="credito_id" name="credito_id" required>
                        <option value="">Seleccione un crédito</option>
                        <option value="1">Juan Pérez - $220.00 Pendiente</option>
                        <option value="2">María García - $95.00 Pendiente</option>
                        <option value="3">Pedro Ramírez - $210.00 Pendiente</option>
                        <option value="4">Ana Martínez - $88.00 Pendiente</option>
                        <option value="5">Luis Sánchez - $200.00 Pendiente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cliente_info">Información del Cliente</label>
                    <input type="text" id="cliente_info" readonly value="Seleccione un crédito" style="background: #ecf0f1;">
                </div>

                <div class="form-group">
                    <label for="adeudo_actual">Adeudo Actual</label>
                    <input type="text" id="adeudo_actual" readonly value="$0.00" style="background: #ecf0f1;">
                </div>

                <div class="form-group">
                    <label for="abono">Monto del Abono *</label>
                    <input type="number" id="abono" name="abono" step="0.01" min="0.01" placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label for="fecha_hora">Fecha y Hora</label>
                    <input type="text" id="fecha_hora" readonly value="Se registrará automáticamente" style="background: #ecf0f1;">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Abono
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Abonos -->
    <div class="table-container">
        <div class="table-header">
            <h3>Historial de Abonos</h3>
            <button class="btn btn-primary" onclick="exportarReporte()">
                <i>📄</i> Exportar Reporte
            </button>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Crédito ID</th>
                <th>Monto Abono</th>
                <th>Fecha/Hora</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Juan Pérez</td>
                <td>CR-001</td>
                <td>$50.00</td>
                <td>25/10/2024 10:30</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>María García</td>
                <td>CR-002</td>
                <td>$25.00</td>
                <td>25/10/2024 09:15</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Pedro Ramírez</td>
                <td>CR-003</td>
                <td>$60.00</td>
                <td>24/10/2024 16:45</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-primary btn-sm">
                            <i>👁️</i> Ver
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</main>

<script>
    // Simulación de datos de créditos
    const creditos = {
        1: { cliente: "Juan Pérez", adeudo: 220.00 },
        2: { cliente: "María García", adeudo: 95.00 },
        3: { cliente: "Pedro Ramírez", adeudo: 210.00 },
        4: { cliente: "Ana Martínez", adeudo: 88.00 },
        5: { cliente: "Luis Sánchez", adeudo: 200.00 }
    };

    // Actualizar información cuando se selecciona un crédito
    document.getElementById('credito_id').addEventListener('change', function() {
        const creditoId = this.value;
        const credito = creditos[creditoId];

        if (credito) {
            document.getElementById('cliente_info').value = credito.cliente;
            document.getElementById('adeudo_actual').value = `$${credito.adeudo.toFixed(2)}`;
        } else {
            document.getElementById('cliente_info').value = "Seleccione un crédito";
            document.getElementById('adeudo_actual').value = "$0.00";
        }
    });

    // Manejar envío del formulario
    document.getElementById('abonoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const creditoId = document.getElementById('credito_id').value;
        const abono = document.getElementById('abono').value;

        if (creditoId && abono > 0) {
            alert('Abono registrado exitosamente!');
            limpiarFormulario();
            // Aquí iría la lógica para enviar los datos al servidor
        } else {
            alert('Por favor complete todos los campos requeridos');
        }
    });

    function limpiarFormulario() {
        document.getElementById('abonoForm').reset();
        document.getElementById('cliente_info').value = "Seleccione un crédito";
        document.getElementById('adeudo_actual').value = "$0.00";
    }

    function exportarReporte() {
        alert('Generando reporte de abonos...');
        // Aquí iría la lógica para exportar el reporte
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
