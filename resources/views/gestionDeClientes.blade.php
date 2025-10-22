<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Minisuper La Esperanza</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .clientes-section {
            max-width: 1000px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .clientes-section h2 {
            color: #0d6efd;
            margin-bottom: 20px;
        }
        .clientes-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .tabla-clientes table {
            width: 100%;
        }
        .btn-accion {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<div class="clientes-section">
    <h2>Gestión de Clientes</h2>

    <div class="clientes-actions">
        <button class="btn btn-success" onclick="nuevoCliente()">➕ Nuevo Cliente</button>
        <input type="text" class="form-control" placeholder="Buscar cliente..." id="buscarCliente" oninput="filtrarClientes()">
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Límite Crédito</th>
                <th>Saldo Actual</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody id="tablaClientesBody">
            <!-- Clientes dinámicos -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalClienteTitulo">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formCliente">
                <div class="modal-body">
                    <input type="hidden" id="clienteId">
                    <div class="mb-3">
                        <label for="clienteNombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="clienteNombre" placeholder="Nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="clienteTelefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="clienteTelefono" placeholder="Teléfono">
                    </div>
                    <div class="mb-3">
                        <label for="clienteLimite" class="form-label">Límite de Crédito</label>
                        <input type="number" class="form-control" id="clienteLimite" placeholder="Límite de Crédito" step="0.01" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let clientes = [
        {id:1,nombre:'Juan Pérez',telefono:'555-1234',limite:5000,saldo:1200,estado:'Activo'},
        {id:2,nombre:'María López',telefono:'555-5678',limite:3000,saldo:500,estado:'Activo'},
        {id:3,nombre:'Carlos Ruiz',telefono:'555-8765',limite:2000,saldo:0,estado:'Inactivo'}
    ];

    function cargarClientes() {
        const tbody = document.getElementById('tablaClientesBody');
        tbody.innerHTML = '';
        clientes.forEach((c,index)=>{
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${c.nombre}</td>
                <td>${c.telefono}</td>
                <td>$${c.limite.toFixed(2)}</td>
                <td>$${c.saldo.toFixed(2)}</td>
                <td>${c.estado}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-accion" onclick="editarCliente(${index})">Autorizar Credito</button>
                    <button class="btn btn-sm btn-danger btn-accion" onclick="eliminarCliente(${index})">Negar Credito </button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function filtrarClientes() {
        const filtro = document.getElementById('buscarCliente').value.toLowerCase();
        const tbody = document.getElementById('tablaClientesBody');
        tbody.innerHTML = '';
        clientes.filter(c => c.nombre.toLowerCase().includes(filtro)).forEach((c,index)=>{
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${c.nombre}</td>
                <td>${c.telefono}</td>
                <td>$${c.limite.toFixed(2)}</td>
                <td>$${c.saldo.toFixed(2)}</td>
                <td>${c.estado}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-accion" onclick="editarCliente(${index})">Autorizar Credito</button>
                    <button class="btn btn-sm btn-danger btn-accion" onclick="eliminarCliente(${index})">Negar Credito</button>
                </td>
            `;
            tbody.appendChild(row);
        });
    }

    function nuevoCliente() {
        document.getElementById('formCliente').reset();
        document.getElementById('clienteId').value = '';
        document.getElementById('modalClienteTitulo').innerText = 'Nuevo Cliente';
        const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
        modal.show();
    }

    function editarCliente(index) {
        const c = clientes[index];
        document.getElementById('clienteId').value = c.id;
        document.getElementById('clienteNombre').value = c.nombre;
        document.getElementById('clienteTelefono').value = c.telefono;
        document.getElementById('clienteLimite').value = c.limite;
        document.getElementById('modalClienteTitulo').innerText = 'Atuarizar Creditos';
        const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
        modal.show();
    }

    function eliminarCliente(index) {
        if(confirm('¿Deseas eliminar este cliente?')){
            clientes.splice(index,1);
            cargarClientes();
        }
    }

    document.getElementById('formCliente').addEventListener('submit', function(e){
        e.preventDefault();
        const id = document.getElementById('clienteId').value;
        const nombre = document.getElementById('clienteNombre').value;
        const telefono = document.getElementById('clienteTelefono').value;
        const limite = parseFloat(document.getElementById('clienteLimite').value);
        if(id){
            // Editar cliente existente
            const c = clientes.find(cl=>cl.id==id);
            c.nombre = nombre;
            c.telefono = telefono;
            c.limite = limite;
        } else {
            // Nuevo cliente
            clientes.push({
                id: clientes.length+1,
                nombre,
                telefono,
                limite,
                saldo:0,
                estado:'Activo'
            });
        }
        cargarClientes();
        const modalEl = document.getElementById('modalCliente');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    });

    cargarClientes();
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>