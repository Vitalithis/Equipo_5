<?php
// app/Http/Controllers/ProductoController.php
namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function home()
    {
        $producto = Producto::all();
        return view('home', compact('productos'));
    }
}
