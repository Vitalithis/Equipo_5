<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\PedidoController;
use App\Http\Controllers\BoletaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
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
Route::get('/dashboard/descuentos', function () {
    return view('dashboard.descuentos');
})->middleware(['auth', 'verified'])->name('dashboard.descuentos');

Route::get('dashboard/descuentos/create', [CategoriaController::class, 'create'])->name('descuentos.create');
Route::post('/dashboard/descuentos', [CategoriaController::class, 'store'])->name('descuentos.store');
Route::get('/dashboard/descuentos/{id}/edit', [CategoriaController::class, 'edit'])->name('descuentos_edit');
Route::put('/dashboard/descuentos/{id}', [CategoriaController::class, 'update'])->name('descuentos.update');
Route::delete('/dashboard/descuentos/{id}', [CategoriaController::class, 'destroy'])->name('descuentos.destroy');


Route::get('/ingresos', function () {
    return view('ingresos');
})->name('ingresos');

//ruta para dashboard2
Route::get('/dashboard2', function () {
    return view('dashboard2');
})->middleware(['auth', 'verified'])->name('dashboard2');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\ProductCategory;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Obtener usuarios
    Route::put('/users/{user}/role', [UserController::class, 'updateRole']); // Actualizar rol
});

Route::middleware(['auth', 'superadmin'])->group(function () {
    // Rutas solo para superadmin
    Route::get('/admin/roles', [UserController::class, 'manageRoles'])->name('roles.manage');
    Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
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

Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');
Route::post('/carrito/agregar/{id}', [CartController::class, 'add'])->name('cart.add');

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

require __DIR__ . '/auth.php';
