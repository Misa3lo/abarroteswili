<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Métodos de Pago - Abarrotes Wili</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .nav-link {
            color: #bdc3c7;
            padding: 12px 15px;
            border-radius: 8px;
        }
        .nav-link:hover, .nav-link.active {
            background: #34495e;
            color: white;
        }
<<<<<<< HEAD
=======

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .nav-link.hidden {
            display: none;
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

        .action-btn.hidden {
            display: none;
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

        /* Badge de rol */
        .role-badge {
            background: #f39c12;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
    </style>
</head>
<body>
<!-- Sidebar -->
<nav class="sidebar">
    <div class="logo text-center py-3 border-bottom">
        <h4>Abarrotes <span class="text-primary">Wili</span></h4>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">📊 Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="/metodos-pago" class="nav-link active">💳 Métodos de Pago</a>
        </li>
        <li class="nav-item">
<<<<<<< HEAD
            <a href="/productos" class="nav-link">🏷️ Productos</a>
        </li>
        <li class="nav-item">
            <a href="/ventas" class="nav-link">💰 Ventas</a>
=======
            <a href="/gestion-inventario" class="nav-link" id="nav-inventario">
                <i>📦</i> Inventario
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-clientes" class="nav-link" id="nav-clientes">
                <i>👥</i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a href="/productos" class="nav-link" id="nav-productos">
                <i>🏷️</i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a href="/ventas" class="nav-link" id="nav-ventas">
                <i>💰</i> Ventas
            </a>
        </li>
        <li class="nav-item">
            <a href="/creditos" class="nav-link" id="nav-creditos">
                <i>💳</i> Créditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/usuarios" class="nav-link" id="nav-usuarios">
                <i>👤</i> Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a href="/surtidos" class="nav-link" id="nav-surtidos">
                <i>🚚</i> Surtidos
            </a>
        </li>
        <li class="nav-item">
            <a href="/login" class="nav-link" style="color: #e74c3c;">
                <i>🚪</i> Cerrar Sesión
            </a>
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
        </li>
    </ul>
</nav>

<!-- Main Content -->
<main class="main-content">
<<<<<<< HEAD
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>💳 Métodos de Pago</h2>
            <a href="{{ route('metodos-pago.create') }}" class="btn btn-primary mb-3">➕ Nuevo Método</a>
                ➕ Nuevo Método de Pago
            </a>
=======
    <!-- Header -->
    <header class="header">
        <h2>Dashboard Principal</h2>
        <div class="user-info">
            <div class="user-avatar" id="userAvatar">AW</div>
            <span id="userName">Administrador</span>
            <span class="role-badge" id="userRole">Administrador</span>
            <button class="btn btn-primary" onclick="location.href='/punto-de-venta'">
                Nueva Venta
            </button>
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
        </div>

<<<<<<< HEAD
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                ✅ {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                ❌ {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($metodosPago as $metodo)
                            <tr>
                                <td>{{ $metodo->id }}</td>
                                <td>{{ $metodo->descripcion }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('metodo-pago.show', $metodo) }}" class="btn btn-info">
                                            👁️ Ver
                                        </a>
                                        <a href="{{ route('metodo-pago.edit', $metodo) }}" class="btn btn-warning">
                                            ✏️ Editar
                                        </a>
                                        <form action="{{ route('metodo-pago.destroy', $metodo) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('¿Eliminar {{ $metodo->descripcion }}?')">
                                                🗑️ Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
=======
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
        <div class="stat-card credits" id="stat-creditos">
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
            <a href="/productos" class="action-btn" id="action-registrar-producto">
                <i>📝</i>
                Registrar Producto
            </a>
            <a href="/clientes" class="action-btn" id="action-agregar-cliente">
                <i>➕</i>
                Agregar Cliente
            </a>
            <a href="/surtidos" class="action-btn" id="action-surtido">
                <i>📦</i>
                Realizar Surtido
            </a>
            <a href="/creditos" class="action-btn" id="action-abono">
                <i>💵</i>
                Registrar Abono
            </a>
            <a href="/gestion-inventario" class="action-btn" id="action-reportes">
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
            <li class="activity-item" id="activity-surtido">
                <div class="activity-icon">📦</div>
                <div class="activity-content">
                    <div class="activity-title">Surtido registrado - Arroz (50 unidades)</div>
                    <div class="activity-time">Hace 2 horas</div>
                </div>
            </li>
            <li class="activity-item" id="activity-abono">
                <div class="activity-icon">💵</div>
                <div class="activity-content">
                    <div class="activity-title">Abono registrado - Cliente Juan Pérez</div>
                    <div class="activity-time">Hace 3 horas - $50.00</div>
                </div>
            </li>
            <li class="activity-item" id="activity-cliente">
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
    // Función para determinar el rol del usuario (simulado)
    function getUserRole() {
        // En una aplicación real, esto vendría del backend
        // Por ahora, simulamos obteniendo de localStorage o usando un valor por defecto
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('rol') || localStorage.getItem('userRole') || 'empleado';
    }

    // Función para configurar la interfaz según el rol
    function setupInterfaceByRole() {
        const role = getUserRole();
        const userNameElement = document.getElementById('userName');
        const userRoleElement = document.getElementById('userRole');
        const userAvatar = document.getElementById('userAvatar');

        // Configurar información del usuario
        if (role === 'admin') {
            userNameElement.textContent = 'Administrador';
            userRoleElement.textContent = 'Administrador';
            userAvatar.textContent = 'A';
        } else if (role === 'supervisor') {
            userNameElement.textContent = 'Supervisor';
            userRoleElement.textContent = 'Supervisor';
            userAvatar.textContent = 'S';
        } else {
            userNameElement.textContent = 'Empleado';
            userRoleElement.textContent = 'Empleado';
            userAvatar.textContent = 'E';
        }

        // Configurar navegación según el rol
        const navigationRules = {
            'admin': {
                show: ['inventario', 'clientes', 'productos', 'ventas', 'creditos', 'usuarios', 'surtidos']
            },
            'supervisor': {
                show: ['inventario', 'clientes', 'productos', 'ventas', 'creditos', 'surtidos'],
                hide: ['usuarios']
            },
            'empleado': {
                show: ['ventas'],
                hide: ['inventario', 'clientes', 'productos', 'creditos', 'usuarios', 'surtidos']
            }
        };

        const rules = navigationRules[role] || navigationRules.empleado;

        // Aplicar reglas de navegación
        if (rules.show) {
            rules.show.forEach(item => {
                const element = document.getElementById(`nav-${item}`);
                if (element) element.classList.remove('hidden');
            });
        }
        if (rules.hide) {
            rules.hide.forEach(item => {
                const element = document.getElementById(`nav-${item}`);
                if (element) element.classList.add('hidden');
            });
        }

        // Configurar acciones rápidas según el rol
        const actionRules = {
            'admin': {
                show: ['registrar-producto', 'agregar-cliente', 'surtido', 'abono', 'reportes']
            },
            'supervisor': {
                show: ['registrar-producto', 'agregar-cliente', 'surtido', 'abono', 'reportes']
            },
            'empleado': {
                hide: ['registrar-producto', 'agregar-cliente', 'surtido', 'abono', 'reportes']
            }
        };

        const actionRuleset = actionRules[role] || actionRules.empleado;

        if (actionRuleset.show) {
            actionRuleset.show.forEach(action => {
                const element = document.getElementById(`action-${action}`);
                if (element) element.classList.remove('hidden');
            });
        }
        if (actionRuleset.hide) {
            actionRuleset.hide.forEach(action => {
                const element = document.getElementById(`action-${action}`);
                if (element) element.classList.add('hidden');
            });
        }

        // Ocultar estadísticas de créditos para empleados
        if (role === 'empleado') {
            document.getElementById('stat-creditos').style.display = 'none';
        }

        // Ocultar actividades según el rol
        if (role === 'empleado') {
            document.getElementById('activity-surtido').style.display = 'none';
            document.getElementById('activity-abono').style.display = 'none';
            document.getElementById('activity-cliente').style.display = 'none';
        }
    }

    // Inicializar la interfaz cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        setupInterfaceByRole();

        // Navegación activa
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });

    // Para testing: permitir cambiar rol desde la URL ?rol=admin|supervisor|empleado
    function changeRole(newRole) {
        localStorage.setItem('userRole', newRole);
        window.location.href = '/dashboard?rol=' + newRole;
    }
</script>
>>>>>>> af8d6ecd776bf85855ff9bef957bd9d7ae1026fc
</body>
</html>
