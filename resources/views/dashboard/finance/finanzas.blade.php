@extends('layouts.dashboard')

@section('title','Resumen Financiero')

@section('content')
{{-- Tipografías --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">

    {{-- Tarjetas resumen --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-green-100 text-green-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Total Ingresos</h3>
            <p class="text-xl font-semibold">${{ number_format($totalIngresos, 0, ',', '.') }}</p>
        </div>
        <div class="bg-red-100 text-red-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Total Egresos</h3>
            <p class="text-xl font-semibold">${{ number_format($totalEgresos, 0, ',', '.') }}</p>
        </div>
        <div class="bg-blue-100 text-blue-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Balance</h3>
            <p class="text-xl font-semibold">${{ number_format($balance, 0, ',', '.') }}</p>
        </div>
    </div>
            {{-- Filtro y botón Agregar Movimiento --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            {{-- Filtro por fecha --}}
            <form method="GET" action="{{ route('dashboard.finanzas') }}" class="flex flex-wrap items-center gap-4">
                <div class="flex items-center gap-2">
                    <label for="desde" class="text-sm font-medium text-gray-700">Desde:</label>
                    <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                        class="px-3 py-2 border rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <div class="flex items-center gap-2">
                    <label for="hasta" class="text-sm font-medium text-gray-700">Hasta:</label>
                    <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                        class="px-3 py-2 border rounded-md shadow-sm text-sm focus:ring-green-500 focus:border-green-500">
                </div>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 text-sm">
                    Filtrar
                </button>
                @if(request()->filled('desde') || request()->filled('hasta'))
                    <a href="{{ route('dashboard.finanzas') }}"
                    class="px-4 py-2 border border-gray-300 rounded text-sm text-gray-700 bg-white hover:bg-gray-100 transition">
                    Limpiar
                    </a>
                @endif
            </form>

            {{-- Botón agregar --}}
            <a href="{{ route('finanzas.create') }}"
            class="flex items-center text-green-700 hover:text-green-800 transition-colors text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Agregar Movimiento
            </a>

            {{-- Descargar PDF --}}
            <a href="{{ route('finanzas.exportarPDF') }}"
            class="flex items-center text-blue-700 hover:text-blue-800 transition-colors text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14m7-7H5"/>
                </svg>
                Exportar PDF
            </a>
        </div>



    {{-- Tabla de finanzas --}}
    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider" style="font-family: 'Roboto Condensed', sans-serif;">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Fecha</th>
                    <th class="px-6 py-3 whitespace-nowrap">Tipo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Monto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Categoría</th>
                    <th class="px-6 py-3 whitespace-nowrap">Descripción</th>
                    <th class="px-6 py-3 whitespace-nowrap">Registrado por</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @forelse($finanzas as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">
                            @if($item->tipo === 'ingreso')
                                <span class="text-green-700 font-semibold">Ingreso</span>
                            @else
                                <span class="text-red-700 font-semibold">Egreso</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($item->monto, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->categoria }}</td>
                        <td class="px-6 py-4 whitespace-normal break-words max-w-[300px]">{{ $item->descripcion ?: '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->usuario->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('finanzas.edit', $item->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="{{ route('finanzas.destroy', $item->id) }}" method="POST" class="inline-block ml-2"
                                  onsubmit="return confirm('¿Deseas eliminar este movimiento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Anular</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                            No hay registros financieros.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
