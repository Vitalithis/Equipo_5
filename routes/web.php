<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController, ProfileController, ProductoController, DescuentoController, CartController,
    PedidoController, BoletaController, WebpayController, CheckoutController, UserController,
    RoleController, UserRoleController, PermissionController, FertilizanteController,
    OrdenProduccionController, CuidadoController, FinanzaController, InsumoController,
    WorkController, PasswordController, ContactController, ClientController
};

// ====================
// 🌍 RUTAS DE LA APP
// ====================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])->name('producto.filterByCategory');
Route::get('/productos/filtrar/{category?}/{tamano?}/{dificultad?}/{ordenar_por?}/{ordenar_ascendente?}', [ProductoController::class, 'filter'])
    ->where(['tamano' => '\d+', 'ordenar_ascendente' => 'true|false'])
    ->name('productos.filter');

Route::view('/sobre-nosotros', 'about')->name('about');
Route::view('/contacto', 'contact')->name('contact');
Route::view('/faq', 'faq')->name('faq');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

require __DIR__ . '/auth.php';

// ====================
// 🛠 SOPORTE (LOCAL)
// ====================

Route::middleware(['web', 'auth', 'role:soporte'])->group(function () {
    Route::get('/soporte/inicio', fn () => redirect()->route('clients.index'))->name('soporte.inicio');
    Route::get('/soporte/clientes', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/soporte/clientes/crear', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/soporte/clientes', [ClientController::class, 'store'])->name('clients.store');
    Route::patch('/soporte/clientes/{cliente}/toggle', [ClientController::class, 'toggleActivo'])->name('clients.toggle');
    Route::get('/soporte/clientes/{cliente}', [ClientController::class, 'show'])->name('clients.show');
});

// ====================
// 🏘️ FUNCIONES MULTI-TENANT (EN LOCAL)
// ====================

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/usuarios', [UserRoleController::class, 'index'])->middleware('permission:gestionar usuarios')->name('users.index');
    Route::put('/usuarios/{user}/asignar-rol', [UserRoleController::class, 'updateRole'])->middleware('permission:gestionar usuarios')->name('users.updateRole');
    Route::resource('/users', UserController::class)->middleware('permission:gestionar usuarios');

    Route::resource('/roles', RoleController::class)->middleware('permission:ver roles');
    Route::resource('/permissions', PermissionController::class)->middleware('permission:gestionar permisos');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/password/change', [PasswordController::class, 'showChangeForm'])->name('password.change.form');
    Route::post('/password/change', [PasswordController::class, 'change'])->name('password.change');

    Route::prefix('/dashboard/catalogo')->middleware('permission:gestionar catálogo')->group(function () {
        Route::get('/', [ProductoController::class, 'dashboard_show'])->name('dashboard.catalogo');
        Route::get('/create', [ProductoController::class, 'create'])->name('catalogo.create');
        Route::post('/', [ProductoController::class, 'store'])->name('catalogo.store');
        Route::get('/{id}/edit', [ProductoController::class, 'edit'])->name('catalogo_edit');
        Route::put('/{id}', [ProductoController::class, 'update'])->name('catalogo.update');
        Route::delete('/{id}', [ProductoController::class, 'destroy'])->name('catalogo.destroy');
    });

    Route::resource('/dashboard/descuentos', DescuentoController::class)->except(['show'])->middleware('permission:gestionar descuentos');
    Route::resource('/pedidos', PedidoController::class)->middleware('permission:gestionar pedidos');

    Route::prefix('/boletas')->group(function () {
        Route::get('/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');
        Route::get('/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
        Route::post('/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');
    });

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

    Route::get('/pagar', [WebpayController::class, 'pagar'])->name('webpay.pagar');
    Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');
    Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::resource('/dashboard/fertilizantes', FertilizanteController::class)->middleware('permission:gestionar productos');

    Route::prefix('/dashboard/cuidados')->middleware('permission:gestionar productos')->group(function () {
        Route::get('/', [CuidadoController::class, 'index'])->name('dashboard.cuidados');
        Route::get('/create', [CuidadoController::class, 'create'])->name('dashboard.cuidados.create');
        Route::post('/', [CuidadoController::class, 'store'])->name('dashboard.cuidados.store');
        Route::get('/{id}/edit', [CuidadoController::class, 'edit'])->name('dashboard.cuidados.edit');
        Route::put('/{id}', [CuidadoController::class, 'update'])->name('dashboard.cuidados.update');
        Route::delete('/{id}', [CuidadoController::class, 'destroy'])->name('dashboard.cuidados.destroy');
        Route::get('/{id}/pdf', [CuidadoController::class, 'generarPdf'])->name('dashboard.cuidados.pdf');
    });

    Route::prefix('/finanzas')->middleware('permission:gestionar productos')->group(function () {
        Route::get('/', [FinanzaController::class, 'index'])->name('dashboard.finanzas');
        Route::get('/crear', [FinanzaController::class, 'create'])->name('finanzas.create');
        Route::post('/', [FinanzaController::class, 'store'])->name('finanzas.store');
        Route::get('/{id}/editar', [FinanzaController::class, 'edit'])->name('finanzas.edit');
        Route::put('/{id}', [FinanzaController::class, 'update'])->name('finanzas.update');
        Route::delete('/{id}', [FinanzaController::class, 'destroy'])->name('finanzas.destroy');
    });

    Route::prefix('/insumos')->middleware('permission:gestionar productos')->group(function () {
        Route::get('/', [InsumoController::class, 'index'])->name('dashboard.insumos');
        Route::get('/crear', [InsumoController::class, 'create'])->name('insumos.create');
        Route::post('/', [InsumoController::class, 'store'])->name('insumos.store');
        Route::get('/{id}/editar', [InsumoController::class, 'edit'])->name('insumos.edit');
        Route::put('/{id}', [InsumoController::class, 'update'])->name('insumos.update');
        Route::delete('/{id}', [InsumoController::class, 'destroy'])->name('insumos.destroy');
    });

    Route::resource('/works', WorkController::class);
    Route::patch('/works/{work}/status', [WorkController::class, 'updateStatus'])->name('works.updateStatus');
});
