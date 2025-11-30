<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Wili - @yield('title', 'Sistema de Ventas')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body>

<div class="d-flex" id="wrapper">

    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            <i class="fas fa-shopping-basket"></i> Wili POS
        </div>
        <div class="list-group list-group-flush">
            <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('puntoDeVenta') }}" class="list-group-item list-group-item-action text-warning">
                <i class="fas fa-cash-register"></i> Punto de Venta
            </a>
            <a href="{{ route('productos.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-box-open"></i> Productos
            </a>
            <a href="{{ route('departamentos.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-tags"></i> Departamentos
            </a>
            <a href="{{ route('clientes.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-users"></i> Clientes
            </a>

            {{-- INICIO DE NUEVOS ENLACES --}}
            {{-- Créditos (Cuentas por Cobrar) --}}
            <a href="{{ route('creditos.index') }}" class="list-group-item list-group-item-action
               @if(request()->routeIs('creditos.*')) active @endif">
                <i class="fas fa-hand-holding-usd"></i> Cuentas por Cobrar
            </a>

            {{-- Métodos de Pago --}}
            <a href="{{ route('metodos-pago.index') }}" class="list-group-item list-group-item-action
               @if(request()->routeIs('metodos-pago.*')) active @endif">
                <i class="fas fa-money-check-alt"></i> Métodos de Pago
            </a>
            {{-- FIN DE NUEVOS ENLACES --}}

            <a href="{{ route('surtidos.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-truck-loading"></i> Surtir
            </a>
            <a href="{{ route('usuarios.index') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-user-tie"></i> Usuarios
            </a>
        </div>
    </div>
    <div id="page-content-wrapper">

        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container-fluid">
                <button class="btn btn-outline-dark d-md-none" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0 align-items-center">
                        <li class="nav-item me-3">
                            <span class="user-info text-white">
                                <i class="fas fa-user-circle me-1"></i>
                                {{ Auth::check() ? Auth::user()->usuario : 'Sesión Perdida' }}
                            </span>
                        </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-logout btn-sm">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>
</body>
</html>
