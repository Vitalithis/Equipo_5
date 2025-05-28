<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Work;

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
        // Obtener tareas pendientes y en progreso
        $tareasPendientes = Work::where('estado', 'pendiente')->get();
        $tareasEnProgreso = Work::where('estado', 'en progreso')->get();

        return view('dashboard', compact('tareasPendientes', 'tareasEnProgreso'));
    }
}
