<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;

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


// Ruta para mostrar el carrito y nombrarla "cart.index"
Route::get('/cart', [CartController::class, 'index'])

     ->name('cart.index')
     ->middleware('auth'); // opcional: si requieres que el usuario esté autenticado
Route::post('/guardar-carrito', [CartController::class, 'guardarCarrito'])->middleware('auth');

// Ruta para obtener el carrito
Route::get('/obtener-carrito', [CartController::class, 'obtenerCarrito'])->middleware('auth');

// Ruta para vaciar el carrito
Route::post('/vaciar-carrito', [CartController::class, 'vaciarCarrito'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/pagar',      [WebpayController::class, 'pagar'])->name('webpay.pagar');
    Route::post('/respuesta', [WebpayController::class, 'respuesta'])->name('webpay.respuesta');
});
Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
Route::get('/checkout/response', [CheckoutController::class, 'response'])->name('checkout.response');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
Route::post('/cart/add/{id}', [CartController::class, 'agregarProducto'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'actualizarProducto'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/carrito/agregar/{id}', [CartController::class, 'add'])->name('cart.add');

Route::get('/producto/{slug}', [ProductoController::class, 'show'])->name('products.show');
Route::get('/productos', [ProductoController::class, 'home'])->name('products.index');
Route::get('/productos/categoria/{category}', [ProductoController::class, 'filterByCategory'])->name('producto.filterByCategory');

Route::get('/sobre-nosotros', function () {
    return view('about'); // Asegúrate de tener una vista resources/views/about.blade.php
})->name('about');
Route::get('/contacto', function () {
    return view('contact'); // Asegúrate de tener resources/views/contact.blade.php
})->name('contact');
Route::get('/faq', function () {
    return view('faq'); // Asegúrate de tener resources/views/contact.blade.php
})->name('faq');

require __DIR__ . '/auth.php';
