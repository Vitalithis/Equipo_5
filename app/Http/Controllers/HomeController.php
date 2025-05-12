<?php

// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class HomeController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::paginate(12);
        $ultimos = Producto::toma4ultimos();
        return view('home', compact('categorias', 'productos', 'ultimos'));
    }
}
