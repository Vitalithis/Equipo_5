<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;

class HomeController extends Controller
{
    // Vista pública del sitio
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::paginate(12);
        $ultimos = Producto::toma4ultimos();
        return view('home', compact('categorias', 'productos', 'ultimos'));
    }

    // Vista protegida del dashboard
    public function dashboard()
    {
        return view('dashboard'); // Usa layouts/dashboard.blade.php
    }
}
