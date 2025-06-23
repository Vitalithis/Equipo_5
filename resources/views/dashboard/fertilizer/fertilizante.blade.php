@extends('layouts.dashboard')

@section('title','Listado de fertilizantes')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp

<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }

    .custom-table-header {
        background-color: var(--table-header-color);
        color: var(--table-header-text-color) !important;
    }

    .custom-border {
        border: 2px solid var(--table-header-color);
        border-radius: 8px;
        overflow: hidden;
    }

    .custom-border thead th {
        border-bottom: 2px solid var(--table-header-color);
    }

    .custom-border tbody td {
        border-top: 1px solid #e5e7eb;
        border-left: none !important;
        border-right: none !important;
    }

    .custom-border tbody tr:last-child td {
        border-bottom: none;
    }
</style>

<div x-data="{ modalFert: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800 max-w-7xl mx-auto">
    <div class="flex items-center justify-end space-x-4 mb-6">
        <a href="{{ route('fertilizantes.create') }}"
           class="flex items-center text-white px-3 py-2 rounded transition-colors"
           style="background-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Fertilizante
        </a>

        <a href="{{ route('fertilizations.historial') }}"
           class="flex items-center text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-2 rounded transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M3 3h18M3 7h18M3 11h12M3 15h12M3 19h12"/>
            </svg>
            Ver Historial
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow custom-border">
        <table class="min-w-full text-sm text-left bg-white">
            <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Tipo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Stock</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>

            <tbody class="font-['Roboto'] text-gray-800">
                @foreach($fertilizantes as $fertilizante)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->tipo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap items-center gap-2">
                                <button @click="modalFert = {{ $fertilizante->id }}"
                                        class="text-green-600 hover:text-green-700 border border-green-600 hover:border-green-800 px-3 py-1.5 rounded text-sm transition-colors">
                                    Ver detalles
                                </button>

                                <a href="{{ route('fertilizantes.edit', $fertilizante->id) }}"
                                   class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1.5 rounded text-sm transition-colors inline-flex items-center gap-1"
                                   title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 20h9" />
                                        <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                    </svg>
                                    Editar
                                </a>

                                <form action="{{ route('fertilizantes.destroy', $fertilizante->id) }}" method="POST"
                                      class="inline-block" onsubmit="return confirm('¿Eliminar este fertilizante?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1.5 rounded text-sm transition-colors">
                                        Eliminar
                                    </button>
                                </form>

                                <a href="{{ route('fertilizations.create', ['fertilizante_id' => $fertilizante->id]) }}"
                                   class="text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-1.5 rounded text-sm transition-colors">
                                    Aplicar
                                </a>
                            </div>
                        </td>
                    </tr>

                    {{-- Modal de detalles --}}
                    <div x-cloak x-show="modalFert === {{ $fertilizante->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div @click.away="modalFert = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold">{{ $fertilizante->nombre }}</h2>
                                <button @click="modalFert = null" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-sm leading-relaxed">
                                <div><span class="font-semibold">Tipo:</span> {{ $fertilizante->tipo }}</div>
                                <div><span class="font-semibold">Peso:</span> {{ $fertilizante->peso }} {{ $fertilizante->unidad_medida }}</div>
                                <div><span class="font-semibold">Presentación:</span> {{ $fertilizante->presentacion }}</div>
                                <div><span class="font-semibold">Precio:</span> ${{ number_format($fertilizante->precio, 0, ',', '.') }}</div>
                                <div><span class="font-semibold">Fecha de vencimiento:</span> {{ $fertilizante->fecha_vencimiento ? \Carbon\Carbon::parse($fertilizante->fecha_vencimiento)->format('d/m/Y') : '-' }}</div>
                                <div><span class="font-semibold">Composición:</span><br><p class="whitespace-pre-line">{{ $fertilizante->composicion }}</p></div>
                                <div><span class="font-semibold">Descripción:</span><br><p class="whitespace-pre-line">{{ $fertilizante->descripcion }}</p></div>
                                <div><span class="font-semibold">Aplicación:</span><br><p class="whitespace-pre-line">{{ $fertilizante->aplicacion }}</p></div>
                                <div><span class="font-semibold">Activo:</span> {{ $fertilizante->activo ? 'Sí' : 'No' }}</div>
                            </div>
                            <div class="mt-6 text-right">
                                <button @click="modalFert = null" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
