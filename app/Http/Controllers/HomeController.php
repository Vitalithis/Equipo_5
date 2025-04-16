<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        $categoria = Categoria::all();
        $producto = Producto::all();

        return view('home', compact('categoria', 'producto'));
    }
}
