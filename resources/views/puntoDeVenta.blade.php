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
                            <option value="13" selected>Público General</option>

                            @foreach($clientes as $cliente)
                                {{-- Ocultamos el ID 13 de la lista generada para no duplicarlo --}}
                                @if ($cliente->id != 13)
                                    <option value="{{ $cliente->id }}" data-limite="{{ $cliente->limite_credito }}">
                                        {{ $cliente->persona->nombre }} {{ $cliente->persona->apaterno }} (Límite: ${{ number_format($cliente->limite_credito, 2) }})
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <h6 class="text-primary"><i class="fas fa-search me-1"></i> Agregar Productos</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="codigo" placeholder="Buscar por código de barras o ID..." autofocus>
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
                                <i class="fas fa-exclamation-triangle"></i> Debe seleccionar un cliente registrado para pagar a **Crédito**.
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
        // 🛑 ACTUALIZACIÓN: ID REAL DEL CLIENTE PÚBLICO GENERAL
        const ID_CLIENTE_PUBLICO = 13;
        const ID_METODO_EFECTIVO = 1;

        const PRODUCT_LIST = {!! $productosJson !!};
        let cart = {};

        // Referencias DOM
        const inputTotal = document.getElementById('input_total');
        const displayTotal = document.getElementById('display_total');
        const cartTableBody = document.getElementById('cart-table-body');
        const cartTotalDisplay = document.getElementById('cart-total');
        const btnProcesar = document.getElementById('btn-procesar-venta');
        const inputClienteId = document.getElementById('input_cliente_id');
        const selectMetodoPago = document.getElementById('metodo_pago_id');
        const creditWarning = document.getElementById('credit-warning');
        const searchInput = document.getElementById('codigo');
        const searchResultsContainer = document.getElementById('search-results');

        // Eventos
        document.getElementById('cliente_id').addEventListener('change', (e) => {
            inputClienteId.value = e.target.value;
            checkCredit();
        });

        selectMetodoPago.addEventListener('change', checkCredit);

        // --- Lógica del Carrito (Búsqueda y Agregar) ---
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                searchResultsContainer.innerHTML = '';
                if (query.length < 2) return;

                const filtered = PRODUCT_LIST.filter(p =>
                    p.codigo_barras.toLowerCase().includes(query) ||
                    p.id.toString() === query ||
                    (p.descripcion && p.descripcion.toLowerCase().includes(query))
                ).slice(0, 10);

                filtered.forEach(p => {
                    const item = document.createElement('a');
                    item.className = 'list-group-item list-group-item-action';
                    item.innerHTML = `<strong>${p.codigo_barras}</strong> - ${p.descripcion || 'N/A'} (Stock: ${p.existencias}) - $${parseFloat(p.precio_venta).toFixed(2)}`;
                    item.onclick = (e) => { e.preventDefault(); addProductToCart(p.id); };
                    searchResultsContainer.appendChild(item);
                });
            });

            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const query = this.value.trim().toLowerCase();
                    const exactMatch = PRODUCT_LIST.find(p => p.codigo_barras.toLowerCase() === query || p.id.toString() === query);
                    if (exactMatch) { addProductToCart(exactMatch.id); }
                }
            });
        }

        function addProductToCart(productoId, cantidad = 1) {
            const productData = PRODUCT_LIST.find(p => p.id === productoId);
            if (!productData) return;

            const unitPrice = parseFloat(productData.precio_venta);
            const currentStock = parseFloat(productData.existencias);

            if (currentStock <= 0) { alert('Agotado'); return; }

            if (cart[productoId]) {
                if (cart[productoId].cantidad + cantidad > currentStock) { alert('Stock insuficiente'); return; }
                cart[productoId].cantidad += cantidad;
            } else {
                if (cantidad > currentStock) { alert('Stock insuficiente'); return; }
                cart[productoId] = {
                    producto_id: productData.id,
                    codigo_barras: productData.codigo_barras,
                    descripcion: productData.descripcion,
                    precio_unitario: unitPrice,
                    cantidad: cantidad,
                    stock_actual: currentStock
                };
            }
            renderCart();
            searchInput.value = '';
            searchResultsContainer.innerHTML = '';
            searchInput.focus();
        }

        function removeProductFromCart(id) { delete cart[id]; renderCart(); }

        function updateQuantity(id, qty) {
            qty = parseInt(qty);
            if (qty > 0 && qty <= cart[id].stock_actual) { cart[id].cantidad = qty; renderCart(); }
            else { renderCart(); }
        }

        function renderCart() {
            let total = 0;
            cartTableBody.innerHTML = '';
            const hiddenItems = document.getElementById('hidden-cart-items');
            hiddenItems.innerHTML = '';

            Object.values(cart).forEach((item, index) => {
                const subtotal = item.cantidad * item.precio_unitario;
                total += subtotal;

                const row = cartTableBody.insertRow();
                row.innerHTML = `
                    <td>${item.producto_id}</td>
                    <td>${item.codigo_barras} / ${item.descripcion}</td>
                    <td>$ ${item.precio_unitario.toFixed(2)}</td>
                    <td><input type="number" min="1" max="${item.stock_actual}" value="${item.cantidad}" class="form-control form-control-sm" onchange="updateQuantity(${item.producto_id}, this.value)"></td>
                    <td>$ ${subtotal.toFixed(2)}</td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeProductFromCart(${item.producto_id})">X</button></td>
                `;

                hiddenItems.innerHTML += `
                    <input type="hidden" name="cart_items[${index}][producto_id]" value="${item.producto_id}">
                    <input type="hidden" name="cart_items[${index}][cantidad]" value="${item.cantidad}">
                    <input type="hidden" name="cart_items[${index}][precio_unitario]" value="${item.precio_unitario}">
                `;
            });

            const totalFormatted = total.toFixed(2);
            cartTotalDisplay.textContent = `$ ${totalFormatted}`;
            displayTotal.textContent = `$ ${totalFormatted}`;
            inputTotal.value = totalFormatted;

            checkCredit();
        }

        // --- LÓGICA DE REGLAS DE NEGOCIO ---
        function checkCredit() {
            if (Object.keys(cart).length === 0) {
                btnProcesar.disabled = true;
                return;
            }

            const clienteId = inputClienteId.value;
            // Comparación flexible (==) por si viene como string "13" vs número 13
            const esPublicoGeneral = (clienteId == ID_CLIENTE_PUBLICO);

            // REGLA: Si es Público General (13), FORZAR Efectivo y BLOQUEAR selector
            if (esPublicoGeneral) {
                if (selectMetodoPago.value != ID_METODO_EFECTIVO) {
                    selectMetodoPago.value = ID_METODO_EFECTIVO;
                }
                selectMetodoPago.disabled = true;
            } else {
                selectMetodoPago.disabled = false;
            }

            const metodoPago = selectMetodoPago.options[selectMetodoPago.selectedIndex];
            if (!metodoPago || selectMetodoPago.value === "") {
                btnProcesar.disabled = true;
                return;
            }

            const metodoName = metodoPago.getAttribute('data-name');

            if (metodoName === 'Crédito' && (!clienteId || esPublicoGeneral)) {
                creditWarning.classList.remove('d-none');
                btnProcesar.disabled = true;
            } else {
                creditWarning.classList.add('d-none');
                btnProcesar.disabled = false;
            }
        }

        // Habilitar select antes de enviar para que vaya el dato en el POST
        document.getElementById('checkout-form').addEventListener('submit', function() {
            selectMetodoPago.disabled = false;
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Inicializar con ID 13
            inputClienteId.value = ID_CLIENTE_PUBLICO;
            selectMetodoPago.value = ID_METODO_EFECTIVO;
            checkCredit();
            if (searchInput) searchInput.focus();
        });
    </script>
@endsection
