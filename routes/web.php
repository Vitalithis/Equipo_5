<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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
/*
Route::get('/', function () {
    return view('home');
});
*/

Route::get('/', [HomeController::class, 'index']);
//Route::get("/", [CategoriaController::class,"home"]);
//Route::get('/', [ProductoController::class, 'home']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/*
use App\Http\Controllers\ProductCategory;

Route::get('/categorias', [ProductCategory::class, 'home']);
Route::get('/categorias/{id}', [ProductCategory::class, 'show']);
*/


Route::get('/categoria', [CategoriaController::class, 'home']);
Route::get('/categoria/{id}', [CategoriaController::class, 'show']);


require __DIR__ . '/auth.php';
