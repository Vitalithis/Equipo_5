<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Work;
use App\Models\SeedEvent;
use Carbon\Carbon;

class HomeController extends Controller
{
    // Vista pública del sitio
    public function index()
    {
        $categorias = Categoria::all();
        $productos = Producto::paginate(4);
        $ultimos = Producto::toma4ultimos();

        return view('home', compact('categorias', 'productos', 'ultimos'));
    }

    // Vista protegida del dashboard
    public function dashboard()
    {
        // Tareas
        $tareasPendientes = Work::where('estado', 'pendiente')->get();
        $tareasEnProgreso = Work::where('estado', 'en progreso')->get();

        // Solo trasplantes con fecha dentro de los próximos 7 días y máximo 10 registros
        $hoy = Carbon::today();
        $sieteDias = $hoy->copy()->addDays(7);

        $trasplantesProximos = SeedEvent::whereNotNull('fecha_trasplante')
            ->whereBetween('fecha_trasplante', [$hoy, $sieteDias])
            ->orderBy('fecha_trasplante')
            ->limit(10) // 👈 límite de 10
            ->get();

        return view('dashboard', compact(
            'tareasPendientes',
            'tareasEnProgreso',
            'trasplantesProximos'
        ));
    }
}
