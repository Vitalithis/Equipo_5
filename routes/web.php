<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\DescuentoController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\PedidoController;
use App\Http\Controllers\BoletaController;


use App\Http\Controllers\WebpayController;
use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserRoleController;

use App\Http\Controllers\FertilizanteController;
use App\Http\Controllers\OrdenProduccionController;
use App\Models\ProductCategory;


Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);

// Rutas para el Dashboard
Route::middleware(['auth', 'role:admin|superadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/dashboard2', function () {
        return view('dashboard2');
    })->name('dashboard2');
});

// Grupo protegido con middleware: solo superadmin puede gestionar roles
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    // Gestión de roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    // Asignar roles a usuarios
    Route::get('/admin/roles', [UserRoleController::class, 'manageRoles'])->name('roles.manage');
    Route::put('/admin/users/{user}/role', [UserRoleController::class, 'updateRole'])->name('users.updateRole');
});




// Todo lo que es gestión de productos del catalogo
Route::get('dashboard.catalogo', [ProductoController::class, 'dashboard_show'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.catalogo');
Route::get('/dashboard/catalogo/create', [ProductoController::class, 'create'])->name('catalogo.create');
Route::post('/dashboard/catalogo', [ProductoController::class, 'store'])->name('catalogo.store');

Route::get('/dashboard/catalogo/{id}/edit', [ProductoController::class, 'edit'])->name('catalogo_edit');

Route::put('/dashboard/catalogo/{id}', [ProductoController::class, 'update'])->name('catalogo.update');

Route::delete('/dashboard/catalogo/{id}', [ProductoController::class, 'destroy'])->name('catalogo.destroy');

// Todo lo relacionado a descuentos y promos
Route::get('/dashboard/descuentos', [DescuentoController::class, 'mostrarTodos'])->middleware(['auth', 'verified'])->name('dashboard.descuentos');

Route::get('dashboard/descuentos/create',     [DescuentoController::class, 'create'])->name('descuentos.create');
Route::post('/dashboard/descuentos',          [DescuentoController::class, 'store'])->name('descuentos.store');
Route::get('/dashboard/descuentos/{id}/edit', [DescuentoController::class, 'edit'])->name('descuentos_edit');
Route::put('/dashboard/descuentos/{id}',      [DescuentoController::class, 'update'])->name('descuentos.update');
Route::delete('/dashboard/descuentos/{id}',   [DescuentoController::class, 'destroy'])->name('descuentos.destroy');


Route::get('/ingresos', function () {
    return view('ingresos');
})->name('ingresos');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Pedidos
Route::resource('pedidos', PedidoController::class);
//boleta
// Boletas
Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generar'])->name('boletas.provisoria');
Route::get('/boletas/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
Route::post('/boletas/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');
Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');

Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');

Route::middleware(['auth'])->group(function () {
    // Mostrar carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

    // Agregar producto al carrito (sesión)
    Route::post('/cart/agregar', [CartController::class, 'agregarProducto'])->name('cart.agregar');

    // Actualizar producto en el carrito (sesión)
    Route::post('/cart/actualizar/{id}', [CartController::class, 'actualizarProducto'])->name('cart.actualizar');

    // Eliminar producto del carrito (sesión)
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove.solo');

    // Vaciar carrito (sesión)
    //Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove.todo');


    // Agregar producto al carrito (BD)
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');

    // Guardar carrito en base de datos
    Route::post('/cart/guardar', [CartController::class, 'guardarCarrito'])->name('cart.guardar');

    // Obtener carrito desde base de datos
    Route::get('/cart/obtener', [CartController::class, 'obtenerCarrito'])->name('cart.obtener');

    // Vaciar carrito en base de datos
    Route::post('/cart/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    //Route::post('/cart/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');

});
Route::middleware('auth')->group(function () {
    Route::get('/pagar',      [WebpayController::class, 'pagar'])->name('webpay.pagar');
    Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');
});
// Routes de paypal
Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::put('/cart/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');

// Ruta para aplicar un descuento al carrito
Route::post('/cart/aplicar-descuento', [CartController::class, 'aplicarDescuento'])->name('cart.aplicar-descuento');


Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])->name('producto.filterByCategory');


Route::get('/sobre-nosotros', function () {
    return view('about');
})->name('about');
Route::get('/contacto', function () {
    return view('contact');
})->name('contact');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Ruta para el Mantenedor de Fertilizante

Route::get('/dashboard/fertilizantes', [FertilizanteController::class, 'mostrarTodos'])->middleware(['auth', 'verified'])->name('dashboard.fertilizantes');
Route::get('/dashboard/fertilizantes/create', [FertilizanteController::class, 'create'])->name('fertilizantes.create');
Route::post('/dashboard/fertilizantes', [FertilizanteController::class, 'store'])->name('fertilizantes.store');
Route::get('/dashboard/fertilizantes/{id}/edit', [FertilizanteController::class, 'edit'])->name('fertilizantes.edit');
Route::put('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'update'])->name('fertilizantes.update');
Route::delete('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'destroy'])->name('fertilizantes.destroy');


// Rutas para orden de producción


Route::prefix('dashboard/ordenes-produccion')->middleware(['auth'])->group(function () {
    Route::get('/', [OrdenProduccionController::class, 'index'])->name('dashboard.ordenes');
    Route::get('/create', [OrdenProduccionController::class, 'create'])->name('ordenes.create');
    Route::post('/', [OrdenProduccionController::class, 'store'])->name('ordenes.store');
    Route::get('/{id}/edit', [OrdenProduccionController::class, 'edit'])->name('ordenes.edit');
    Route::put('/{id}', [OrdenProduccionController::class, 'update'])->name('ordenes.update');
    Route::delete('/{id}', [OrdenProduccionController::class, 'destroy'])->name('ordenes.destroy');
});

require __DIR__ . '/auth.php';
