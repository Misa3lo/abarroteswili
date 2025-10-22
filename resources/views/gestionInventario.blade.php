<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - Minisuper La Esperanza</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .inventario-section {
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .inventario-section h2 {
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .inventario-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filtros-inventario {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tabla-inventario table {
            width: 100%;
        }
        .btn-accion {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="inventario-section">
    <h2>Gestión de Inventario</h2>

    <div class="inventario-actions">
        <button class="btn btn-success" onclick="nuevoSurtido()">➕ Nuevo Surtido</button>
        <button class="btn btn-primary" onclick="exportarInventario()">📊 Exportar Reporte</button>
    </div>

    <div class="filtros-inventario">
        <input type="text" class="form-control" placeholder="Buscar producto..." id="filtroProducto" oninput="filtrarInventario()">
        <select id="filtroCategoria" class="form-select" onchange="filtrarInventario()">
            <option value="">Todas las categorías</option>
            <option value="Bebidas">Bebidas</option>
            <option value="Alimentos">Alimentos</option>
            <option value="Higiene">Higiene</option>
            <!-- Más categorías dinámicas -->
        </select>
    </div>

    <div class="tabla-inventario table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Precio Venta</th>
                <th>Stock Disponible</th>
                <th>Último Surtido</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="tablaInventarioBody">
            <!-- Datos de inventario dinámicos -->
            </tbody>
        </table>
    </div>
</div>

<script>
    // Datos de ejemplo
    let inventario = [
        {codigo: '001', producto: 'Leche', categoria: 'Bebidas', precio: 20.0, stock: 50, ultimoSurtido: '2025-10-15'},
        {codigo: '002', producto: 'Pan', categoria: 'Alimentos', precio: 15.0, stock: 100, ultimoSurtido: '2025-10-14'},
        {codigo: '003', producto: 'Jabón', categoria: 'Higiene', precio: 10.0, stock: 30, ultimoSurtido: '2025-10-12'}
    ];

    function cargarInventario() {
        const tbody = document.getElementById('tablaInventarioBody');
        tbody.innerHTML = '';
        inventario.forEach((item, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.codigo}</td>
                <td>${item.producto}</td>
                <td>${item.categoria}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>${item.stock}</td>
                <td>${item.ultimoSurtido}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-accion" onclick="editarProducto(${index})">✏ Editar</button>
                    <button class="btn btn-sm btn-danger btn-accion" onclick="eliminarProducto(${index})">🗑 Eliminar</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function filtrarInventario() {
        const filtroProd = document.getElementById('filtroProducto').value.toLowerCase();
        const filtroCat = document.getElementById('filtroCategoria').value;

        const tbody = document.getElementById('tablaInventarioBody');
        tbody.innerHTML = '';
        inventario
            .filter(item =>
                (item.producto.toLowerCase().includes(filtroProd)) &&
                (filtroCat === '' || item.categoria === filtroCat)
            )
            .forEach((item, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.codigo}</td>
                    <td>${item.producto}</td>
                    <td>${item.categoria}</td>
                    <td>$${item.precio.toFixed(2)}</td>
                    <td>${item.stock}</td>
                    <td>${item.ultimoSurtido}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-accion" onclick="editarProducto(${index})">✏ Editar</button>
                        <button class="btn btn-sm btn-danger btn-accion" onclick="eliminarProducto(${index})">🗑 Eliminar</button>
                    </td>
                `;
                tbody.appendChild(row);
            });
    }

    function nuevoSurtido() {
        alert('Abrir formulario de nuevo surtido');
    }

    function exportarInventario() {
        alert('Exportar inventario a Excel/PDF');
    }

    function editarProducto(index) {
        alert('Editar producto: ' + inventario[index].producto);
    }

    function eliminarProducto(index) {
        if(confirm('¿Deseas eliminar el producto?')) {
            inventario.splice(index, 1);
            cargarInventario();
        }
    }

    // Cargar inventario al inicio
    cargarInventario();
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>