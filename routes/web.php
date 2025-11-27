<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SurtidoController;
// Agregaremos más controladores según los vayamos creando
// Ruta para mostrar el formulario (extraer productos)
Route::get('/surtidos/create', [SurtidoController::class, 'create'])->name('surtidos.create');

// Ruta para procesar el formulario (ejecutar el Stored Procedure)
Route::post('/surtidos', [SurtidoController::class, 'store'])->name('surtidos.store');

// Ruta opcional para listar surtidos
Route::get('/surtidos', [SurtidoController::class, 'index'])->name('surtidos.index');


Route::resource('productos', ProductoController::class);
//Route::resource('surtidos', SurtidoController::class);

Route::post('/surtidos/registrar', [SurtidoController::class, 'registrarConProcedimiento'])
    ->name('surtidos.registrar');

// Rutas principales
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/login', function () {
    return view('iniciosesion');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Rutas de módulos CRUD (Vistas)
Route::get('/clientes', function () {
    return view('clientes.index');
});

Route::get('/abonos', function () {
    return view('abonos.index');
});

Route::get('/creditos', function () {
    return view('creditos.index');
});

Route::get('/departamentos', function () {
    return view('departamentos.index');
});

Route::get('/metodos-pago', function () {
    return view('metodospago.index');
});

Route::get('/personas', function () {
    return view('personas.index');
});

// Route::get('/productos', function () {
//     return view('productos.index');
// });

// Route::get('/surtidos', function () {
//     return view('surtidos.index');
// });

Route::get('/tickets', function () {
    return view('tickets.index');
});

Route::get('/usuarios', function () {
    return view('usuarios.index');
});

Route::get('/ventas', function () {
    return view('ventas.index');
});

// Rutas adicionales existentes
Route::get('/punto-de-venta', function () {
    return view('puntoDeVenta');
});

Route::get('/gestion-clientes', function () {
    return view('gestionDeClientes');
});

Route::get('/gestion-inventario', function () {
    return view('gestionInventario');
});

Route::get('/nuevo-usuario', function () {
    return view('nuevoUsuario');
});
