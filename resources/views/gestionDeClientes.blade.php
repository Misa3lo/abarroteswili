<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Abarrotes Wili</title>
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

        /* Formulario de Cliente */
        .client-form {
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

        /* Tabla de Clientes */
        .clients-table {
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

        .client-name {
            font-weight: 500;
            color: #2c3e50;
        }

        .client-phone {
            color: #7f8c8d;
            font-size: 14px;
        }

        .credit-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }

        .credit-status.active {
            background: #d4edda;
            color: #155724;
        }

        .credit-status.limited {
            background: #fff3cd;
            color: #856404;
        }

        .credit-status.none {
            background: #f8d7da;
            color: #721c24;
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

        .btn-credits {
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
            <a href="/gestion-inventario" class="nav-link">
                <i>📦</i> Inventario
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-clientes" class="nav-link active">
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
        <h2>Gestión de Clientes</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
            <button class="btn btn-primary" onclick="showClientForm()">
                <i>➕</i> Nuevo Cliente
            </button>
        </div>
    </header>

    <!-- Formulario de Cliente -->
    <section class="client-form" id="clientForm">
        <h3 class="form-title">Registrar Nuevo Cliente</h3>
        <div class="form-grid">
            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" id="nombre" class="form-control" placeholder="Ingrese el nombre">
            </div>
            <div class="form-group">
                <label for="apaterno">Apellido Paterno *</label>
                <input type="text" id="apaterno" class="form-control" placeholder="Apellido paterno">
            </div>
            <div class="form-group">
                <label for="amaterno">Apellido Materno</label>
                <input type="text" id="amaterno" class="form-control" placeholder="Apellido materno">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" class="form-control" placeholder="Número de teléfono">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea id="direccion" class="form-control" rows="2" placeholder="Dirección completa"></textarea>
            </div>
            <div class="form-group">
                <label for="limite-credito">Límite de Crédito</label>
                <input type="number" id="limite-credito" class="form-control" placeholder="0.00" step="0.01">
            </div>
        </div>
        <div class="form-actions">
            <button type="button" class="btn" onclick="hideClientForm()">Cancelar</button>
            <button type="button" class="btn btn-success">Guardar Cliente</button>
        </div>
    </section>

    <!-- Búsqueda -->
    <section class="search-section">
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar cliente por nombre, teléfono o dirección...">
            <button class="btn btn-primary">Buscar</button>
            <button class="btn" style="background: #6c757d; color: white;">Limpiar</button>
        </div>
    </section>

    <!-- Tabla de Clientes -->
    <section class="clients-table">
        <div class="table-header">
            <h3>Lista de Clientes Registrados</h3>
            <div class="table-actions">
                <button class="btn" style="background: #6c757d; color: white;">
                    <i>📥</i> Exportar
                </button>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Contacto</th>
                    <th>Dirección</th>
                    <th>Límite Crédito</th>
                    <th>Estado Crédito</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>CL001</td>
                    <td>
                        <div class="client-name">Juan Pérez López</div>
                    </td>
                    <td>
                        <div class="client-phone">5512345678</div>
                    </td>
                    <td>Calle 1, Col. Centro</td>
                    <td>$1,000.00</td>
                    <td><span class="credit-status active">Activo</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-credits">Créditos</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>CL002</td>
                    <td>
                        <div class="client-name">María García Hernández</div>
                    </td>
                    <td>
                        <div class="client-phone">5523486789</div>
                    </td>
                    <td>Calle 2, Col. Norte</td>
                    <td>$500.00</td>
                    <td><span class="credit-status limited">Limitado</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-credits">Créditos</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>CL003</td>
                    <td>
                        <div class="client-name">Pedro Ramírez Torres</div>
                    </td>
                    <td>
                        <div class="client-phone">5534567800</div>
                    </td>
                    <td>Calle 3, Col. Sur</td>
                    <td>$2,000.00</td>
                    <td><span class="credit-status active">Activo</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-credits">Créditos</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>CL004</td>
                    <td>
                        <div class="client-name">Ana Martínez Ruiz</div>
                    </td>
                    <td>
                        <div class="client-phone">5545678001</div>
                    </td>
                    <td>Calle 4, Col. Este</td>
                    <td>$0.00</td>
                    <td><span class="credit-status none">Sin crédito</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-credits">Créditos</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>CL005</td>
                    <td>
                        <div class="client-name">Luis Sánchez Jiménez</div>
                    </td>
                    <td>
                        <div class="client-phone">5568780012</div>
                    </td>
                    <td>Calle 5, Col. Oeste</td>
                    <td>$750.00</td>
                    <td><span class="credit-status limited">Limitado</span></td>
                    <td>
                        <div class="action-btns">
                            <button class="action-btn btn-edit">Editar</button>
                            <button class="action-btn btn-credits">Créditos</button>
                            <button class="action-btn btn-delete">Eliminar</button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <div class="page-info">Mostrando 1-5 de 25 clientes</div>
            <div class="page-numbers">
                <span class="page-number active">1</span>
                <span class="page-number">2</span>
                <span class="page-number">3</span>
                <span class="page-number">4</span>
                <span class="page-number">5</span>
            </div>
        </div>
    </section>
</main>

<script>
    // Mostrar/ocultar formulario
    function showClientForm() {
        document.getElementById('clientForm').style.display = 'block';
    }

    function hideClientForm() {
        document.getElementById('clientForm').style.display = 'none';
    }

    // Ocultar formulario inicialmente
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('clientForm').style.display = 'none';
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
            alert('Editar cliente - Funcionalidad en desarrollo');
        });
    });

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            if(confirm('¿Está seguro de eliminar este cliente?')) {
                alert('Cliente eliminado');
            }
        });
    });
</script>
</body>
</html>
