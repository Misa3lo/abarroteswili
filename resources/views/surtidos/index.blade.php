<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Surtido - Abarrotes Wili</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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

        /* Simulando el área de contenido principal para la vista de registro */
        .content {
            padding: 30px;
            /* Si tienes un sidebar, añade un margen: margin-left: 250px; */
            background: #ffffff;
            min-height: 100vh;
            max-width: 900px;
            margin: 0 auto;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 25px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        .form-container {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Estilos para Alertas */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
        }

        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border: 1px solid #d6e9c6;
        }

        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border: 1px solid #ebccd1;
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.9em;
            margin-top: 5px;
            display: block;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

    </style>
</head>
<body>

<div class="content">
    <h2><i class="fas fa-box-open"></i> Registrar Nuevo Surtido</h2>
    <hr>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-times-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('surtidos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="producto_id">Seleccionar Producto</label>
                <select id="producto_id" name="producto_id" class="form-control" required>
                    <option value="">-- Seleccione un producto --</option>
                    @foreach ($productos as $producto)
                        <option 
                            value="{{ $producto->id }}" 
                            {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad a Surtir</label>
                <input 
                    type="number" 
                    id="cantidad" 
                    name="cantidad" 
                    class="form-control" 
                    min="0.01" 
                    step="0.01" 
                    value="{{ old('cantidad') }}" 
                    required>
                @error('cantidad')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_entrada">Precio de Entrada (Costo Unitario)</label>
                <input 
                    type="number" 
                    id="precio_entrada" 
                    name="precio_entrada" 
                    class="form-control" 
                    min="0.01" 
                    step="0.01" 
                    value="{{ old('precio_entrada') }}" 
                    required>
                @error('precio_entrada')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-truck-loading"></i> Registrar Surtido
            </button>
        </form>
    </div>
</div>

</body>
</html>