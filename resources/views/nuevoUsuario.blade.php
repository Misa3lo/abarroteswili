<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Usuario - Abarrotes Wili</title>
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

        /* Formulario de Usuario */
        .user-form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
            text-align: center;
        }

        .form-subtitle {
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title i {
            font-size: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2c3e50;
        }

        .form-group label.required::after {
            content: " *";
            color: #e74c3c;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #ecf0f1;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .form-help {
            font-size: 12px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 10px;
        }

        .radio-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-option input[type="radio"] {
            margin: 0;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ecf0f1;
        }

        /* Alertas */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: none;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
        <h2>Registro de Nuevo Usuario</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Administrador</span>
            <button class="btn btn-primary" onclick="location.href='/usuarios'">
                <i>📋</i> Ver Todos los Usuarios
            </button>
        </div>
    </header>

    <!-- Alertas -->
    <div id="successAlert" class="alert alert-success">
        ✅ Usuario registrado exitosamente
    </div>
    <div id="errorAlert" class="alert alert-error">
        ❌ Error al registrar el usuario. Verifique los datos.
    </div>

    <!-- Formulario de Usuario -->
    <section class="user-form-container">
        <h3 class="form-title">Crear Nueva Cuenta de Usuario</h3>
        <p class="form-subtitle">Complete la información personal y de acceso del nuevo usuario</p>

        <!-- Sección de Información Personal -->
        <div class="form-section">
            <div class="section-title">
                <i>👤</i> Información Personal
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre" class="required">Nombre</label>
                    <input type="text" id="nombre" class="form-control" placeholder="Ingrese el nombre">
                </div>
                <div class="form-group">
                    <label for="apaterno" class="required">Apellido Paterno</label>
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
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="direccion">Dirección</label>
                    <textarea id="direccion" class="form-control" rows="3" placeholder="Dirección completa"></textarea>
                </div>
            </div>
        </div>

        <!-- Sección de Cuenta de Usuario -->
        <div class="form-section">
            <div class="section-title">
                <i>🔐</i> Cuenta de Usuario
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="usuario" class="required">Nombre de Usuario</label>
                    <input type="text" id="usuario" class="form-control" placeholder="Ej. juan.perez">
                    <div class="form-help">Mínimo 4 caracteres, solo letras, números y puntos</div>
                </div>
                <div class="form-group">
                    <label for="email" class="required">Correo Electrónico</label>
                    <input type="email" id="email" class="form-control" placeholder="usuario@ejemplo.com">
                </div>
                <div class="form-group">
                    <label for="password" class="required">Contraseña</label>
                    <input type="password" id="password" class="form-control" placeholder="Contraseña segura">
                    <div class="form-help">Mínimo 8 caracteres, incluir mayúsculas, minúsculas y números</div>
                </div>
                <div class="form-group">
                    <label for="confirm-password" class="required">Confirmar Contraseña</label>
                    <input type="password" id="confirm-password" class="form-control" placeholder="Repetir contraseña">
                </div>
            </div>
        </div>

        <!-- Sección de Rol y Permisos -->
        <div class="form-section">
            <div class="section-title">
                <i>🎯</i> Rol y Permisos
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="required">Tipo de Usuario</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="rol-admin" name="rol" value="administrador">
                            <label for="rol-admin">Administrador</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="rol-supervisor" name="rol" value="supervisor">
                            <label for="rol-supervisor">Supervisor</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="rol-empleado" name="rol" value="empleado" checked>
                            <label for="rol-empleado">Empleado</label>
                        </div>
                    </div>
                    <div class="form-help">
                        <strong>Administrador:</strong> Acceso completo al sistema<br>
                        <strong>Supervisor:</strong> Acceso casi completo, algunas restricciones<br>
                        <strong>Empleado:</strong> Acceso limitado a consultas y ventas
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Estado -->
        <div class="form-section">
            <div class="section-title">
                <i>📝</i> Estado de la Cuenta
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="required">Estado de la Cuenta</label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" id="estado-activo" name="estado" value="activo" checked>
                            <label for="estado-activo">Activo</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" id="estado-inactivo" name="estado" value="inactivo">
                            <label for="estado-inactivo">Inactivo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones del Formulario -->
        <div class="form-actions">
            <button type="button" class="btn" onclick="location.href='/usuarios'" style="background: #6c757d; color: white;">
                <i>↩️</i> Cancelar
            </button>
            <button type="button" class="btn btn-warning" onclick="resetForm()">
                <i>🔄</i> Limpiar Formulario
            </button>
            <button type="button" class="btn btn-success" onclick="registerUser()">
                <i>💾</i> Registrar Usuario
            </button>
        </div>
    </section>
</main>

<script>
    // Función para registrar usuario
    function registerUser() {
        const nombre = document.getElementById('nombre').value;
        const apaterno = document.getElementById('apaterno').value;
        const usuario = document.getElementById('usuario').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Validación básica
        if (!nombre || !apaterno || !usuario || !password || !confirmPassword) {
            showAlert('errorAlert', 'Por favor complete todos los campos requeridos');
            return;
        }

        if (password !== confirmPassword) {
            showAlert('errorAlert', 'Las contraseñas no coinciden');
            return;
        }

        if (password.length < 8) {
            showAlert('errorAlert', 'La contraseña debe tener al menos 8 caracteres');
            return;
        }

        // Simulación de registro exitoso
        showAlert('successAlert', 'Usuario registrado exitosamente');

        // Limpiar formulario después de 2 segundos
        setTimeout(() => {
            resetForm();
            hideAlerts();
        }, 2000);
    }

    // Función para limpiar formulario
    function resetForm() {
        document.getElementById('nombre').value = '';
        document.getElementById('apaterno').value = '';
        document.getElementById('amaterno').value = '';
        document.getElementById('telefono').value = '';
        document.getElementById('direccion').value = '';
        document.getElementById('usuario').value = '';
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('confirm-password').value = '';
        document.getElementById('rol-empleado').checked = true;
        document.getElementById('estado-activo').checked = true;
        hideAlerts();
    }

    // Funciones para manejar alertas
    function showAlert(alertId, message) {
        hideAlerts();
        const alert = document.getElementById(alertId);
        alert.style.display = 'block';
        if (message) {
            alert.innerHTML = message;
        }
    }

    function hideAlerts() {
        document.getElementById('successAlert').style.display = 'none';
        document.getElementById('errorAlert').style.display = 'none';
    }

    // Navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Ocultar alertas inicialmente
    document.addEventListener('DOMContentLoaded', function() {
        hideAlerts();
    });
</script>
</body>
</html>
