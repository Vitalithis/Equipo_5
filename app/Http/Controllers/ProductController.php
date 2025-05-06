<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('products.index', compact('productos'));
    }
}
