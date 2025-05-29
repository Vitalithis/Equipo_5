@extends('layouts.dashboard')

@section('title','Listado de insumos')

@section('content')
{{-- Tipografías --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800" x-data="{ abierto: null }">
    <div class="flex items-center mb-6">
        <a href="{{ route('insumos.create') }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Insumo
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Cantidad</th>
                    <th class="px-6 py-3 whitespace-nowrap">Costo Total</th>
                    <th class="px-6 py-3 whitespace-nowrap">Descripción</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @php $totalGeneral = 0; @endphp

                @forelse($insumos as $insumo)
                    @php
                        $costoTotal = $insumo->cantidad * $insumo->costo;
                        $totalGeneral += $costoTotal;
                    @endphp

                    <tr class="hover:bg-gray-100 cursor-pointer" @click="abierto === {{ $insumo->id }} ? abierto = null : abierto = {{ $insumo->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->cantidad }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            ${{ number_format($costoTotal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->descripcion }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <a href="{{ route('insumos.edit', $insumo->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                    <tr x-show="abierto === {{ $insumo->id }}" x-collapse>
                        <td colspan="5" class="bg-gray-50 px-6 py-4">
                            @if($insumo->detalles->count())
                                <p class="font-semibold mb-2 text-sm text-gray-700">Subdetalles del insumo:</p>
                                <table class="w-full text-sm text-left">
                                    <thead>
                                        <tr class="text-gray-600 border-b border-gray-300">
                                            <th class="py-2">Nombre</th>
                                            <th class="py-2">Cantidad</th>
                                            <th class="py-2">Costo unitario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($insumo->detalles as $detalle)
                                            <tr class="border-t">
                                                <td class="py-1">{{ $detalle->nombre }}</td>
                                                <td class="py-1">{{ $detalle->cantidad }}</td>
                                                <td class="py-1">${{ number_format($detalle->costo_unitario, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-500 italic text-sm">Este insumo no tiene subdetalles.</p>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                            No hay insumos registrados.
                        </td>
                    </tr>
                @endforelse

                {{-- Fila total --}}
                @if($insumos->count())
                    <tr class="bg-gray-100 font-semibold text-gray-800">
                        <td colspan="2" class="px-6 py-3 text-right">Total general:</td>
                        <td class="px-6 py-3">${{ number_format($totalGeneral, 0, ',', '.') }}</td>
                        <td colspan="2"></td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
