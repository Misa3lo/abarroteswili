<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(13, 71, 161, 0.2);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            overflow: hidden;
            max-width: 600px;
            width: 100%;
        }
        .card-header {
            background: linear-gradient(135deg, #0d47a1 0%, #1976d2 100%);
            color: white;
            border-bottom: none;
            padding: 1.5rem;
            text-align: center;
        }
        .card-header h3 {
            margin: 0;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding: 12px 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: #64b5f6;
            box-shadow: 0 0 0 0.25rem rgba(25, 118, 210, 0.25);
            background: white;
        }
        .btn-primary {
            background: linear-gradient(135deg, #1976d2 0%, #0d47a1 100%);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(13, 71, 161, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #1565c0 0%, #0b3d91 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(13, 71, 161, 0.4);
        }
        .form-label {
            font-weight: 600;
            color: #0d47a1;
            margin-bottom: 5px;
        }
        .input-group-text {
            background-color: #e3f2fd;
            border: 1px solid #e0e0e0;
            border-radius: 10px 0 0 10px;
            color: #1976d2;
        }
        .card-body {
            padding: 2rem;
        }
        .mb-3 {
            margin-bottom: 1rem !important;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header text-white">
        <h3><i class="bi bi-person-plus"></i> Crear Nuevo Usuario</h3>
    </div>
    <div class="card-body">
        <form id="formCrearUsuario">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
            <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Apellido Paterno" required>
            <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Apellido Materno" required>
            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
            <textarea class="form-control" id="direccion" name="direccion" rows="2" placeholder="Dirección" required></textarea>
            <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de Usuario" required>

            <div class="input-group mb-3">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
            </div>

            <div class="input-group mb-3">
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmar Contraseña" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword"><i class="bi bi-eye"></i></button>
            </div>

            <select class="form-select" id="rol" name="rol" required>
                <option value="">Seleccione un rol</option>
                <option value="empleado">Empleado</option>
                <option value="gerente">Gerente</option>
            </select>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary">Crear Usuario</button>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = this.querySelector('i');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('confirmPassword');
        const toggleIcon = this.querySelector('i');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('formCrearUsuario').addEventListener('submit', function(event) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        if (password !== confirmPassword) {
            event.preventDefault();
            alert('Las contraseñas no coinciden. Por favor, verifica.');
        }
    });
</script>
</body>
</html>