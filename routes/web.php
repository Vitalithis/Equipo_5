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
use App\Http\Controllers\PermissionController;

use App\Http\Controllers\FertilizanteController;
use App\Http\Controllers\OrdenProduccionController;
use App\Http\Controllers\CuidadoController;
use App\Http\Controllers\FinanzaController;
use App\Http\Controllers\InsumoController;

use App\Models\ProductCategory;

use App\Http\Controllers\AdminClienteController;
use App\Http\Controllers\ClienteController;

use App\Http\Controllers\WorkController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth', 'role:soporte'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/clientes', [AdminClienteController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/crear', [AdminClienteController::class, 'create'])->name('clientes.create');
    Route::post('/clientes', [AdminClienteController::class, 'store'])->name('clientes.store');
    Route::get('/clientes/{cliente}/usuarios', [AdminClienteController::class, 'usuarios'])->name('clientes.usuarios');
    Route::get('/clientes/{cliente}/productos', [AdminClienteController::class, 'productos'])->name('clientes.productos');
    Route::delete('/clientes/{cliente}', [AdminClienteController::class, 'destroy'])->name('clientes.destroy');
    Route::get('/admin/cliente/{cliente}/asignar-permisos', [AdminClienteController::class, 'asignarPermisosExistente'])->name('admin.clientes.asignarPermisos');

});



Route::middleware(['auth'])->group(function () {
    Route::middleware(['permission:ver dashboard'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'dashboard'])
            ->middleware(['auth', 'permission:ver dashboard'])
            ->name('dashboard');

        Route::get('/usuarios', [UserRoleController::class, 'index'])->middleware('permission:gestionar usuarios')->name('users.index');
        Route::put('/usuarios/{user}/asignar-rol', [UserRoleController::class, 'updateRole'])->middleware('permission:gestionar usuarios')->name('users.updateRole');

        Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:ver roles')->name('roles.index');
        Route::get('/roles/create', [RoleController::class, 'create'])->middleware('permission:crear roles')->name('roles.create');
        Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:crear roles')->name('roles.store');
        Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->middleware('permission:editar roles')->name('roles.edit');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:editar roles')->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:eliminar roles')->name('roles.destroy');
    });

    Route::middleware(['permission:gestionar permisos'])->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });

    Route::middleware(['permission:gestionar ingresos'])->group(function () {
        Route::get('/ingresos', [IngresoController::class, 'index'])->name('ingresos.index');
    });

    Route::middleware(['permission:gestionar egresos'])->group(function () {
        Route::get('/egresos', [EgresoController::class, 'index'])->name('egresos.index');
    });
});

Route::get('dashboard.catalogo', [ProductoController::class, 'dashboard_show'])
    ->middleware(['auth', 'permission:gestionar catálogo'])
    ->name('dashboard.catalogo');
Route::get('/dashboard/catalogo/create', [ProductoController::class, 'create'])->middleware('permission:gestionar catálogo')->name('catalogo.create');
Route::post('/dashboard/catalogo', [ProductoController::class, 'store'])->middleware('permission:gestionar catálogo')->name('catalogo.store');
Route::get('/dashboard/catalogo/{id}/edit', [ProductoController::class, 'edit'])->middleware('permission:gestionar catálogo')->name('catalogo_edit');
Route::put('/dashboard/catalogo/{id}', [ProductoController::class, 'update'])->middleware('permission:gestionar catálogo')->name('catalogo.update');
Route::delete('/dashboard/catalogo/{id}', [ProductoController::class, 'destroy'])->middleware('permission:gestionar catálogo')->name('catalogo.destroy');

Route::get('/dashboard/descuentos', [DescuentoController::class, 'mostrarTodos'])->middleware(['auth', 'permission:gestionar descuentos'])->name('dashboard.descuentos');
Route::get('dashboard/descuentos/create', [DescuentoController::class, 'create'])->middleware('permission:gestionar descuentos')->name('descuentos.create');
Route::post('/dashboard/descuentos', [DescuentoController::class, 'store'])->middleware('permission:gestionar descuentos')->name('descuentos.store');
Route::get('/dashboard/descuentos/{id}/edit', [DescuentoController::class, 'edit'])->middleware('permission:gestionar descuentos')->name('descuentos_edit');
Route::put('/dashboard/descuentos/{id}', [DescuentoController::class, 'update'])->middleware('permission:gestionar descuentos')->name('descuentos.update');
Route::delete('/dashboard/descuentos/{id}', [DescuentoController::class, 'destroy'])->middleware('permission:gestionar descuentos')->name('descuentos.destroy');
// Ruta Formulario Contacto
use App\Http\Controllers\ContactController;

Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('pedidos', PedidoController::class)->middleware('permission:gestionar pedidos');

Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generar'])->name('boletas.provisoria');
Route::get('/boletas/{pedido}/pdf', [BoletaController::class, 'generarPDF'])->name('boletas.pdf');
Route::post('/boletas/{pedido}/subir', [BoletaController::class, 'guardar'])->name('boletas.subir');
Route::get('/boletas/{pedido}/provisoria', [BoletaController::class, 'generarProvisoria'])->name('boletas.provisoria');

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/agregar', [CartController::class, 'agregarProducto'])->name('cart.agregar');
    Route::post('/cart/actualizar/{id}', [CartController::class, 'actualizarProducto'])->name('cart.actualizar');

    // Eliminar producto del carrito (sesión)
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove.solo');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/guardar', [CartController::class, 'guardarCarrito'])->name('cart.guardar');
    Route::get('/cart/obtener', [CartController::class, 'obtenerCarrito'])->name('cart.obtener');
    Route::post('/cart/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Vaciar carrito en base de datos
    Route::delete('/cart/vaciar', [CartController::class, 'vaciarCarrito'])->name('cart.vaciar');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/pagar', [WebpayController::class, 'pagar'])->name('webpay.pagar');
    Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');
});

Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::put('/cart/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');
Route::post('/cart/aplicar-descuento', [CartController::class, 'aplicarDescuento'])->name('cart.aplicar-descuento');

Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])
    ->name('producto.filterByCategory');
Route::get(
    '/productos/filtrar/{category?}/{tamano?}/{dificultad?}/{ordenar_por?}/{ordenar_ascendente?}',
    [ProductoController::class, 'filter']
)
    ->where([
        'tamano' => '\d+',
        'ordenar_ascendente' => 'true|false'
    ])
    ->name('productos.filter');
Route::get('/sobre-nosotros', function () {
    return view('about');
})->name('about');
Route::get('/contacto', function () {
    return view('contact');
})->name('contact');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/dashboard/fertilizantes', [FertilizanteController::class, 'mostrarTodos'])->middleware(['auth', 'permission:gestionar productos'])->name('dashboard.fertilizantes');
Route::get('/dashboard/fertilizantes/create', [FertilizanteController::class, 'create'])->middleware('permission:gestionar productos')->name('fertilizantes.create');
Route::post('/dashboard/fertilizantes', [FertilizanteController::class, 'store'])->middleware('permission:gestionar productos')->name('fertilizantes.store');
Route::get('/dashboard/fertilizantes/{id}/edit', [FertilizanteController::class, 'edit'])->middleware('permission:gestionar productos')->name('fertilizantes.edit');
Route::put('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'update'])->middleware('permission:gestionar productos')->name('fertilizantes.update');
Route::delete('/dashboard/fertilizantes/{id}', [FertilizanteController::class, 'destroy'])->middleware('permission:gestionar productos')->name('fertilizantes.destroy');

Route::prefix('dashboard/ordenes-produccion')->middleware(['auth', 'permission:ver ordenes'])->group(function () {
    Route::get('/', [OrdenProduccionController::class, 'index'])->name('dashboard.ordenes');
    Route::get('/create', [OrdenProduccionController::class, 'create'])->middleware('permission:crear ordenes')->name('ordenes.create');
    Route::post('/', [OrdenProduccionController::class, 'store'])->middleware('permission:crear ordenes')->name('ordenes.store');
    Route::get('/{id}/edit', [OrdenProduccionController::class, 'edit'])->middleware('permission:editar ordenes')->name('ordenes.edit');
    Route::put('/{id}', [OrdenProduccionController::class, 'update'])->middleware('permission:editar ordenes')->name('ordenes.update');
    Route::delete('/{id}', [OrdenProduccionController::class, 'destroy'])->middleware('permission:eliminar ordenes')->name('ordenes.destroy');
    Route::get('/ordenes/export/pdf', [OrdenProduccionController::class, 'exportarPDF'])->name('ordenes.export.pdf');

});


//Rutas para cuidados de cada Planta

Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/cuidados', [CuidadoController::class, 'index'])->name('dashboard.cuidados');
    Route::get('/cuidados/create', [CuidadoController::class, 'create'])->name('dashboard.cuidados.create');
    Route::post('/cuidados', [CuidadoController::class, 'store'])->name('dashboard.cuidados.store');
    Route::get('/cuidados/{id}/edit', [CuidadoController::class, 'edit'])->name('dashboard.cuidados.edit');
    Route::put('/cuidados/{id}', [CuidadoController::class, 'update'])->name('dashboard.cuidados.update');
    Route::delete('/cuidados/{id}', [CuidadoController::class, 'destroy'])->name('dashboard.cuidados.destroy');
    Route::get('/dashboard/cuidados/{id}/pdf', [CuidadoController::class, 'generarPdf'])->name('dashboard.cuidados.pdf');

});

// Rutas para el mantenedor de finanzas
Route::prefix('finanzas')->middleware(['auth'])->group(function () {
    Route::get('/', [FinanzaController::class, 'index'])->name('dashboard.finanzas');
    Route::get('/crear', [FinanzaController::class, 'create'])->name('finanzas.create');
    Route::post('/', [FinanzaController::class, 'store'])->name('finanzas.store');
    Route::get('/{id}/editar', [FinanzaController::class, 'edit'])->name('finanzas.edit');
    Route::put('/{id}', [FinanzaController::class, 'update'])->name('finanzas.update');
    Route::delete('/{id}', [FinanzaController::class, 'destroy'])->name('finanzas.destroy');
});
//ruta tareas
Route::resource('works', WorkController::class);

//Rutas para el mantenedor de insumos
Route::middleware(['auth'])->prefix('insumos')->group(function () {
    Route::get('/', [InsumoController::class, 'index'])->name('dashboard.insumos');
    Route::get('/crear', [InsumoController::class, 'create'])->name('insumos.create');
    Route::post('/', [InsumoController::class, 'store'])->name('insumos.store');
    Route::get('/{id}/editar', [InsumoController::class, 'edit'])->name('insumos.edit');
    Route::put('/{id}', [InsumoController::class, 'update'])->name('insumos.update');
    Route::delete('/{id}', [InsumoController::class, 'destroy'])->name('insumos.destroy');
});

require __DIR__ . '/auth.php';
