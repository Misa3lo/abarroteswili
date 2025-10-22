<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta - Minisuper La Esperanza</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .ventas-section {
            max-width: 1000px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .ventas-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .ventas-header h2 {
            color: #0d6efd;
        }
        .busqueda-producto {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .productos-ticket table {
            width: 100%;
        }
        .ventas-totales {
            margin-top: 20px;
            text-align: right;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            font-weight: 500;
        }
        .total-line.total {
            font-size: 1.3rem;
            font-weight: 700;
            margin-top: 10px;
        }
        .ventas-totales button {
            margin-top: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="ventas-section">
    <div class="ventas-header">
        <h2>Punto de Venta</h2>
        <div class="ventas-info">
            <span>Ticket: <strong id="folio">TKT-001</strong></span> |
            <span>Fecha: <strong id="fechaVenta">2025-10-17</strong></span>
        </div>
    </div>

    <div class="ventas-body">
        <!-- Búsqueda de productos -->
        <div class="busqueda-producto">
            <input type="text" id="codigoProducto" class="form-control" placeholder="🔍 Ingresar Código de Barra...">
            <title></title>
            <select id="tipoVenta" class="form-select" style="height: 50px; font-size: 1.1rem;">
                <option value="Contado">Contado</option>
                <option value="Crédito">Crédito</option>
            </select>
            <select id="selectCliente" class="form-select" style="display: none;">
                <option value="">Seleccionar cliente...</option>
            </select>
        </div>

        <!-- Lista de productos en el ticket -->
        <div class="productos-ticket table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                <tr>
                    <th>Código de Barra</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Importe</th>
                    <th>Acción</th>
                </tr>
                </thead>
                <tbody id="itemsVenta">
                <tr id="sinProductos">
                    <td colspan="6" class="text-center text-muted">No hay productos en la venta.</td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <div class="ventas-totales">
            <div class="total-line">
                <span>Subtotal:</span>
                <span id="subtotal">$0.00</span>
            </div>
            <div class="total-line">
                <span>IVA (16%):</span>
                <span id="iva">$0.00</span>
            </div>
            <div class="total-line total">
                <span>TOTAL:</span>
                <span id="total">$0.00</span>
            </div>
            <button class="btn btn-success" onclick="finalizarVenta()">✅ Finalizar Venta</button>
        </div>
    </div>
</div>

<script>
    let items = [];

    function agregarProducto() {
        const codigo = document.getElementById('codigoProducto').value.trim();
        if (!codigo) return alert('Ingresa un Código de Barra');

        // Ejemplo de descripción y precio fijo (en la vida real se obtendría de la base de datos)
        const descripcion = 'Producto de ejemplo';
        const precio = 50.00;
        const cantidad = 1;
        const subtotal = precio * cantidad;

        items.push({codigo, descripcion, cantidad, precio, subtotal});
        actualizarTabla();
        document.getElementById('codigoProducto').value = '';
    }

    function actualizarTabla() {
        const tbody = document.getElementById('itemsVenta');
        tbody.innerHTML = '';

        if (items.length === 0) {
            tbody.innerHTML = `<tr>
                <td colspan="6" class="text-center text-muted">No hay productos en la venta.</td>
            </tr>`;
            document.getElementById('subtotal').innerText = $0.00;
            document.getElementById('iva').innerText = $0.00;
            document.getElementById('total').innerText = $0.00;
            return;
        }

        let subtotalTotal = 0;

        items.forEach((item, index) => {
            subtotalTotal += item.subtotal;
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.codigo}</td>
                <td>${item.descripcion}</td>
                <td>$${item.precio.toFixed(2)}</td>
                <td>${item.cantidad}</td>
                <td>$${item.subtotal.toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger" onclick="eliminarProducto(${index})">Eliminar</button></td>
            `;
            tbody.appendChild(row);
        });

        const iva = subtotalTotal * 0.16;
        const total = subtotalTotal + iva;

        document.getElementById('subtotal').innerText = $${subtotalTotal.toFixed(2)};
        document.getElementById('iva').innerText = $${iva.toFixed(2)};
        document.getElementById('total').innerText = $${total.toFixed(2)};
    }

    function eliminarProducto(index) {
        items.splice(index, 1);
        actualizarTabla();
    }

    function finalizarVenta() {
        if (items.length === 0) return alert('No hay productos en la venta.');
        alert('Venta finalizada correctamente!');
        items = [];
        actualizarTabla();
    }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>