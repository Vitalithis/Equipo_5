<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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
Route::prefix('pedidos')->name('pedidos.')->group(function () {
    Route::get('/', [PedidoController::class, 'index'])->name('index'); // Mostrar todos los pedidos
    Route::get('{pedido}', [PedidoController::class, 'show'])->name('show'); // Ver detalles del pedido
    Route::put('{pedido}', [PedidoController::class, 'update'])->name('update'); // Cambiar estado del pedido
    Route::get('{pedido}/boleta', [PedidoController::class, 'generarBoleta'])->name('generarBoleta'); // Generar PDF
    Route::post('{pedido}/boleta-subida', [PedidoController::class, 'subirBoleta'])->name('subirBoleta'); // Subir PDF del SII
});


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

Route::post('/boletas/generar', [BoletaController::class, 'generar'])->name('boletas.generar');

require __DIR__.'/auth.php';
