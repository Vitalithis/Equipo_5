@extends('layouts.dashboard')

@section('title', 'Órdenes de Producción')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-6xl mx-auto">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Órdenes de Producción</h1>
        <a href="{{ route('ordenes.create') }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Orden
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Código</th>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Cantidad</th>
                    <th class="px-4 py-3 text-left">Fecha Inicio</th>
                    <th class="px-4 py-3 text-left">Fecha Estimada</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($ordenes as $orden)
                    <tr>
                        <td class="px-4 py-3">{{ $orden->codigo }}</td>
                        <td class="px-4 py-3">{{ $orden->producto->nombre ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $orden->cantidad }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3">
                            {{ $orden->fecha_fin_estimada ? \Carbon\Carbon::parse($orden->fecha_fin_estimada)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-4 py-3 capitalize">{{ $orden->estado }}</td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('ordenes.edit', $orden->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="{{ route('ordenes.destroy', $orden->id) }}" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay órdenes registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
