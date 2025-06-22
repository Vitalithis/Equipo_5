<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Vista pública del sitio
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::paginate(4);
        $ultimos = Producto::toma4ultimos();
        $pref = Auth::user()?->preference;

        return view('home', compact('categorias', 'productos', 'ultimos', 'pref'));
    }

    // Vista protegida del dashboard
    public function dashboard()
    {
        $tareasPendientes = Work::where('estado', 'pendiente')->get();
        $tareasEnProgreso = Work::where('estado', 'en progreso')->get();
        $pref = Auth::user()?->preference;

        return view('dashboard', compact('tareasPendientes', 'tareasEnProgreso', 'pref'));
    }
}
