<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Abarrotes Wili</title>
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

        .stat-card.activos {
            border-left-color: #27ae60;
        }

        .stat-card.administradores {
            border-left-color: #e74c3c;
        }

        .stat-card.empleados {
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

        .status-activo {
            background: #d4edda;
            color: #155724;
        }

        .status-inactivo {
            background: #f8d7da;
            color: #721c24;
        }

        .role-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-admin {
            background: #e74c3c;
            color: white;
        }

        .role-empleado {
            background: #3498db;
            color: white;
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

        /* User Cards */
        .users-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .user-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #3498db;
            transition: all 0.3s ease;
        }

        .user-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .user-card.admin {
            border-left-color: #e74c3c;
        }

        .user-card.empleado {
            border-left-color: #3498db;
        }

        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .user-name {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .user-username {
            font-size: 14px;
            color: #7f8c8d;
        }

        .user-info {
            margin-bottom: 15px;
        }

        .user-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .detail-label {
            color: #7f8c8d;
        }

        .detail-value {
            font-weight: 500;
            color: #2c3e50;
        }

        .user-actions {
            display: flex;
            gap: 10px;
        }

        .last-login {
            font-size: 12px;
            color: #95a5a6;
            margin-top: 10px;
            text-align: center;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 8px;
            height: 6px;
            background: #ecf0f1;
            border-radius: 3px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            border-radius: 3px;
            transition: all 0.3s ease;
        }

        .strength-weak {
            background: #e74c3c;
            width: 25%;
        }

        .strength-medium {
            background: #f39c12;
            width: 50%;
        }

        .strength-strong {
            background: #27ae60;
            width: 75%;
        }

        .strength-very-strong {
            background: #2ecc71;
            width: 100%;
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
            <a href="/configuracion" class="nav-link">
                <i>⚙️</i> Configuración
            </a>
        </li>
        <li class="nav-item">
            <a href="/personas" class="nav-link">
                <i>👨‍👩‍👧‍👦</i> Personas
            </a>
        </li>
        <li class="nav-item">
            <a href="/usuarios" class="nav-link active">
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
        <h2>Gestión de Usuarios del Sistema</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
        </div>
    </header>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number">3</div>
            <div class="stat-label">Usuarios Totales</div>
        </div>
        <div class="stat-card activos">
            <div class="stat-number">3</div>
            <div class="stat-label">Usuarios Activos</div>
        </div>
        <div class="stat-card administradores">
            <div class="stat-number">2</div>
            <div class="stat-label">Administradores</div>
        </div>
        <div class="stat-card empleados">
            <div class="stat-number">1</div>
            <div class="stat-label">Empleados</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active" onclick="showTab('nuevo')">Nuevo Usuario</div>
        <div class="tab" onclick="showTab('lista')">Lista de Usuarios</div>
        <div class="tab" onclick="showTab('perfiles')">Perfiles</div>
    </div>

    <!-- Formulario de Nuevo Usuario -->
    <div id="nuevo-tab" class="form-container">
        <h3 class="form-title">Registrar Nuevo Usuario</h3>
        <form id="usuarioForm">
            <div class="form-section">
                <h4 class="section-title">Información de la Persona</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="persona_id">Persona *</label>
                        <select id="persona_id" name="persona_id" required>
                            <option value="">Seleccione una persona</option>
                            <option value="11">Pablo Gómez Santos</option>
                            <option value="12">Carmen Reyes Mora</option>
                            <option value="13">David Jiménez Lara</option>
                            <option value="14">Elena Ruiz Castro</option>
                            <option value="15">Mario Torres Campos</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="info_persona">Información de la Persona</label>
                        <input type="text" id="info_persona" readonly style="background: #ecf0f1;" value="Seleccione una persona">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Credenciales de Acceso</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="usuario">Nombre de Usuario *</label>
                        <input type="text" id="usuario" name="usuario" required>
                        <div class="password-strength">
                            <div class="strength-bar strength-weak" id="username-strength"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña *</label>
                        <input type="password" id="password" name="password" required oninput="checkPasswordStrength()">
                        <div class="password-strength">
                            <div class="strength-bar" id="password-strength"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirmar Contraseña *</label>
                        <input type="password" id="confirm_password" name="confirm_password" required oninput="checkPasswordMatch()">
                        <div id="password-match" style="font-size: 12px; margin-top: 5px;"></div>
                    </div>

                    <div class="form-group">
                        <label for="rol">Rol del Usuario *</label>
                        <select id="rol" name="rol" required>
                            <option value="">Seleccione un rol</option>
                            <option value="administrador">Administrador</option>
                            <option value="empleado">Empleado</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Configuración Adicional</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label for="estado">Estado del Usuario</label>
                        <select id="estado" name="estado">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="bloqueado">Bloqueado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_expiracion">Fecha de Expiración</label>
                        <input type="date" id="fecha_expiracion" name="fecha_expiracion">
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="cambiar_password" name="cambiar_password">
                            Requerir cambio de contraseña en primer inicio
                        </label>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="notificar_usuario" name="notificar_usuario" checked>
                            Notificar al usuario por correo
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="limpiarFormulario()">
                    <i>🗑️</i> Limpiar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i>💾</i> Registrar Usuario
                </button>
            </div>
        </form>
    </div>

    <!-- Lista de Usuarios -->
    <div id="lista-tab" class="table-container" style="display: none;">
        <div class="table-header">
            <h3>Usuarios Registrados</h3>
            <button class="btn btn-primary" onclick="exportarUsuarios()">
                <i>📄</i> Exportar Lista
            </button>
        </div>

        <div class="search-box">
            <input type="text" placeholder="Buscar usuario...">
            <button>🔍 Buscar</button>
        </div>

        <table>
            <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Último Acceso</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>admin</td>
                <td>Pablo Gómez Santos</td>
                <td><span class="role-badge role-admin">Administrador</span></td>
                <td><span class="status-badge status-activo">Activo</span></td>
                <td>25/10/2024 10:15</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🔄</i> Reset Pass
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🚫</i> Bloquear
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>supervisor</td>
                <td>Carmen Reyes Mora</td>
                <td><span class="role-badge role-admin">Administrador</span></td>
                <td><span class="status-badge status-activo">Activo</span></td>
                <td>24/10/2024 16:30</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🔄</i> Reset Pass
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🚫</i> Bloquear
                        </button>
                    </div>
                </td>
            </tr>
            <tr>
                <td>empleado</td>
                <td>David Jiménez Lara</td>
                <td><span class="role-badge role-empleado">Empleado</span></td>
                <td><span class="status-badge status-activo">Activo</span></td>
                <td>25/10/2024 14:20</td>
                <td>
                    <div class="action-buttons">
                        <button class="btn btn-warning btn-sm">
                            <i>✏️</i> Editar
                        </button>
                        <button class="btn btn-info btn-sm">
                            <i>🔄</i> Reset Pass
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i>🚫</i> Bloquear
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Perfiles de Usuarios -->
    <div id="perfiles-tab" class="table-container" style="display: none;">
        <h3 class="form-title">Perfiles de Usuarios</h3>

        <div class="users-grid">
            <div class="user-card admin">
                <div class="user-header">
                    <div>
                        <div class="user-name">Pablo Gómez Santos</div>
                        <div class="user-username">@admin</div>
                    </div>
                    <span class="role-badge role-admin">Administrador</span>
                </div>
                <div class="user-info">
                    <div class="user-detail">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">pablo.gomez@email.com</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Teléfono:</span>
                        <span class="detail-value">5568765432</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Estado:</span>
                        <span class="detail-value"><span class="status-badge status-activo">Activo</span></span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Registro:</span>
                        <span class="detail-value">15/08/2024</span>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                    <button class="btn btn-info btn-sm">
                        <i>👁️</i> Ver Actividad
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i>🔐</i> Permisos
                    </button>
                </div>
                <div class="last-login">Último acceso: Hoy 10:15</div>
            </div>

            <div class="user-card admin">
                <div class="user-header">
                    <div>
                        <div class="user-name">Carmen Reyes Mora</div>
                        <div class="user-username">@supervisor</div>
                    </div>
                    <span class="role-badge role-admin">Administrador</span>
                </div>
                <div class="user-info">
                    <div class="user-detail">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">carmen.reyes@email.com</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Teléfono:</span>
                        <span class="detail-value">5587664321</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Estado:</span>
                        <span class="detail-value"><span class="status-badge status-activo">Activo</span></span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Registro:</span>
                        <span class="detail-value">20/08/2024</span>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                    <button class="btn btn-info btn-sm">
                        <i>👁️</i> Ver Actividad
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i>🔐</i> Permisos
                    </button>
                </div>
                <div class="last-login">Último acceso: Ayer 16:30</div>
            </div>

            <div class="user-card empleado">
                <div class="user-header">
                    <div>
                        <div class="user-name">David Jiménez Lara</div>
                        <div class="user-username">@empleado</div>
                    </div>
                    <span class="role-badge role-empleado">Empleado</span>
                </div>
                <div class="user-info">
                    <div class="user-detail">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">david.jimenez@email.com</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Teléfono:</span>
                        <span class="detail-value">5576543210</span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Estado:</span>
                        <span class="detail-value"><span class="status-badge status-activo">Activo</span></span>
                    </div>
                    <div class="user-detail">
                        <span class="detail-label">Registro:</span>
                        <span class="detail-value">25/08/2024</span>
                    </div>
                </div>
                <div class="user-actions">
                    <button class="btn btn-warning btn-sm">
                        <i>✏️</i> Editar
                    </button>
                    <button class="btn btn-info btn-sm">
                        <i>👁️</i> Ver Actividad
                    </button>
                    <button class="btn btn-primary btn-sm">
                        <i>🔐</i> Permisos
                    </button>
                </div>
                <div class="last-login">Último acceso: Hoy 14:20</div>
            </div>
        </div>

        <div class="form-actions">
            <button class="btn btn-primary" onclick="generarReporteUsuarios()">
                <i>📊</i> Reporte de Actividad
            </button>
            <button class="btn btn-warning" onclick="auditoriaUsuarios()">
                <i>🔍</i> Auditoría de Seguridad
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
        document.getElementById('perfiles-tab').style.display = 'none';

        // Remover clase active de todos los tabs
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Mostrar tab seleccionado y agregar clase active
        document.getElementById(tabName + '-tab').style.display = 'block';
        event.target.classList.add('active');
    }

    // Simulación de datos de personas
    const personas = {
        11: { nombre: "Pablo Gómez Santos", telefono: "5568765432", email: "pablo.gomez@email.com" },
        12: { nombre: "Carmen Reyes Mora", telefono: "5587664321", email: "carmen.reyes@email.com" },
        13: { nombre: "David Jiménez Lara", telefono: "5576543210", email: "david.jimenez@email.com" },
        14: { nombre: "Elena Ruiz Castro", telefono: "5565432109", email: "elena.ruiz@email.com" },
        15: { nombre: "Mario Torres Campos", telefono: "5554321088", email: "mario.torres@email.com" }
    };

    // Actualizar información cuando se selecciona una persona
    document.getElementById('persona_id').addEventListener('change', function() {
        const personaId = this.value;
        const persona = personas[personaId];

        if (persona) {
            document.getElementById('info_persona').value = `${persona.nombre} - ${persona.telefono}`;
            // Generar username sugerido
            const username = persona.nombre.toLowerCase().split(' ')[0] + '.' + persona.nombre.toLowerCase().split(' ')[1];
            document.getElementById('usuario').value = username;
            checkUsernameStrength();
        } else {
            document.getElementById('info_persona').value = "Seleccione una persona";
            document.getElementById('usuario').value = '';
        }
    });

    // Verificar fortaleza del username
    function checkUsernameStrength() {
        const username = document.getElementById('usuario').value;
        const strengthBar = document.getElementById('username-strength');

        if (username.length < 3) {
            strengthBar.className = 'strength-bar strength-weak';
        } else if (username.length < 6) {
            strengthBar.className = 'strength-bar strength-medium';
        } else if (username.length < 9) {
            strengthBar.className = 'strength-bar strength-strong';
        } else {
            strengthBar.className = 'strength-bar strength-very-strong';
        }
    }

    // Verificar fortaleza de la contraseña
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('password-strength');
        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
        if (password.match(/\d/)) strength++;
        if (password.match(/[^a-zA-Z\d]/)) strength++;

        if (strength === 0) {
            strengthBar.className = 'strength-bar';
            strengthBar.style.width = '0%';
        } else if (strength === 1) {
            strengthBar.className = 'strength-bar strength-weak';
        } else if (strength === 2) {
            strengthBar.className = 'strength-bar strength-medium';
        } else if (strength === 3) {
            strengthBar.className = 'strength-bar strength-strong';
        } else {
            strengthBar.className = 'strength-bar strength-very-strong';
        }
    }

    // Verificar coincidencia de contraseñas
    function checkPasswordMatch() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const matchMessage = document.getElementById('password-match');

        if (confirmPassword === '') {
            matchMessage.textContent = '';
            matchMessage.style.color = '';
        } else if (password === confirmPassword) {
            matchMessage.textContent = '✓ Las contraseñas coinciden';
            matchMessage.style.color = '#27ae60';
        } else {
            matchMessage.textContent = '✗ Las contraseñas no coinciden';
            matchMessage.style.color = '#e74c3c';
        }
    }

    // Manejar envío del formulario
    document.getElementById('usuarioForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const personaId = document.getElementById('persona_id').value;
        const usuario = document.getElementById('usuario').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const rol = document.getElementById('rol').value;

        if (personaId && usuario && password && confirmPassword && rol) {
            if (password !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                return;
            }

            alert('Usuario registrado exitosamente!');
            limpiarFormulario();
        } else {
            alert('Por favor complete todos los campos requeridos');
        }
    });

    function limpiarFormulario() {
        document.getElementById('usuarioForm').reset();
        document.getElementById('info_persona').value = "Seleccione una persona";
        document.getElementById('username-strength').className = 'strength-bar strength-weak';
        document.getElementById('password-strength').className = 'strength-bar';
        document.getElementById('password-match').textContent = '';
    }

    function exportarUsuarios() {
        alert('Generando reporte de usuarios...');
    }

    function generarReporteUsuarios() {
        alert('Generando reporte de actividad de usuarios...');
    }

    function auditoriaUsuarios() {
        alert('Ejecutando auditoría de seguridad...');
    }

    // Event listeners para verificación en tiempo real
    document.getElementById('usuario').addEventListener('input', checkUsernameStrength);
    document.getElementById('password').addEventListener('input', checkPasswordStrength);
    document.getElementById('confirm_password').addEventListener('input', checkPasswordMatch);

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
