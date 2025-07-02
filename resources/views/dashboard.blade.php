@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-2 h-full">
    {{-- Fila 1: Tarjetas resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-2">
        <div class="bg-white shadow rounded-lg p-2">
            <p class="text-[10px] text-gray-500">💰 Ventas del mes</p>
            <p class="text-base font-semibold text-green-600">${{ number_format($ventasMes, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-2">
            <p class="text-[10px] text-gray-500">📦 Pedidos del mes</p>
            <p class="text-base font-semibold text-blue-600">{{ $pedidosMes }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-2">
            <p class="text-[10px] text-gray-500">📈 Ingresos totales</p>
            <p class="text-base font-semibold text-green-700">${{ number_format($ingresosTotales, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-2">
            <p class="text-[10px] text-gray-500">📉 Egresos totales</p>
            <p class="text-base font-semibold text-red-600">${{ number_format($egresosTotales, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-2">
            <p class="text-[10px] text-gray-500">🧮 Balance actual</p>
            <p class="text-base font-semibold text-indigo-600">
                ${{ number_format($ingresosTotales - $egresosTotales, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Fila 2: Gráficos y trasplantes --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 flex-1 min-h-0">
        <div class="bg-white shadow rounded-lg p-2 flex flex-col h-full">
            <h3 class="text-xs font-semibold text-gray-800 mb-2">📊 Ventas últimos 3 meses</h3>
            <div class="flex-1 relative">
                <canvas id="graficoVentas" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg p-2 flex flex-col h-full">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-xs font-semibold text-gray-800">🥧 Ingresos vs Egresos</h3>
                <input type="month" id="mesSelector" class="text-xs border border-gray-300 rounded px-2 py-1">
            </div>
            <div class="flex-1 relative">
                <canvas id="graficoTorta" class="absolute inset-0 w-full h-full"></canvas>
            </div>
        </div>

        <div class="flex flex-col gap-2 h-full min-h-0">
            {{-- Trasplantes --}}
            <div class="bg-white shadow-sm rounded p-2 flex flex-col flex-1 overflow-auto">
                <h3 class="text-xs font-bold text-gray-800 mb-1">🌱 Próximos Trasplantes</h3>
                @if($trasplantesProximos->isEmpty())
                    <p class="text-xs text-gray-500 italic">No hay trasplantes en los próximos días.</p>
                @else
                    <div class="overflow-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="text-gray-600 border-b">
                                    <th class="pb-0.5">Planta</th>
                                    <th class="pb-0.5">Cantidad</th>
                                    <th class="pb-0.5">Fecha Trasplante</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @foreach ($trasplantesProximos as $evento)
                                    @php
                                        $fecha = \Carbon\Carbon::parse($evento->fecha_trasplante);
                                        $hoy = \Carbon\Carbon::today();
                                        $clase = match(true) {
                                            $fecha->isToday() => 'bg-green-100 text-green-800 font-semibold',
                                            $fecha->isTomorrow() => 'bg-yellow-100 text-yellow-800 font-semibold',
                                            default => '',
                                        };
                                    @endphp
                                    <tr class="border-b border-gray-100 hover:bg-green-50 transition {{ $clase }}">
                                        <td class="py-0.5 font-medium">{{ $evento->planta }}</td>
                                        <td class="py-0.5">{{ $evento->cantidad ?? '—' }}</td>
                                        <td class="py-0.5">{{ $fecha->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Tareas Pendientes --}}
            <div class="bg-white shadow-sm rounded p-2 flex flex-col flex-1 overflow-auto">
                <h3 class="text-xs font-bold text-gray-800 mb-1">🕒 Tareas Pendientes</h3>
                @if($tareasPendientes->isEmpty())
                    <p class="text-xs text-gray-500 italic">No hay tareas pendientes.</p>
                @else
                    <div class="overflow-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="text-gray-600 border-b">
                                    <th class="pb-0.5">Tarea</th>
                                    <th class="pb-0.5">Responsable</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @foreach ($tareasPendientes as $tarea)
                                    <tr class="border-b border-gray-100 hover:bg-red-50 transition">
                                        <td class="py-0.5 font-medium text-red-700">{{ $tarea->nombre }}</td>
                                        <td class="py-0.5">{{ $tarea->responsable }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Tareas en Progreso --}}
            <div class="bg-white shadow-sm rounded p-2 flex flex-col flex-1 overflow-auto">
                <h3 class="text-xs font-bold text-gray-800 mb-1">🚧 Tareas en Progreso</h3>
                @if($tareasEnProgreso->isEmpty())
                    <p class="text-xs text-gray-500 italic">No hay tareas en progreso.</p>
                @else
                    <div class="overflow-auto">
                        <table class="min-w-full text-xs">
                            <thead>
                                <tr class="text-gray-600 border-b">
                                    <th class="pb-0.5">Tarea</th>
                                    <th class="pb-0.5">Responsable</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-800">
                                @foreach ($tareasEnProgreso as $tarea)
                                    <tr class="border-b border-gray-100 hover:bg-yellow-50 transition">
                                        <td class="py-0.5 font-medium text-yellow-700">{{ $tarea->nombre }}</td>
                                        <td class="py-0.5">{{ $tarea->responsable }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Fila 3: Stock Bajo y Pedidos --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        <div class="bg-white shadow rounded-lg p-2 flex flex-col h-full overflow-auto">
            <h3 class="text-xs font-bold text-gray-800 mb-1">⚠️ Productos con Stock Bajo</h3>
            @if($productosStockBajo->isEmpty())
                <p class="text-xs text-gray-500 italic">No hay productos con stock bajo.</p>
            @else
                <div class="overflow-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-gray-600 border-b">
                                <th class="pb-0.5">Producto</th>
                                <th class="pb-0.5">Stock</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @foreach ($productosStockBajo as $producto)
                                <tr class="border-b border-gray-100 hover:bg-yellow-50 transition">
                                    <td class="py-0.5 font-medium">{{ $producto->nombre }}</td>
                                    <td class="py-0.5 text-right">{{ $producto->stock }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-2 flex flex-col h-full overflow-auto">
            <h3 class="text-xs font-bold text-gray-800 mb-1">🚚 Pedidos Pendientes de Entrega</h3>
            @if($pedidosPendientesEntrega->isEmpty())
                <p class="text-xs text-gray-500 italic">No hay pedidos pendientes de entrega.</p>
            @else
                <div class="overflow-auto">
                    <table class="min-w-full text-xs">
                        <thead>
                            <tr class="text-gray-600 border-b">
                                <th class="pb-0.5">Cliente</th>
                                <th class="pb-0.5">Estado</th>
                                <th class="pb-0.5">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @foreach ($pedidosPendientesEntrega as $pedido)
                                <tr class="border-b border-gray-100 hover:bg-blue-50 transition">
                                    <td class="py-0.5 font-medium">{{ $pedido->usuario->name ?? '—' }}</td>
                                    <td class="py-0.5">{{ $pedido->estadoFormateado() }}</td>
                                    <td class="py-0.5">{{ $pedido->fecha_pedido ? \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === Gráfico de Ventas últimos 3 meses ===
    const ctxVentas = document.getElementById('graficoVentas').getContext('2d');
    let chartVentas = new Chart(ctxVentas, {
        type: 'bar',
        data: { labels: [], datasets: [] },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => '$' + value.toLocaleString('es-CL')
                    }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
    function cargarVentasUltimos3Meses() {
        fetch('/api/ventas/ultimos-3-meses')
            .then(r => r.json())
            .then(data => {
                chartVentas.data.labels = data.labels;
                chartVentas.data.datasets = [
                    {
                        label: 'Ventas por mes',
                        data: data.valores,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(234, 179, 8, 0.7)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(234, 179, 8, 1)'
                        ],
                        borderWidth: 1
                    }
                ];
                chartVentas.update();
            });
    }
    cargarVentasUltimos3Meses();

    // === Gráfico de Torta ===
    const ctxTorta = document.getElementById('graficoTorta').getContext('2d');
    let chartTorta = new Chart(ctxTorta, {
        type: 'doughnut',
        data: {
            labels: ['Ingresos', 'Egresos'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#10B981', '#EF4444'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            plugins: { legend: { display: true } }
        }
    });
    function cargarTorta() {
        const mes = document.getElementById('mesSelector').value;
        let url = '/api/finanzas/ingresos-egresos';
        if (mes) url += `?mes=${mes}`;
        fetch(url)
            .then(r => r.json())
            .then(data => {
                chartTorta.data.datasets[0].data = [data.ingresos, data.egresos];
                chartTorta.update();
            });
    }
    // Setear mes actual si no hay valor
    const mesInput = document.getElementById('mesSelector');
    if (mesInput && !mesInput.value) {
        const now = new Date();
        mesInput.value = now.toISOString().slice(0, 7);
    }
    mesInput.addEventListener('change', cargarTorta);
    cargarTorta();
});
</script>
@endpush
