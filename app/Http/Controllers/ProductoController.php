<?php
// app/Http/Controllers/ProductoController.php
namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function home()
    {
        $productos = Producto::all();
        return view('home', compact('producto'));
    }
}
