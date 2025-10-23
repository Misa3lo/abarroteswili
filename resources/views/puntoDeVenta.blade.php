<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de Venta - Abarrotes Wili</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f5f6fa;
            color: #2c3e50;
        }

        /* Sidebar Navigation */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #34495e;
            margin-bottom: 20px;
        }

        .logo h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .logo span {
            color: #3498db;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin: 5px 15px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #bdc3c7;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: #34495e;
            color: white;
        }

        .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background: #2980b9;
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .btn-success:hover {
            background: #219a52;
        }

        .btn-warning {
            background: #f39c12;
            color: white;
        }

        .btn-warning:hover {
            background: #e67e22;
        }

        .btn-danger {
            background: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background: #c0392b;
        }

        /* Layout Principal Punto de Venta */
        .pos-container {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 20px;
            height: calc(100vh - 120px);
        }

        /* Panel de Escaneo */
        .scan-panel {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .scan-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
        }

        .scan-input-container {
            display: flex;
            gap: 10px;
        }

        .scan-input {
            flex: 1;
            padding: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 5px;
            font-size: 16px;
            text-align: center;
        }

        .scan-input:focus {
            outline: none;
            border-color: #3498db;
        }

        .products-list {
            flex: 1;
            padding: 0;
            overflow-y: auto;
        }

        .scanned-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #ecf0f1;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .item-price {
            color: #7f8c8d;
            font-size: 14px;
        }

        .item-quantity {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 15px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 3px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 5px;
            font-size: 14px;
        }

        .item-total {
            font-weight: bold;
            color: #2c3e50;
            min-width: 80px;
            text-align: right;
        }

        .remove-item {
            color: #e74c3c;
            cursor: pointer;
            margin-left: 15px;
            padding: 5px;
        }

        /* Panel de Venta Actual */
        .sale-panel {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .sale-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
            text-align: center;
        }

        .sale-header h3 {
            margin-bottom: 10px;
        }

        .current-sale {
            flex: 1;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        .sale-totals {
            background: #f8f9fa;
            padding: 20px;
            border-top: 1px solid #ecf0f1;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .total-row.final {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            border-top: 2px solid #ecf0f1;
            padding-top: 10px;
            margin-top: 10px;
        }

        .sale-actions {
            padding: 20px;
            border-top: 1px solid #ecf0f1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }

        .payment-btn {
            padding: 15px;
            border: 2px solid #ecf0f1;
            background: white;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 14px;
        }

        .payment-btn.active {
            border-color: #3498db;
            background: #3498db;
            color: white;
        }

        .action-btns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        /* Estados vacíos */
        .empty-state {
            text-align: center;
            color: #7f8c8d;
            padding: 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.5;
        }
    </style>
</head>
<body>
<!-- Sidebar Navigation -->
<nav class="sidebar">
    <div class="logo">
        <h1>Abarrotes <span>Wili</span></h1>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link">
                <i>📊</i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="/punto-de-venta" class="nav-link active">
                <i>🛒</i> Punto de Venta
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-inventario" class="nav-link">
                <i>📦</i> Inventario
            </a>
        </li>
        <li class="nav-item">
            <a href="/gestion-clientes" class="nav-link">
                <i>👥</i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a href="/productos" class="nav-link">
                <i>🏷️</i> Productos
            </a>
        </li>
        <li class="nav-item">
            <a href="/ventas" class="nav-link">
                <i>💰</i> Ventas
            </a>
        </li>
        <li class="nav-item">
            <a href="/creditos" class="nav-link">
                <i>💳</i> Créditos
            </a>
        </li>
        <li class="nav-item">
            <a href="/usuarios" class="nav-link">
                <i>👤</i> Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a href="/login" class="nav-link" style="color: #e74c3c;">
                <i>🚪</i> Cerrar Sesión
            </a>
        </li>
    </ul>
</nav>

<!-- Main Content -->
<main class="main-content">
    <!-- Header -->
    <header class="header">
        <h2>Punto de Venta</h2>
        <div class="user-info">
            <div class="user-avatar">AW</div>
            <span>Empleado</span>
            <div style="display: flex; gap: 10px;">
                <button class="btn btn-danger" onclick="cancelSale()">
                    <i>🗑️</i> Cancelar Venta
                </button>
            </div>
        </div>
    </header>

    <!-- Contenedor Principal -->
    <div class="pos-container">
        <!-- Panel de Escaneo -->
        <div class="scan-panel">
            <div class="scan-header">
                <h3>Escáner de Productos</h3>
                <div class="scan-input-container" style="margin-top: 15px;">
                    <input type="text" class="scan-input" id="barcodeInput" placeholder="Escanee o ingrese el código de barras..." autofocus>
                    <button class="btn btn-primary" onclick="scanProduct()">
                        <i>📷</i> Agregar
                    </button>
                </div>
            </div>
            <div class="products-list" id="productsList">
                <div class="empty-state">
                    <i>🛒</i>
                    <div>No hay productos escaneados</div>
                    <div style="font-size: 14px; margin-top: 10px;">Escanea productos usando el código de barras</div>
                </div>
            </div>
        </div>

        <!-- Panel de Venta Actual -->
        <div class="sale-panel">
            <div class="sale-header">
                <h3>Resumen de Venta</h3>
                <div id="saleInfo">Productos: 0</div>
            </div>
            <div class="current-sale">
                <div class="sale-totals">
                    <div class="total-row">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="total-row">
                        <span>IVA (16%):</span>
                        <span id="iva">$0.00</span>
                    </div>
                    <div class="total-row final">
                        <span>Total:</span>
                        <span id="total">$0.00</span>
                    </div>
                </div>
            </div>
            <div class="sale-actions">
                <div class="payment-methods">
                    <button class="payment-btn active" onclick="selectPaymentMethod('efectivo')">
                        💵 Efectivo
                    </button>
                    <button class="payment-btn" onclick="selectPaymentMethod('credito')">
                        📝 Crédito
                    </button>
                </div>
                <div class="action-btns">
                    <button class="btn" style="background: #6c757d; color: white;" onclick="holdSale()">
                        ⏸️ Suspender
                    </button>
                    <button class="btn btn-success" onclick="processSale()" id="processBtn" disabled>
                        ✅ Cobrar $0.00
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    // Variables globales
    let cart = [];
    let paymentMethod = 'efectivo';

    // Simulación de base de datos de productos
    const productsDatabase = {
        '750123456789': { id: 'PR001', name: 'Arroz Integral', price: 25.00, stock: 45 },
        '750123456788': { id: 'PR002', name: 'Leche Entera 1L', price: 22.00, stock: 8 },
        '750123456787': { id: 'PR003', name: 'Refresco Cola 2L', price: 28.00, stock: 15 },
        '750123456786': { id: 'PR004', name: 'Jabón de Barra', price: 12.00, stock: 20 },
        '750123456785': { id: 'PR005', name: 'Papas Fritas', price: 18.00, stock: 5 },
        '750123456784': { id: 'PR006', name: 'Aceite Vegetal 1L', price: 35.00, stock: 12 },
        '750123456783': { id: 'PR007', name: 'Atún en Lata', price: 15.00, stock: 25 }
    };

    // Función para escanear producto
    function scanProduct() {
        const barcodeInput = document.getElementById('barcodeInput');
        const barcode = barcodeInput.value.trim();

        if (!barcode) {
            alert('Ingrese un código de barras');
            return;
        }

        const product = productsDatabase[barcode];

        if (!product) {
            alert('Producto no encontrado. Verifique el código de barras.');
            barcodeInput.value = '';
            barcodeInput.focus();
            return;
        }

        addToCart(product);
        barcodeInput.value = '';
        barcodeInput.focus();
    }

    // Función para agregar al carrito
    function addToCart(product) {
        const existingItem = cart.find(item => item.id === product.id);

        if (existingItem) {
            if (existingItem.quantity < product.stock) {
                existingItem.quantity++;
                updateDisplay();
            } else {
                alert('No hay suficiente stock disponible');
            }
        } else {
            if (product.stock > 0) {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1,
                    stock: product.stock,
                    barcode: Object.keys(productsDatabase).find(key => productsDatabase[key].id === product.id)
                });
                updateDisplay();
            } else {
                alert('Producto agotado');
            }
        }
    }

    // Función para remover producto
    function removeFromCart(productId) {
        cart = cart.filter(item => item.id !== productId);
        updateDisplay();
    }

    // Función para actualizar cantidad
    function updateQuantity(productId, newQuantity) {
        const item = cart.find(item => item.id === productId);
        if (item && newQuantity > 0 && newQuantity <= item.stock) {
            item.quantity = newQuantity;
            updateDisplay();
        }
    }

    // Función para actualizar la visualización
    function updateDisplay() {
        const productsList = document.getElementById('productsList');
        const saleInfo = document.getElementById('saleInfo');
        const subtotalElement = document.getElementById('subtotal');
        const ivaElement = document.getElementById('iva');
        const totalElement = document.getElementById('total');
        const processBtn = document.getElementById('processBtn');

        // Actualizar lista de productos escaneados
        if (cart.length === 0) {
            productsList.innerHTML = `
                <div class="empty-state">
                    <i>🛒</i>
                    <div>No hay productos escaneados</div>
                    <div style="font-size: 14px; margin-top: 10px;">Escanea productos usando el código de barras</div>
                </div>
            `;
        } else {
            let itemsHTML = '';
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                itemsHTML += `
                    <div class="scanned-item">
                        <div class="item-info">
                            <div class="item-name">${item.name}</div>
                            <div class="item-price">$${item.price.toFixed(2)} c/u</div>
                        </div>
                        <div class="item-quantity">
                            <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity - 1})">-</button>
                            <input type="number" class="quantity-input" value="${item.quantity}"
                                   onchange="updateQuantity('${item.id}', parseInt(this.value))" min="1" max="${item.stock}">
                            <button class="quantity-btn" onclick="updateQuantity('${item.id}', ${item.quantity + 1})">+</button>
                        </div>
                        <div class="item-total">$${itemTotal.toFixed(2)}</div>
                        <div class="remove-item" onclick="removeFromCart('${item.id}')" title="Eliminar producto">🗑️</div>
                    </div>
                `;
            });
            productsList.innerHTML = itemsHTML;
        }

        // Actualizar totales
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        const iva = subtotal * 0.16;
        const total = subtotal + iva;

        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        ivaElement.textContent = `$${iva.toFixed(2)}`;
        totalElement.textContent = `$${total.toFixed(2)}`;

        // Actualizar información de venta
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        saleInfo.textContent = `Productos: ${totalItems}`;

        // Habilitar/deshabilitar botón de cobrar
        processBtn.disabled = cart.length === 0;
        processBtn.textContent = `✅ Cobrar $${total.toFixed(2)}`;
    }

    // Función para seleccionar método de pago
    function selectPaymentMethod(method) {
        paymentMethod = method;
        document.querySelectorAll('.payment-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
    }

    // Función para procesar venta
    function processSale() {
        if (cart.length === 0) {
            alert('Agregue productos a la venta antes de cobrar');
            return;
        }

        const total = parseFloat(document.getElementById('total').textContent.replace('$', ''));

        if (paymentMethod === 'efectivo') {
            const amount = prompt(`Total a cobrar: $${total.toFixed(2)}\nIngrese el monto recibido:`);
            if (amount && parseFloat(amount) >= total) {
                const change = parseFloat(amount) - total;
                alert(`Venta procesada exitosamente\nCambio: $${change.toFixed(2)}\n¡Gracias por su compra!`);
                resetSale();
            } else if (amount) {
                alert('El monto ingresado es menor al total de la venta');
            }
        } else if (paymentMethod === 'credito') {
            alert(`Venta a crédito procesada exitosamente\nTotal: $${total.toFixed(2)}\nSe ha registrado en el sistema de créditos`);
            resetSale();
        }
    }

    // Función para cancelar venta
    function cancelSale() {
        if (confirm('¿Está seguro de cancelar la venta actual? Se perderán todos los productos escaneados.')) {
            resetSale();
        }
    }

    // Función para suspender venta
    function holdSale() {
        if (cart.length === 0) {
            alert('No hay productos en la venta para suspender');
            return;
        }
        alert('Venta suspendida. Puede reanudarla más tarde.');
    }

    // Función para resetear venta
    function resetSale() {
        cart = [];
        updateDisplay();
        document.getElementById('barcodeInput').focus();
    }

    // Event listener para Enter en el input de código de barras
    document.getElementById('barcodeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            scanProduct();
        }
    });

    // Navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Enfocar input al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('barcodeInput').focus();
    });
</script>
</body>
</html>
