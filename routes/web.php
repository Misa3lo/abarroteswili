<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SurtidoController;



Route::get('/surtidos/procedimiento', [SurtidoController::class, 'create'])->name('surtidos.procedimiento');
Route::post('/surtidos/procedimiento', [SurtidoController::class, 'store'])->name('surtidos.procedimiento.store');

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

// Rutas de módulos CRUD
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

Route::get('/metodos-pago', [MetodoPagoController::class, 'index'])->name('metodos-pago.index');

Route::get('/personas', function () {
    return view('personas.index');
});

Route::get('/productos', function () {
    return view('productos.index');
});

Route::get('/surtidos', function () {
    return view('surtidos.index');
});

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



use App\Http\Controllers\MetodoPagoController;

Route::get('/metodos-pago', [MetodoPagoController::class, 'index'])->name('metodos-pago.index');
Route::get('/metodos-pago/create', [MetodoPagoController::class, 'create'])->name('metodos-pago.create');
Route::post('/metodos-pago', [MetodoPagoController::class, 'store'])->name('metodos-pago.store');
Route::get('/metodos-pago/{metodoPago}', [MetodoPagoController::class, 'show'])->name('metodos-pago.show');
Route::get('/metodos-pago/{metodoPago}/edit', [MetodoPagoController::class, 'edit'])->name('metodos-pago.edit');
Route::put('/metodos-pago/{metodoPago}', [MetodoPagoController::class, 'update'])->name('metodos-pago.update');
Route::delete('/metodos-pago/{metodoPago}', [MetodoPagoController::class, 'destroy'])->name('metodos-pago.destroy');
