@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    {{-- Bienvenida --}}
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-1">Bienvenido al Panel Administrativo</h2>
        <p class="text-sm text-gray-600">Resumen de tareas del vivero.</p>
    </div>

    {{-- Tarjetas resumen compactas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="bg-white shadow rounded-lg p-3">
            <p class="text-xs text-gray-500">💰 Ventas del mes</p>
            <p class="text-lg font-semibold text-green-600">${{ number_format($ventasMes, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-3">
            <p class="text-xs text-gray-500">📦 Pedidos del mes</p>
            <p class="text-lg font-semibold text-blue-600">{{ $pedidosMes }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-3">
            <p class="text-xs text-gray-500">📈 Ingresos totales</p>
            <p class="text-lg font-semibold text-green-700">${{ number_format($ingresosTotales, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-3">
            <p class="text-xs text-gray-500">📉 Egresos totales</p>
            <p class="text-lg font-semibold text-red-600">${{ number_format($egresosTotales, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-3">
            <p class="text-xs text-gray-500">🧮 Balance actual</p>
            <p class="text-lg font-semibold text-indigo-600">
                ${{ number_format($ingresosTotales - $egresosTotales, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Gráficos compactos con filtros --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        {{-- Gráfico de Ventas Diarias --}}
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-sm font-semibold text-gray-800">📊 Ventas Diarias</h3>
                <input type="month" id="mesVentasSelector"
                       class="border border-gray-300 rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500">
            </div>
            <canvas id="graficoVentas" class="w-full h-48"></canvas>
        </div>

        {{-- Gráfico de Ingresos vs Egresos con selector --}}
        <div class="bg-white shadow rounded-lg p-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="text-sm font-semibold text-gray-800">🥧 Ingresos vs Egresos</h3>
                <input type="month" id="mesSelector"
                       class="border border-gray-300 rounded px-2 py-1 text-xs focus:ring-2 focus:ring-blue-500">
            </div>
            <canvas id="graficoTorta" class="w-full h-48"></canvas>
        </div>
    </div>

    {{-- Tablas de Tareas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Tareas Pendientes --}}
        <div class="bg-white shadow-sm rounded p-3">
            <h3 class="text-base font-bold text-gray-800 mb-3">🕒 Tareas Pendientes</h3>
            @if($tareasPendientes->isEmpty())
                <p class="text-sm text-gray-500 italic">No hay tareas pendientes.</p>
            @else
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="pb-1">Tarea</th>
                            <th class="pb-1">Responsable</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($tareasPendientes as $tarea)
                            <tr class="border-b border-gray-100 hover:bg-red-50 transition">
                                <td class="py-2 font-medium text-red-700">{{ $tarea->nombre }}</td>
                                <td class="py-2">{{ $tarea->responsable }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Tareas en Progreso --}}
        <div class="bg-white shadow-sm rounded p-3">
            <h3 class="text-base font-bold text-gray-800 mb-3">🚧 Tareas en Progreso</h3>
            @if($tareasEnProgreso->isEmpty())
                <p class="text-sm text-gray-500 italic">No hay tareas en progreso.</p>
            @else
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="pb-1">Tarea</th>
                            <th class="pb-1">Responsable</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($tareasEnProgreso as $tarea)
                            <tr class="border-b border-gray-100 hover:bg-yellow-50 transition">
                                <td class="py-2 font-medium text-yellow-700">{{ $tarea->nombre }}</td>
                                <td class="py-2">{{ $tarea->responsable }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de barras (ventas por día)
    const ctxVentas = document.getElementById('graficoVentas').getContext('2d');
    let chartVentas = new Chart(ctxVentas, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Ventas diarias ($)',
            data: [],
            backgroundColor: 'rgba(59, 130, 246, 0.5)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 500000,
                    callback: function(value) {
                        return '$' + value.toLocaleString('es-CL');
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true
            }
        }
    }
});


    document.getElementById('mesVentasSelector').addEventListener('change', async function () {
    const mes = this.value;
    if (!mes) return;

    try {
        const response = await fetch(`/api/ventas/por-dia?mes=${mes}`);
        const data = await response.json();

        const labels = data.labels;
        const valores = data.valores;

        chartVentas.data.labels = labels;
        chartVentas.data.datasets[0].data = valores;

        // Detectar valor máximo y ajustar escala Y
        const maxValor = Math.max(...valores, 0);
        const escalaMax = Math.ceil(maxValor / 500000) * 500000 || 500000;

        chartVentas.options.scales.y.max = escalaMax;
        chartVentas.options.scales.y.ticks.stepSize = 500000;

        chartVentas.update();
    } catch (error) {
        console.error('Error al obtener ventas:', error);
        alert('No se pudieron cargar las ventas del mes.');
    }
});


    document.getElementById('mesVentasSelector').value = new Date().toISOString().slice(0, 7);
    document.getElementById('mesVentasSelector').dispatchEvent(new Event('change'));

    // Gráfico de torta
    const ctxTorta = document.getElementById('graficoTorta').getContext('2d');
    let chartTorta = new Chart(ctxTorta, {
        type: 'pie',
        data: {
            labels: ['Ingresos', 'Egresos'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#10b981', '#ef4444'],
                borderColor: ['#047857', '#b91c1c'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    document.getElementById('mesSelector').addEventListener('change', async function () {
        const mes = this.value;
        if (!mes) return;

        try {
            const response = await fetch(`/api/finanzas/ingresos-egresos?mes=${mes}`);
            const data = await response.json();

            chartTorta.data.datasets[0].data = [data.ingresos, data.egresos];
            chartTorta.update();
        } catch (error) {
            console.error('Error al cargar datos:', error);
            alert('No se pudo obtener la información financiera del mes.');
        }
    });

    document.getElementById('mesSelector').value = new Date().toISOString().slice(0, 7);
    document.getElementById('mesSelector').dispatchEvent(new Event('change'));
</script>
@endpush