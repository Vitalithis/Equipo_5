@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="bg-white shadow rounded-lg p-4 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-1">Bienvenido al Panel Administrativo</h2>
        <p class="text-sm text-gray-600">Resumen de tareas del vivero.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Tabla: Tareas Pendientes --}}
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

        {{-- Tabla: Tareas en Progreso --}}
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

        {{-- Tabla: Próximos Trasplantes --}}
        <div class="bg-white shadow-sm rounded p-3 md:col-span-2">
            <h3 class="text-base font-bold text-gray-800 mb-3">🌱 Próximos Trasplantes</h3>
            @if($trasplantesProximos->isEmpty())
                <p class="text-sm text-gray-500 italic">No hay trasplantes en los próximos días.</p>
            @else
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-600 border-b">
                            <th class="pb-1">Planta</th>
                            <th class="pb-1">Cantidad</th>
                            <th class="pb-1">Fecha Trasplante</th>
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
                                <td class="py-2 font-medium">{{ $evento->planta }}</td>
                                <td class="py-2">{{ $evento->cantidad ?? '—' }}</td>
                                <td class="py-2">{{ $fecha->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
