<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Wili - Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            overflow: hidden;
        }

        .login-header {
            background: #2c3e50;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-header p {
            font-size: 14px;
            opacity: 0.8;
        }

        .login-form {
            padding: 30px;
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

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3498db;
            background: white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #219a52;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(39, 174, 96, 0.3);
        }

        .login-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #e1e8ed;
            background: #f8f9fa;
        }

        .login-footer p {
            color: #7f8c8d;
            font-size: 12px;
        }

        .error-message {
            background: #e74c3c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
            display: none;
        }

        .logo {
            width: 80px;
            height: 80px;
            background: #34495e;
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-header">
        <div class="logo">W</div>
        <h1>Abarrotes Wili</h1>
        <p>Sistema de Gestión Comercial</p>
    </div>

    <div class="login-form">
        <div class="error-message" id="errorMessage">
            Usuario no existe
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>
    </div>

    <div class="login-footer">
        <p>&copy; 2024 Abarrotes Wili. Todos los derechos reservados.</p>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const usuario = document.getElementById('usuario').value;
        const password = document.getElementById('password').value;
        const errorMessage = document.getElementById('errorMessage');

        // Usuarios válidos para la maquetación
        const usuariosValidos = ['admin', 'empleado', 'supervisor'];

        // No validamos contraseña, solo verificamos si el usuario existe
        if (usuario && usuariosValidos.includes(usuario.toLowerCase())) {
            // Redirigir al dashboard sin mostrar mensaje de éxito
            window.location.href = '/dashboard';
        } else {
            // Mostrar mensaje de usuario no existe
            errorMessage.textContent = 'Usuario no existe';
            errorMessage.style.display = 'block';
        }
    });

    // Ocultar mensaje de error al empezar a escribir
    document.querySelectorAll('input').forEach(element => {
        element.addEventListener('input', () => {
            document.getElementById('errorMessage').style.display = 'none';
        });
    });

    // Enfocar el campo de usuario al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('usuario').focus();
    });
</script>
</body>
</html>
