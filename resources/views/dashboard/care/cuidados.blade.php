@extends('layouts.dashboard')

@section('title', 'Cuidados de Plantas')

@section('content')
{{-- Tipografías --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    {{-- Filtros y botón --}}
    <div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <form method="GET" action="{{ route('dashboard.cuidados') }}" class="flex flex-wrap gap-2 items-end md:items-center w-full md:max-w-2xl">
            <input type="text" name="producto" value="{{ request('producto') }}" placeholder="Buscar por Cuidado..."
                   class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

            <button type="submit" class="bg-eaccent2 text-white px-4 py-2 rounded hover:bg-green-700 text-sm w-full md:w-auto">
                Buscar
            </button>

            @if(request('producto') || request('tipo_luz'))
                <a href="{{ route('dashboard.cuidados') }}"
                   class="text-sm text-gray-600 hover:text-gray-800 underline w-full md:w-auto">
                    Limpiar
                </a>
            @endif
        </form>

        <a href="{{ route('dashboard.cuidados.create') }}"
           class="flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-2 rounded transition-colors whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Cuidado
        </a>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Riego</th>
                    <th class="px-6 py-3 whitespace-nowrap">Agua</th>
                    <th class="px-6 py-3 whitespace-nowrap">Luz</th>
                    <th class="px-6 py-3 whitespace-nowrap">Abono</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                    <th class="px-6 py-3 whitespace-nowrap">Archivos</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @forelse($cuidados as $cuidado)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->producto->nombre ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->frecuencia_riego }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->cantidad_agua }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->tipo_luz }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cuidado->frecuencia_abono ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('dashboard.cuidados.edit', $cuidado->id) }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('dashboard.cuidados.destroy', $cuidado->id) }}" method="POST" class="inline-block ml-2"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este cuidado?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-3">
                            <a href="{{ route('dashboard.cuidados.pdf', $cuidado->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                Ver PDF</a>
                            <a href="{{ route('dashboard.cuidados.qr', $cuidado->id) }}"
                               class="text-green-600 hover:text-green-900 cursor-pointer">
                                Ver QR
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">No hay cuidados registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($cuidados->count())
    <div class="mt-6 flex flex-col items-center text-center gap-2">
        {{-- Resumen --}}
        <div class="text-sm text-gray-600">
            Mostrando {{ $cuidados->firstItem() ?? 0 }} a {{ $cuidados->lastItem() ?? 0 }} de {{ $cuidados->total() }} resultados
        </div>

        {{-- Paginador personalizado --}}
        @if ($cuidados->hasPages())
            <div class="flex items-center space-x-1 text-sm text-gray-700">
                {{-- Página anterior --}}
                @if ($cuidados->onFirstPage())
                    <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 19l-7-7 7-7"/>
                        </svg>
                    </span>
                @else
                    <a href="{{ $cuidados->previousPageUrl() }}"
                       class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                @endif

                {{-- Números de página --}}
                @foreach ($cuidados->getUrlRange(1, $cuidados->lastPage()) as $page => $url)
                    @if ($page == $cuidados->currentPage())
                        <span class="px-3 py-2 rounded bg-green-600 text-white font-semibold">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-2 rounded hover:bg-green-100 text-green-700">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Página siguiente --}}
                @if ($cuidados->hasMorePages())
                    <a href="{{ $cuidados->nextPageUrl() }}"
                       class="px-3 py-2 rounded bg-eaccent2 hover:bg-green-700 text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <span class="px-3 py-2 rounded bg-gray-200 text-gray-500 cursor-not-allowed">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>
        @endif
    </div>
@else
    <div class="mt-6 text-center text-gray-500">
        No se encontraron cuidados con los filtros aplicados.
    </div>
@endif

</div>
@endsection
