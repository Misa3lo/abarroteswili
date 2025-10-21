<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-form h2 {
            margin-bottom: 30px;
            color: #0d6efd;
        }
        .login-form input {
            margin-bottom: 20px;
        }
        .login-form button {
            width: 100%;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h2>Abarrotes Wili</h2>
        <form id="loginForm">
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <button type="submit" class="btn btn-primary">Ingresar</button>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>