<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Departamentos - Abarrotes Wili</title>
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

        .stat-card.abarrotes {
            border-left-color: #e74c3c;
        }

        .stat-card.lacteos {
            border-left-color: #3498db;
        }

        .stat-card.bebidas {
            border-left-color: #27ae60;
        }

        .stat-card.limpieza {
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
            grid-template-columns: 1fr;
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

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
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

        /* Department Cards */
        .departments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .department-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .department-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .department-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .department-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .department-products {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }

        .department-description {
            color: #5d6d7e;
            font-size: 14px;
            line-height: 1.5;
        }

        .department-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
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
            <a href="/departamentos" class="nav-link active">
                <i>📁</i> Departamentos
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
        <h2>Gestión de Departamentos</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card abarrotes">
            <div class="stat-number">5</div>
            <div class="stat-label">Productos en Abarrotes</div>
        </div>
        <div class="stat-card lacteos">
            <div class="stat-number">3</div>
            <div class="stat-label">Productos en Lácteos</div>
        </div>
        <div class="stat-card bebidas">
            <div class="stat-number">3</div>
            <div class="stat-label">Productos en Bebidas</div>
        </div>
        <div class="stat-card limpieza">
            <div class="stat-number">4</div>
            <div class="stat-label">Productos en Limpieza</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Departamento</div>
        <div class="tab" onclick="showTab('lista')">Lista de Departamentos</div>
        <div class="tab" onclick="showTab('vista')">Vista de Tarjetas</div>
    </div>

    <!-- Formulario de Nuevo Departamento -->
    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Departamento</h3>
        <form id="departamentoForm">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre">Nombre del Departamento *</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Botanas, Panadería, Carnes..." required>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción *</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Describa los tipos de productos que incluye este departamento..." required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Departamento
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Departamentos -->
    <div id="lista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Departamentos Registrados</h3>
            <button class="btn btn-primary" onclick="exportarDepartamentos()">
                <i>📄</i> Exportar Lista
            </button>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar departamento...">
            <button>🔍 Buscar</button>
        </div>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Productos</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>Abarrotes</td>
                <td>Productos básicos de consumo diario</td>
                <td>5 productos</td>
                <td><span class="status-badge status-active">Activo</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Lácteos</td>
                <td>Leche, quesos, yogures y derivados</td>
                <td>3 productos</td>
                <td><span class="status-badge status-active">Activo</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Bebidas</td>
                <td>Refrescos, jugos, aguas y bebidas energéticas</td>
                <td>3 productos</td>
                <td><span class="status-badge status-active">Activo</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🗑️</i> Eliminar
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td>Limpieza</td>
                <td>Productos de limpieza y aseo personal</td>
                <td>4 productos</td>
                <td><span class="status-badge status-active">Activo</span></td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
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

    <!-- Vista de Tarjetas -->
    <div id="vista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Departamentos - Vista de Tarjetas</h3>
            <button class="btn btn-primary" onclick="location.href='/productos'">
                <i>🏷️</i> Ver Productos
            </button>
        </div>

        <div class="departments-grid">
            <div class="department-card">
                <div class="department-header">
                    <div class="department-name">Abarrotes</div>
                    <span class="status-badge status-active">Activo</span>
                </div>
                <div class="department-products">5 productos registrados</div>
                <div class="department-description">
                    Productos básicos de consumo diario como arroz, frijol, aceite, azúcar y sal.
                </div>
                <div class="department-actions">
                    <button class="btn btn-primary btn-sm">
                        <i>👁️</i> Ver Productos
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                </div>
            </div>

            <div class="department-card">
                <div class="department-header">
                    <div class="department-name">Lácteos</div>
                    <span class="status-badge status-active">Activo</span>
                </div>
                <div class="department-products">3 productos registrados</div>
                <div class="department-description">
                    Leche, quesos, yogures y productos derivados de la leche.
                </div>
                <div class="department-actions">
                    <button class="btn btn-primary btn-sm">
                        <i>👁️</i> Ver Productos
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                </div>
            </div>

            <div class="department-card">
                <div class="department-header">
                    <div class="department-name">Bebidas</div>
                    <span class="status-badge status-active">Activo</span>
                </div>
                <div class="department-products">3 productos registrados</div>
                <div class="department-description">
                    Refrescos, jugos naturales, aguas purificadas y bebidas energéticas.
                </div>
                <div class="department-actions">
                    <button class="btn btn-primary btn-sm">
                        <i>👁️</i> Ver Productos
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                </div>
            </div>

            <div class="department-card">
                <div class="department-header">
                    <div class="department-name">Limpieza</div>
                    <span class="status-badge status-active">Activo</span>
                </div>
                <div class="department-products">4 productos registrados</div>
                <div class="department-description">
                    Productos de limpieza para el hogar y artículos de aseo personal.
                </div>
                <div class="department-actions">
                    <button class="btn btn-primary btn-sm">
                        <i>👁️</i> Ver Productos
                    </button>
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Funcionalidad de tabs
    function showTab(tabName) {
        // Ocultar todos los tabs
        document.getElementById('nuevo-tab').style.display = 'none';
        document.getElementById('lista-tab').style.display = 'none';
        document.getElementById('vista-tab').style.display = 'none';

        // Remover clase active de todos los tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Mostrar tab seleccionado y agregar clase active
        document.getElementById(tabName + '-tab').style.display = 'block';
        event.target.classList.add('active');
    }

    // Manejar envío del formulario
    document.getElementById('departamentoForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const descripcion = document.getElementById('descripcion').value;

        if (nombre && descripcion) {
            alert('Departamento registrado exitosamente!');
            limpiarFormulario();
        } else {
            alert('Por favor complete todos los campos requeridos');
        }
    });

    function limpiarFormulario() {
        document.getElementById('departamentoForm').reset();
    }

    function exportarDepartamentos() {
        alert('Generando reporte de departamentos...');
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
