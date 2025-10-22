<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Minisuper La Esperanza</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .dashboard {
            min-height: 100vh;
        }
        header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .main-menu {
            background-color: #fff;
            padding: 15px;
            display: flex;
            justify-content: space-around;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .main-menu button {
            flex: 1;
            margin: 0 5px;
            font-size: 16px;
        }
        main {
            padding: 20px;
        }
        .table td, .table th {
            vertical-align: middle;
        }

        /* 💰 Contador digital en la esquina inferior derecha */
        #contadorPesos {
            position: fixed;
            bottom: 25px;
            right: 30px;
            background-color: #000;
            color: #00FF00;
            font-family: 'Courier New', monospace;
            font-size: 28px;
            padding: 12px 25px;
            border-radius: 12px;
            letter-spacing: 2px;
            box-shadow: 0 0 15px #00FF00;
            text-shadow: 0 0 8px #00FF00;
            z-index: 1000;
            user-select: none;
            display: none; /* 🔒 Oculto por defecto */
        }

        .blink {
            animation: blink 0.5s ease-in-out;
        }

        @keyframes blink {
            0% { opacity: 0.2; transform: scale(0.95); }
            100% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="dashboard">
    <header>
        <h1>Panel de Control - Minisuper La Esperanza</h1>
        <span>Usuario: <span id="currentUser">Admin</span></span>
    </header>

    <nav class="main-menu">
        <button class="btn btn-primary" onclick="window.location.href='/V'">🏪 Nueva Venta</button>
        <button class="btn btn-success" onclick="window.location.href='/I'">📦 Inventario</button>
        <button class="btn btn-warning text-white" onclick="window.location.href='/C'">👥 Clientes</button>
        <button class="btn btn-danger" onclick="window.location.href='/'">🚪 Salir</button>
    </nav>


    <main id="mainContent"></main>
</div>

<!-- 💰 Contador digital -->
<div id="contadorPesos">💰 Total: $0.00</div>

<script>
    let productos = [];

    // Mostrar la sección seleccionada
    function showSection(section) {
        const content = document.getElementById('mainContent');
        const contador = document.getElementById('contadorPesos');

        switch(section) {
            case 'ventas':
                content.innerHTML = generarTablaVentas();
                contador.style.display = 'block'; // 👈 Mostrar contador solo en ventas
                actualizarTotal();
                break;

            case 'inventario':
                content.innerHTML = '<p class="text-muted">Sección de inventario (sin contenido activo).</p>';
                contador.style.display = 'none'; // 🔒 Ocultar contador
                break;

            case 'clientes':
                content.innerHTML = '<p>Gestiona la información de tus clientes.</p>';
                contador.style.display = 'none';
                break;

            case 'reportes':
                content.innerHTML = '<p>Visualiza reportes de ventas y estadísticas.</p>';
                contador.style.display = 'none';
                break;

            default:
                content.innerHTML = generarTablaVentas();
                contador.style.display = 'block';
                actualizarTotal();
        }
    }

    function logout() {
        alert('Has cerrado sesión.');
    }

    // 💰 Calcula y muestra el total
    function actualizarTotal() {
        const total = productos.reduce((suma, p) => suma + (p.precio * p.cantidad), 0);
        const contador = document.getElementById('contadorPesos');
        contador.innerText = 💰 Total: $${total.toFixed(2)};
        contador.classList.add('blink');
        setTimeout(() => contador.classList.remove('blink'), 400);
    }

    // 🟢 Mostrar sección de ventas al iniciar
    document.addEventListener("DOMContentLoaded", () => {
        showSection('ventas');
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>