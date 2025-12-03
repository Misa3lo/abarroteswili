<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
// Importar todos los controladores que usarás
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SurtidoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UsuarioController;


// --- RUTAS DE AUTENTICACIÓN (Públicas) ---

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- GRUPO 1: RUTAS PERMITIDAS PARA EMPLEADO Y ADMINISTRADOR (auth) ---
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Punto de Venta (PDV)
    Route::get('/punto-de-venta', [TicketController::class, 'create'])->name('puntoDeVenta');
    // La acción de procesar la venta (store)
    Route::post('/punto-de-venta', [TicketController::class, 'store'])->name('tickets.store');

    // 3. Historial de Tickets (index y show)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    // Nota: Eliminamos la línea 'Route::resource('tickets', TicketController::class)->only(['index', 'store', 'show', 'destroy']);'
    // para evitar duplicidad y tener control explícito sobre cada acción.

}); // CIERRE DEL GRUPO PROTEGIDO CON 'auth'


// --- GRUPO 2: RUTAS RESTRINGIDAS (SOLO ADMINISTRADOR) ---
// Estas rutas son solo para el rol 'administrador'
Route::middleware(['auth', 'can:administrador'])->group(function () {

    // CRUD de Usuarios y Vistas de Gestión
    Route::resource('usuarios', UsuarioController::class);
    Route::view('/gestion-clientes', 'gestionDeClientes')->name('gestionDeClientes');
    Route::view('/gestion-inventario', 'gestionInventario')->name('gestionInventario');
    Route::view('/reporte-ventas', 'ventas.index')->name('ventas.index');

    // Rutas CRUD de Datos Sensibles:
    Route::resource('productos', ProductoController::class);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('metodos-pago', MetodoPagoController::class);
    Route::resource('personas', PersonaController::class);
    Route::resource('abonos', AbonoController::class)->except(['show']);
    Route::resource('surtidos', SurtidoController::class)->except(['update', 'destroy']);

    // Búsqueda de Personas (Relacionado al CRUD de Clientes)
    Route::get('personas/search', [PersonaController::class, 'search'])->name('personas.search');

    // CRÉDITOS (Toda la gestión, incluyendo la vista de abonos)
    Route::resource('creditos', CreditoController::class)->except(['create', 'store']);
    Route::post('/creditos/{credito}/abono', [CreditoController::class, 'storeAbono'])->name('creditos.storeAbono');

    // Anulación de Tickets (es una acción sensible)
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

}); // CIERRE DEL GRUPO PROTEGIDO CON 'can:administrador'
