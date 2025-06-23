@extends('layouts.dashboard')

@section('title','Historial de Aplicaciones de Tratamientos')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp
<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }
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
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('dashboard.treatments') }}"
        class="mb-6 inline-flex items-center text-white border px-3 py-1 rounded transition-colors"
        style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a Tratamientos
        </a>

    </div>

    <form method="GET" action="{{ route('treatment_applications.index') }}" class="flex flex-wrap gap-2 items-center w-full md:max-w-3xl mb-4">
    
        <input type="text" name="tratamiento" value="{{ request('tratamiento') }}" placeholder="Buscar por tratamiento..."
            class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

        <select name="tipo" class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto">
            <option value="">Todos los tipos</option>
            <option value="Fertilizante" {{ request('tipo') === 'Fertilizante' ? 'selected' : '' }}>Fertilizante</option>
            <option value="Fungicida" {{ request('tipo') === 'Fungicida' ? 'selected' : '' }}>Fungicida</option>
            <option value="Insecticida" {{ request('tipo') === 'Insecticida' ? 'selected' : '' }}>Insecticida</option>
            <option value="Herbicida" {{ request('tipo') === 'Herbicida' ? 'selected' : '' }}>Herbicida</option>
            <option value="Acaricida" {{ request('tipo') === 'Acaricida' ? 'selected' : '' }}>Acaricida</option>
            <option value="Otro" {{ request('tipo') === 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>

<button type="submit"
    class="text-white px-4 py-2 rounded border shadow transition-colors"
    style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
    Buscar
</button>


        @if(request('tratamiento') || request('tipo'))
            <a href="{{ route('treatment_applications.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">
                Limpiar
            </a>
        @endif
    </form>


    @if($applications->count())
        <div class="overflow-x-auto bg-white shadow sm:rounded-lg border border-eaccent2">
            <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-3 whitespace-nowrap">Tratamiento</th>
                        <th class="px-6 py-3 whitespace-nowrap">Tipo Tratamiento</th>
                        <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                        <th class="px-6 py-3 whitespace-nowrap">Fecha</th>
                        <th class="px-6 py-3 whitespace-nowrap">Dosis</th>
                        <th class="px-6 py-3 whitespace-nowrap">Próxima Aplicación</th>
                        <th class="px-6 py-3 whitespace-nowrap">Notas</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                    @foreach($applications as $app)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $app->tratamiento->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $app->treatment->tipo }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $app->producto->nombre }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($app->fecha_aplicacion)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $app->dosis_aplicada }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $app->proxima_aplicacion ? \Carbon\Carbon::parse($app->proxima_aplicacion)->format('d/m/Y') : 'No especificada' }}
                            </td>
                            <td class="px-6 py-4 whitespace-pre-line">{{ $app->notas }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 italic">No hay aplicaciones registradas todavía.</p>
    @endif
</div>
@endsection
