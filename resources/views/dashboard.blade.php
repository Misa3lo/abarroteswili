<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Abarrotes Wili</title>
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
            justify-content: between;
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

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
        }

        .stat-card.sales {
            border-left-color: #27ae60;
        }

        .stat-card.inventory {
            border-left-color: #e74c3c;
        }

        .stat-card.credits {
            border-left-color: #f39c12;
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

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            background: #f8f9fa;
            border: 2px solid #e9ecef;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            color: #2c3e50;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .action-btn:hover {
            background: #3498db;
            color: white;
            border-color: #3498db;
            transform: translateY(-2px);
        }

        .action-btn i {
            font-size: 24px;
            margin-bottom: 10px;
            display: block;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ecf0f1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .activity-time {
            color: #7f8c8d;
            font-size: 12px;
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
            <a href="/dashboard" class="nav-link active">
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
        <h2>Dashboard Principal</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
            <button class="btn btn-primary" onclick="location.href='/punto-de-venta'">
                Nueva Venta
            </button>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card sales">
            <div class="stat-number">$12,458</div>
            <div class="stat-label">Ventas del Día</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">1,247</div>
            <div class="stat-label">Productos en Inventario</div>
        </div>
        <div class="stat-card inventory">
            <div class="stat-number">23</div>
            <div class="stat-label">Productos con Stock Bajo</div>
        </div>
        <div class="stat-card credits">
            <div class="stat-number">$3,850</div>
            <div class="stat-label">Créditos Pendientes</div>
        </div>
    </div>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <h3 class="section-title">Acciones Rápidas</h3>
        <div class="action-grid">
            <a href="/punto-de-venta" class="action-btn">
                <i>🛒</i>
                Nueva Venta
            </a>
            <a href="/productos" class="action-btn">
                <i>📝</i>
                Registrar Producto
            </a>
            <a href="/clientes" class="action-btn">
                <i>➕</i>
                Agregar Cliente
            </a>
            <a href="/surtidos" class="action-btn">
                <i>📦</i>
                Realizar Surtido
            </a>
            <a href="/creditos" class="action-btn">
                <i>💵</i>
                Registrar Abono
            </a>
            <a href="/gestion-inventario" class="action-btn">
                <i>📊</i>
                Ver Reportes
            </a>
        </div>
    </section>

    <!-- Recent Activity -->
    <section class="recent-activity">
        <h3 class="section-title">Actividad Reciente</h3>
        <ul class="activity-list">
            <li class="activity-item">
                <div class="activity-icon">🛒</div>
                <div class="activity-content">
                    <div class="activity-title">Venta realizada - Ticket #T025</div>
                    <div class="activity-time">Hace 5 minutos - $175.00</div>
                </div>
            </li>
            <li class="activity-item">
                <div class="activity-icon">📦</div>
                <div class="activity-content">
                    <div class="activity-title">Surtido registrado - Arroz (50 unidades)</div>
                    <div class="activity-time">Hace 2 horas</div>
                </div>
            </li>
            <li class="activity-item">
                <div class="activity-icon">💵</div>
                <div class="activity-content">
                    <div class="activity-title">Abono registrado - Cliente Juan Pérez</div>
                    <div class="activity-time">Hace 3 horas - $50.00</div>
                </div>
            </li>
            <li class="activity-item">
                <div class="activity-icon">👥</div>
                <div class="activity-content">
                    <div class="activity-title">Nuevo cliente registrado - María García</div>
                    <div class="activity-time">Hace 5 horas</div>
                </div>
            </li>
        </ul>
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
</script>
</body>
</html>
