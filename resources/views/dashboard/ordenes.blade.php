@extends('layouts.dashboard')

@section('title', 'Órdenes de Producción')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div x-data="{ modalOrden: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="{{ route('ordenes.create') }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Orden
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Código</th>
                    <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Trabajador</th>
                    <th class="px-6 py-3 whitespace-nowrap">Información</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @forelse($ordenes as $orden)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $orden->codigo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $orden->producto->nombre ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $orden->trabajador->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="modalOrden = {{ $orden->id }}"
                                    class="text-green-600 hover:text-green-800 transition font-medium">
                                Ver detalles
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="{{ route('ordenes.edit', $orden->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</a>
                            <form action="{{ route('ordenes.destroy', $orden->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div x-cloak x-show="modalOrden === {{ $orden->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div @click.away="modalOrden = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold">Orden {{ $orden->codigo }}</h2>
                                <button @click="modalOrden = null" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-sm leading-relaxed">
                                <div><span class="font-semibold">Producto:</span> {{ $orden->producto->nombre ?? '-' }}</div>
                                <div><span class="font-semibold">Cantidad:</span> {{ $orden->cantidad }}</div>
                                <div><span class="font-semibold">Fecha de Inicio:</span> {{ \Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y') }}</div>
                                <div><span class="font-semibold">Fecha Estimada:</span>
                                    {{ $orden->fecha_fin_estimada ? \Carbon\Carbon::parse($orden->fecha_fin_estimada)->format('d/m/Y') : '-' }}
                                </div>
                                <div><span class="font-semibold">Estado:</span> {{ ucfirst($orden->estado) }}</div>
                                <div><span class="font-semibold">Trabajador:</span> {{ $orden->trabajador->name ?? '—' }}</div>
                                <div><span class="font-semibold">Observaciones:</span><br>
                                    <p class="whitespace-pre-line">{{ $orden->observaciones ?? 'Sin observaciones.' }}</p>
                                </div>
                            </div>
                            <div class="mt-6 text-right">
                                <button @click="modalOrden = null"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">No hay órdenes registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
