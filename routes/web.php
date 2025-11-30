<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PersonaController; // <-- NECESARIO
use App\Http\Controllers\AbonoController;
// Agregaremos más controladores según los vayamos creando

// Rutas principales
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); // Se recomienda nombrar la ruta

Route::get('/', function () {
    return view('iniciosesion');
});

// Rutas de módulos CRUD (Recursos)
// ===================================

// Clientes: Define las 7 rutas CRUD (index, create, store, show, edit, update, destroy)
Route::resource('clientes', ClienteController::class);

// Personas: Define las 7 rutas CRUD para el directorio general
Route::resource('personas', PersonaController::class);

// Ruta adicional para la búsqueda de Personas (método 'search' no estándar)
Route::get('personas/search', [PersonaController::class, 'search'])->name('personas.search');


// Rutas de módulos de solo vista (Temporales)
// ==============================================
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
