<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByPath;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

// Controllers generales
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\BoletaController;
use App\Http\Controllers\WebpayController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\FertilizanteController;
use App\Http\Controllers\OrdenProduccionController;
use App\Http\Controllers\CuidadoController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ClientController;

// Rutas públicas
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])->name('producto.filterByCategory');
Route::get('/productos/filtrar/{category?}/{tamano?}/{dificultad?}/{ordenar_por?}/{ordenar_ascendente?}', [ProductoController::class, 'filter'])
    ->where([
        'tamano' => '\d+',
        'ordenar_ascendente' => 'true|false'
    ])->name('productos.filter');

Route::get('/sobre-nosotros', fn() => view('about'))->name('about');
Route::get('/contacto', fn() => view('contact'))->name('contact');
Route::get('/faq', fn() => view('faq'))->name('faq');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

require __DIR__ . '/auth.php';

// Agrupación de rutas tenant por path
Route::middleware(['web', InitializeTenancyByPath::class, 'auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Usuarios
    Route::get('/usuarios', [UserRoleController::class, 'index'])->middleware('permission:gestionar usuarios')->name('users.index');
    Route::put('/usuarios/{user}/asignar-rol', [UserRoleController::class, 'updateRole'])->middleware('permission:gestionar usuarios')->name('users.updateRole');
    Route::get('/users/create', [UserController::class, 'create'])->middleware('permission:gestionar usuarios')->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:gestionar usuarios')->name('users.store');

    // Roles
    Route::resource('/roles', RoleController::class)->middleware('permission:ver roles');

    // Permisos
    Route::resource('/permissions', PermissionController::class)->middleware('permission:gestionar permisos');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cambio de contraseña
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change');

    // Catálogo
    Route::get('/dashboard/catalogo', [ProductoController::class, 'dashboard_show'])->middleware('permission:gestionar catálogo')->name('dashboard.catalogo');
    Route::get('/dashboard/catalogo/create', [ProductoController::class, 'create'])->middleware('permission:gestionar catálogo')->name('catalogo.create');
    Route::post('/dashboard/catalogo', [ProductoController::class, 'store'])->middleware('permission:gestionar catálogo')->name('catalogo.store');
    Route::get('/dashboard/catalogo/{id}/edit', [ProductoController::class, 'edit'])->middleware('permission:gestionar catálogo')->name('catalogo_edit');
    Route::put('/dashboard/catalogo/{id}', [ProductoController::class, 'update'])->middleware('permission:gestionar catálogo')->name('catalogo.update');
    Route::delete('/dashboard/catalogo/{id}', [ProductoController::class, 'destroy'])->middleware('permission:gestionar catálogo')->name('catalogo.destroy');

    // Descuentos
    Route::resource('/dashboard/descuentos', DescuentoController::class)->except(['show'])->middleware('permission:gestionar descuentos');

    // Pedidos
    Route::resource('/pedidos', PedidoController::class)->middleware('permission:gestionar pedidos');

    // Boletas
    Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');
    Route::get('/boletas/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
    Route::post('/boletas/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');

    // Carrito
    Route::prefix('/cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/agregar', [CartController::class, 'agregarProducto'])->name('cart.agregar');
        Route::post('/actualizar/{id}', [CartController::class, 'actualizarProducto'])->name('cart.actualizar');
        Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove.solo');
        Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
        Route::post('/guardar', [CartController::class, 'guardarCarrito'])->name('cart.guardar');
        Route::get('/obtener', [CartController::class, 'obtenerCarrito'])->name('cart.obtener');
        Route::post('/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');
        Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
        Route::put('/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');
        Route::post('/aplicar-descuento', [CartController::class, 'aplicarDescuento'])->name('cart.aplicar-descuento');
    });

    // Webpay
    Route::get('/pagar', [WebpayController::class, 'pagar'])->name('webpay.pagar');
    Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');

    // Checkout
    Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    // Fertilizantes
    Route::resource('/dashboard/fertilizantes', FertilizanteController::class)->middleware('permission:gestionar productos');

    // Cuidados
    Route::prefix('/dashboard/cuidados')->group(function () {
        Route::get('/', [CuidadoController::class, 'index'])->name('dashboard.cuidados');
        Route::get('/create', [CuidadoController::class, 'create'])->name('dashboard.cuidados.create');
        Route::post('/', [CuidadoController::class, 'store'])->name('dashboard.cuidados.store');
        Route::get('/{id}/edit', [CuidadoController::class, 'edit'])->name('dashboard.cuidados.edit');
        Route::put('/{id}', [CuidadoController::class, 'update'])->name('dashboard.cuidados.update');
        Route::delete('/{id}', [CuidadoController::class, 'destroy'])->name('dashboard.cuidados.destroy');
        Route::get('/{id}/pdf', [CuidadoController::class, 'generarPdf'])->name('dashboard.cuidados.pdf');
    });

    // Finanzas
    Route::prefix('/finanzas')->group(function () {
        Route::get('/', [FinanzaController::class, 'index'])->name('dashboard.finanzas');
        Route::get('/crear', [FinanzaController::class, 'create'])->name('finanzas.create');
        Route::post('/', [FinanzaController::class, 'store'])->name('finanzas.store');
        Route::get('/{id}/editar', [FinanzaController::class, 'edit'])->name('finanzas.edit');
        Route::put('/{id}', [FinanzaController::class, 'update'])->name('finanzas.update');
        Route::delete('/{id}', [FinanzaController::class, 'destroy'])->name('finanzas.destroy');
    });

    // Insumos
    Route::prefix('/insumos')->group(function () {
        Route::get('/', [InsumoController::class, 'index'])->name('dashboard.insumos');
        Route::get('/crear', [InsumoController::class, 'create'])->name('insumos.create');
        Route::post('/', [InsumoController::class, 'store'])->name('insumos.store');
        Route::get('/{id}/editar', [InsumoController::class, 'edit'])->name('insumos.edit');
        Route::put('/{id}', [InsumoController::class, 'update'])->name('insumos.update');
        Route::delete('/{id}', [InsumoController::class, 'destroy'])->name('insumos.destroy');
    });

    // Tareas del vivero
    Route::resource('/works', WorkController::class);
    Route::patch('/works/{work}/status', [WorkController::class, 'updateStatus'])->name('works.updateStatus');

    // Panel de soporte: gestión de clientes
    Route::middleware(['permission:gestionar clientes'])->group(function () {
        Route::get('/clientes', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/clientes/crear', [ClientController::class, 'create'])->name('clients.create');
        Route::post('/clientes', [ClientController::class, 'store'])->name('clients.store');
        Route::patch('/clientes/{cliente}/toggle', [ClientController::class, 'toggleActivo'])->name('clients.toggle');
    });
});
