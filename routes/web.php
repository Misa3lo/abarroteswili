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

// Redirección de la raíz al login
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// Formulario de login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Procesamiento del login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- GRUPO DE RUTAS PROTEGIDAS (Requieren Iniciar Sesión) ---
// Todo lo que está dentro de este grupo requerirá una sesión activa.
Route::middleware(['auth'])->group(function () {

    // 1. Dashboard (Punto de entrada principal)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Punto de Venta (Generalmente accesible para todos)
    Route::get('/punto-de-venta', [TicketController::class, 'create'])->name('puntoDeVenta');
    Route::resource('tickets', TicketController::class)->only(['index', 'store', 'show', 'destroy']);


    // 3. Rutas CRUD generales
    Route::resource('abonos', AbonoController::class)->except(['show']);
    Route::resource('clientes', ClienteController::class);
    Route::resource('creditos', CreditoController::class)->except(['create', 'store']);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('metodos-pago', MetodoPagoController::class);
    Route::resource('personas', PersonaController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('surtidos', SurtidoController::class)->except(['update', 'destroy']);

    // Búsqueda de Personas
    Route::get('personas/search', [PersonaController::class, 'search'])->name('personas.search');


    // 4. Rutas de CRÉDITOS
    Route::prefix('creditos')->group(function () {
        Route::get('/', [CreditoController::class, 'index'])->name('creditos.index');
        Route::get('/{credito}', [CreditoController::class, 'show'])->name('creditos.show');
        Route::post('/{credito}/abono', [CreditoController::class, 'storeAbono'])->name('creditos.storeAbono');
    });


    // 5. Rutas de Administrador (Doble protección: 'auth' + 'can:administrador')
    Route::middleware(['can:administrador'])->group(function () {
        Route::resource('usuarios', UsuarioController::class);
        Route::view('/gestion-clientes', 'gestionDeClientes')->name('gestionDeClientes');
        Route::view('/gestion-inventario', 'gestionInventario')->name('gestionInventario');
        Route::view('/reporte-ventas', 'ventas.index')->name('ventas.index');
    });

}); // CIERRE DEL GRUPO PROTEGIDO CON 'auth'
