<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Work;
use App\Models\Pedido;
use App\Models\Finanza;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\SeedEvent;


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

        
    // Ventas mensuales
    $ventasPorMes = Pedido::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, SUM(total) as total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    $labels = $ventasPorMes->pluck('mes')->toArray();
    $valores = $ventasPorMes->pluck('total')->toArray();

    // Métricas actuales del mes
    $mesActual = Carbon::now()->format('Y-m');
    $inicio = $mesActual . '-01';
    $fin = Carbon::parse($inicio)->endOfMonth()->toDateString();

    $ventasMes = Pedido::whereBetween('created_at', [$inicio, $fin])->sum('total');
    $pedidosMes = Pedido::whereBetween('created_at', [$inicio, $fin])->count();

    $ingresosTotales = Finanza::where('tipo', 'ingreso')->sum('monto');
    $egresosTotales = Finanza::where('tipo', 'egreso')->sum('monto');

    // Widgets adicionales
    $productosStockBajo = Producto::stockBajo(10)->orderBy('stock')->limit(8)->get();
    $pedidosPendientesEntrega = Pedido::pendientesEntrega()->orderBy('fecha_pedido', 'desc')->limit(8)->get();

    return view('dashboard', compact(
        'tareasPendientes',
        'tareasEnProgreso',
        'labels',
        'valores',
        'ventasMes',
        'pedidosMes',
        'ingresosTotales',
        'egresosTotales',
        'trasplantesProximos',
        'productosStockBajo',
        'pedidosPendientesEntrega'
    ));
}
public function ingresosEgresosPorMes(Request $request)
{
    // Si no se pasa 'mes', devolver totales históricos (igual que las cards)
    if (!$request->has('mes')) {
        $ingresos = Finanza::where('tipo', 'ingreso')->sum('monto');
        $egresos = Finanza::where('tipo', 'egreso')->sum('monto');
        return response()->json([
            'ingresos' => $ingresos,
            'egresos' => $egresos
        ]);
    }
    $request->validate([
        'mes' => 'required|date_format:Y-m',
    ]);
    $inicio = $request->mes . '-01';
    $fin = date('Y-m-t', strtotime($inicio));
    $ingresos = Finanza::where('tipo', 'ingreso')
        ->whereBetween('fecha', [$inicio, $fin])
        ->sum('monto');
    $egresos = Finanza::where('tipo', 'egreso')
        ->whereBetween('fecha', [$inicio, $fin])
        ->sum('monto');
    return response()->json([
        'ingresos' => $ingresos,
        'egresos' => $egresos
    ]);
}

public function ventasPorDia(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m'
    ]);

    $inicio = $request->mes . '-01';
    $fin = \Carbon\Carbon::parse($inicio)->endOfMonth()->toDateString();

    $ventas = Pedido::selectRaw("DATE(created_at) as dia, SUM(total) as total")
        ->whereBetween('created_at', [$inicio, $fin])
        ->groupBy('dia')
        ->orderBy('dia')
        ->get();

    $labels = $ventas->pluck('dia')->map(function ($d) {
        return \Carbon\Carbon::parse($d)->format('d');
    });

    $valores = $ventas->pluck('total');

    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}

public function ventasPorSemana(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m'
    ]);

    $inicio = $request->mes . '-01';
    $fin = \Carbon\Carbon::parse($inicio)->endOfMonth()->toDateString();

    $ventas = \App\Models\Pedido::selectRaw(
        "YEARWEEK(created_at, 3) as semana, SUM(total) as total"
    )
        ->whereBetween('created_at', [$inicio, $fin])
        ->groupBy('semana')
        ->orderBy('semana')
        ->get();

    $labels = $ventas->pluck('semana')->map(function ($s) {
        // Formato: "Semana 23"
        return 'Semana ' . substr($s, -2);
    });
    $valores = $ventas->pluck('total');

    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}

public function ventasPorMes(Request $request)
{
    $request->validate([
        'anio' => 'required|date_format:Y'
    ]);

    $inicio = $request->anio . '-01-01';
    $fin = $request->anio . '-12-31';

    $ventas = \App\Models\Pedido::selectRaw(
        "DATE_FORMAT(created_at, '%Y-%m') as mes, SUM(total) as total"
    )
        ->whereBetween('created_at', [$inicio, $fin])
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    $labels = $ventas->pluck('mes');
    $valores = $ventas->pluck('total');

    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}

public function ventasUltimos6Meses(Request $request)
{
    $hoy = Carbon::now();
    $inicio = $hoy->copy()->subMonths(5)->startOfMonth();
    $fin = $hoy->endOfMonth();
    $ventas = Pedido::selectRaw("YEAR(created_at) as anio, MONTH(created_at) as mes_num, DATE_FORMAT(created_at, '%Y-%m') as mes, SUM(total) as total")
        ->whereBetween('created_at', [$inicio, $fin])
        ->groupBy('anio', 'mes_num', 'mes')
        ->orderBy('anio')
        ->orderBy('mes_num')
        ->get();
    $labels = [];
    $valores = [];
    for ($i = 5; $i >= 0; $i--) {
        $mes = $hoy->copy()->subMonths($i);
        $label = $mes->format('M y'); // Ej: Mar 24
        $mesKey = $mes->format('Y-m');
        $labels[] = $label;
        $valores[] = (float)($ventas->firstWhere('mes', $mesKey)->total ?? 0);
    }
    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}

public function ventasMesVsAnterior(Request $request)
{
    $request->validate([
        'mes' => 'required|date_format:Y-m'
    ]);
    $mesActual = Carbon::createFromFormat('Y-m', $request->mes);
    $mesAnterior = $mesActual->copy()->subMonth();
    $diasMes = $mesActual->daysInMonth;
    $labels = [];
    $actual = [];
    $anterior = [];
    for ($d = 1; $d <= $diasMes; $d++) {
        $labels[] = str_pad($d, 2, '0', STR_PAD_LEFT);
        $fechaActual = $mesActual->copy()->day($d)->format('Y-m-d');
        $fechaAnterior = $mesAnterior->copy()->day(min($d, $mesAnterior->daysInMonth))->format('Y-m-d');
        $totalActual = Pedido::whereDate('created_at', $fechaActual)->sum('total');
        $totalAnterior = Pedido::whereDate('created_at', $fechaAnterior)->sum('total');
        $actual[] = (float)$totalActual;
        $anterior[] = (float)$totalAnterior;
    }
    return response()->json([
        'labels' => $labels,
        'actual' => $actual,
        'anterior' => $anterior
    ]);
}

public function ventasUltimos3Meses(Request $request)
{
    $hoy = Carbon::now();
    $labels = [];
    $valores = [];
    for ($i = 2; $i >= 0; $i--) {
        $mes = $hoy->copy()->subMonths($i);
        $inicioMes = $mes->copy()->startOfMonth();
        $finMes = $mes->copy()->endOfMonth();
        $label = $mes->format('M y');
        $total = Pedido::whereBetween('created_at', [$inicioMes, $finMes])->sum('total');
        $labels[] = $label;
        $valores[] = (float)$total;
    }
    return response()->json([
        'labels' => $labels,
        'valores' => $valores
    ]);
}


   
}
