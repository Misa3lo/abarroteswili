<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Método de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">➕ Crear Método de Pago</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('metodos-pago.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                                   id="descripcion" name="descripcion"
                                   value="{{ old('descripcion') }}"
                                   required maxlength="50" placeholder="Ej: Tarjeta de Débito">
                            @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success">💾 Guardar</button>
                            <a href="{{ route('metodos-pago.index') }}" class="btn btn-secondary">🔙 Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
