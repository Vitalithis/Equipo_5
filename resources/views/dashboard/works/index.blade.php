@extends('layouts.dashboard')

@section('title', 'Gestión de Tareas del Vivero')

@section('content')
<div class="font-['Roboto'] text-gray-800">
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-bold"></h2>
        <a href="{{ route('works.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow inline-flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Nueva tarea
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Sección: Producción --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">🌱 Producción</h3>
            <div class="space-y-3">
                @foreach ($works->where('ubicacion', 'produccion') as $tarea)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-green-500">
                        <div class="font-semibold">{{ $tarea->nombre }}</div>
                        <div class="text-sm text-gray-600">
                            Responsable: {{ $tarea->responsable }}<br>
                            Fecha: {{ \Carbon\Carbon::parse($tarea->fecha)->format('d/m/Y') }}<br>
                            Estado: <span class="text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded">{{ ucfirst($tarea->estado) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Sección: Local de Venta --}}
        <div>
            <h3 class="text-xl font-semibold mb-2">🛒 Local de Venta</h3>
            <div class="space-y-3">
                @foreach ($works->where('ubicacion', 'venta') as $tarea)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-yellow-500">
                        <div class="font-semibold">{{ $tarea->nombre }}</div>
                        <div class="text-sm text-gray-600">
                            Responsable: {{ $tarea->responsable }}<br>
                            Fecha: {{ \Carbon\Carbon::parse($tarea->fecha)->format('d/m/Y') }}<br>
                            Estado: <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded">{{ ucfirst($tarea->estado) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
