@extends('layouts.app')

@section('title', 'Punto de Venta')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white"><i class="fas fa-shopping-cart me-2"></i> Nueva Venta</div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="mb-4 p-3 border rounded bg-light">
                        <h6 class="text-primary"><i class="fas fa-user-tag me-1"></i> Cliente (Para Crédito)</h6>
                        <select class="form-select" id="cliente_id" name="cliente_id">
                            <option value="">Público General</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" data-limite="{{ $cliente->limite_credito }}">
                                    {{ $cliente->persona->nombre }} {{ $cliente->persona->apaterno }} (Límite: ${{ number_format($cliente->limite_credito, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h6 class="text-primary"><i class="fas fa-search me-1"></i> Agregar Productos</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="codigo" placeholder="Buscar por codigo_barras o ID..." autofocus>
                    </div>
                    <div id="search-results" class="list-group mb-4" style="max-height: 200px; overflow-y: auto;">
                    </div>

                    <h6 class="text-primary mt-4"><i class="fas fa-list-alt me-1"></i> Productos en Carrito</h6>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm align-middle">
                            <thead class="table-info">
                            <tr>
                                <th>ID</th>
                                <th>Código/Nombre</th>
                                <th style="width: 100px;">Precio</th>
                                <th style="width: 80px;">Cant.</th>
                                <th>Subtotal</th>
                                <th style="width: 50px;"></th>
                            </tr>
                            </thead>
                            <tbody id="cart-table-body">
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">TOTAL:</td>
                                <td id="cart-total" class="fw-bold fs-5 text-success">$ 0.00</td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white"><i class="fas fa-money-bill-wave me-2"></i> Procesar Pago</div>
                <div class="card-body">

                    <form id="checkout-form" action="{{ route('tickets.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="total" id="input_total" required>
                        <input type="hidden" name="cliente_id" id="input_cliente_id">
                        <div id="hidden-cart-items"></div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Total a Pagar:</label>
                            <p id="display_total" class="fs-1 fw-bold text-success">$ 0.00</p>
                        </div>

                        <div class="mb-4">
                            <label for="metodo_pago_id" class="form-label fw-bold">Método de Pago <span class="text-danger">*</span></label>
                            <select class="form-select" id="metodo_pago_id" name="metodo_pago_id" required onchange="checkCredit()">
                                <option value="">-- Seleccione --</option>
                                @foreach($metodosPago as $metodo)
                                    <option value="{{ $metodo->id }}" data-name="{{ $metodo->descripcion }}">
                                        {{ $metodo->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="credit-warning" class="mt-2 text-danger fw-bold d-none">
                                <i class="fas fa-exclamation-triangle"></i> Debe seleccionar un cliente para pagar a **Crédito**.
                            </div>
                        </div>

                        <hr>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-3" id="btn-procesar-venta" disabled>
                            <i class="fas fa-check-circle"></i> Procesar Venta
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        // JSON de productos cargado desde el controlador (ahora con la clave 'codigo_barras')
        const PRODUCT_LIST = {!! $productosJson !!};
        let cart = {};

        const inputTotal = document.getElementById('input_total');
        const displayTotal = document.getElementById('display_total');
        const cartTableBody = document.getElementById('cart-table-body');
        const cartTotalDisplay = document.getElementById('cart-total');
        const btnProcesar = document.getElementById('btn-procesar-venta');
        const inputClienteId = document.getElementById('input_cliente_id');
        const selectMetodoPago = document.getElementById('metodo_pago_id');
        const creditWarning = document.getElementById('credit-warning');
        const searchInput = document.getElementById('search_producto');

        // Eventos de Cliente y Método de Pago
        document.getElementById('cliente_id').addEventListener('change', (e) => {
            inputClienteId.value = e.target.value;
            checkCredit();
        });

        selectMetodoPago.addEventListener('change', checkCredit);

        // Búsqueda de Productos con Filtro Dinámico
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const resultsContainer = document.getElementById('search-results');
            resultsContainer.innerHTML = '';

            if (query.length < 2) return;

            const filtered = PRODUCT_LIST.filter(p =>
                // Ahora busca por p.codigo_barras (el nombre de la clave es consistente)
                p.codigo_barras.toLowerCase().includes(query) || p.id.toString() === query
            ).slice(0, 10);

            filtered.forEach(p => {
                const item = document.createElement('a');
                item.className = 'list-group-item list-group-item-action';
                item.innerHTML = `<strong>${p.codigo_barras}</strong> (Stock: ${p.stock}) - $${p.precio.toFixed(2)}`;
                item.onclick = (e) => {
                    e.preventDefault();
                    addProductToCart(p.id);
                };
                resultsContainer.appendChild(item);
            });
        });

        // Agregar producto con Enter (Escaneo rápido)
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const results = document.getElementById('search-results').children;
                const query = this.value.trim().toLowerCase();

                // 1. Si el código de barras está completo y coincide exactamente (escaner)
                const exactMatch = PRODUCT_LIST.find(p => p.codigo_barras.toLowerCase() === query || p.id.toString() === query);

                if (exactMatch) {
                    addProductToCart(exactMatch.id);
                } else if (results.length === 1) {
                    // 2. Si hay un único resultado en la búsqueda
                    results[0].click();
                } else if (query.length > 0) {
                    alert('Producto no encontrado o demasiados resultados. Intente escanear o seleccionar de la lista.');
                }
            }
        });

        function addProductToCart(productoId, cantidad = 1) {
            const productData = PRODUCT_LIST.find(p => p.id === productoId);

            if (!productData) return;

            if (productData.stock <= 0) {
                alert('¡Producto agotado! Stock actual: 0.');
                return;
            }

            if (cart[productoId]) {
                // Producto ya en carrito, aumentar cantidad
                if (cart[productoId].cantidad + cantidad > productData.stock) {
                    alert('No hay suficiente stock disponible para este producto.');
                    return;
                }
                cart[productoId].cantidad += cantidad;
            } else {
                // Nuevo producto
                if (cantidad > productData.stock) {
                    alert('No hay suficiente stock disponible para este producto.');
                    return;
                }
                cart[productoId] = {
                    producto_id: productData.id,
                    codigo_barras: productData.codigo_barras, // Usamos la clave correcta
                    precio_unitario: productData.precio,
                    cantidad: cantidad,
                    stock_actual: productData.stock
                };
            }

            renderCart();
            document.getElementById('search-results').innerHTML = '';
            searchInput.value = '';
            searchInput.focus(); // Enfocar para seguir escaneando/buscando
        }

        function removeProductFromCart(productoId) {
            delete cart[productoId];
            renderCart();
        }

        function updateQuantity(productoId, newQuantity) {
            const product = cart[productoId];
            const stock = product.stock_actual;

            newQuantity = parseInt(newQuantity);
            if (isNaN(newQuantity) || newQuantity < 1) {
                newQuantity = 1;
            }
            if (newQuantity > stock) {
                alert('La cantidad no puede exceder el stock disponible (' + stock + ').');
                newQuantity = stock;
            }

            product.cantidad = newQuantity;
            renderCart();
        }

        function renderCart() {
            let total = 0;
            cartTableBody.innerHTML = '';
            const hiddenItemsContainer = document.getElementById('hidden-cart-items');
            hiddenItemsContainer.innerHTML = '';

            // Recorrer el carrito y renderizar la tabla y los inputs ocultos
            Object.values(cart).forEach((item, index) => {
                const subtotal = item.cantidad * item.precio_unitario;
                total += subtotal;

                const row = cartTableBody.insertRow();
                row.innerHTML = `
                <td>${item.producto_id}</td>
                <td>${item.codigo_barras}</td>
                <td>$ ${item.precio_unitario.toFixed(2)}</td>
                <td><input type="number" min="1" max="${item.stock_actual}" value="${item.cantidad}" class="form-control form-control-sm text-center" onchange="updateQuantity(${item.producto_id}, this.value)"></td>
                <td>$ ${subtotal.toFixed(2)}</td>
                <td><button type="button" class="btn btn-sm btn-danger" onclick="removeProductFromCart(${item.producto_id})"><i class="fas fa-times"></i></button></td>
            `;

                // Inputs ocultos para enviar al controlador
                hiddenItemsContainer.innerHTML += `
                <input type="hidden" name="cart_items[${index}][producto_id]" value="${item.producto_id}">
                <input type="hidden" name="cart_items[${index}][cantidad]" value="${item.cantidad}">
                <input type="hidden" name="cart_items[${index}][precio_unitario]" value="${item.precio_unitario}">
            `;
            });

            // Actualizar totales y habilitar botón
            cartTotalDisplay.textContent = `$ ${total.toFixed(2)}`;
            displayTotal.textContent = `$ ${total.toFixed(2)}`;
            inputTotal.value = total.toFixed(2);

            // Habilitar/Deshabilitar el botón de procesar
            if (total > 0) {
                btnProcesar.disabled = false;
            } else {
                btnProcesar.disabled = true;
            }

            checkCredit();
        }

        // Validación de Crédito: Requiere cliente si el método es Crédito
        function checkCredit() {
            const metodoPago = selectMetodoPago.options[selectMetodoPago.selectedIndex];

            if (Object.keys(cart).length === 0) {
                btnProcesar.disabled = true;
                creditWarning.classList.add('d-none');
                return;
            }

            if (!metodoPago) {
                btnProcesar.disabled = true;
                creditWarning.classList.add('d-none');
                return;
            }

            const metodoName = metodoPago.getAttribute('data-name');
            const clienteId = inputClienteId.value;

            if (metodoName === 'Crédito' && !clienteId) {
                creditWarning.classList.remove('d-none');
                btnProcesar.disabled = true;
            } else {
                creditWarning.classList.add('d-none');
                btnProcesar.disabled = false;
            }
        }

        // Iniciar con el cliente por defecto (Público General)
        document.addEventListener('DOMContentLoaded', () => {
            inputClienteId.value = document.getElementById('cliente_id').value;
            btnProcesar.disabled = true;
        });

    </script>
@endsection
