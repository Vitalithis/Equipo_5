<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', [ProductController::class,'index'])->name('products.index');
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add',    [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');
Route::post('/cart/clear',  [CartController::class,'clear'])->name('cart.clear');


require __DIR__.'/auth.php';
