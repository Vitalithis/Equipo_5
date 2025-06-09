@extends('layouts.dashboard')

@section('title', 'Resumen de Producción de Productos')

@section('content')
{{-- Tipografías --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="{{ route('produccion.create') }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Producción
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full text-sm text-left divide-y divide-eaccent2">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3">Producto</th>
                    <th class="px-6 py-3">Cantidad Producida</th>
                    <th class="px-6 py-3">Insumos Utilizados</th>
                    <th class="px-6 py-3">Costo Total</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 font-['Roboto']">
                @foreach ($producciones as $produccion)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 font-medium text-gray-900">
                            {{ $produccion->producto->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $produccion->cantidad_producida }}
                        </td>
                        <td class="px-6 py-4">
                            <ul class="list-disc pl-4 text-gray-700">
                                @foreach ($produccion->insumos as $insumo)
                                    <li>
                                        {{ $insumo->nombre }}:
                                        {{ $insumo->pivot->cantidad_usada }} unidades
                                        ( $
                                        {{
                                            number_format(
                                                $insumo->pivot->cantidad_usada * $insumo->costo,
                                                0, ',', '.'
                                            )
                                        }}
                                        )
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-6 py-4 text-green-700 font-semibold">
                            $
                            {{
                                number_format(
                                    $produccion->insumos->sum(function($insumo) {
                                        return $insumo->pivot->cantidad_usada * $insumo->costo;
                                    }),
                                    0, ',', '.'
                                )
                            }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap flex flex-wrap gap-2">
                            <a href="{{ route('produccion.edit', $produccion->id) }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">
                                Editar
                            </a>
                            <form action="{{ route('produccion.destroy', $produccion->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @if ($producciones->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                            No hay registros de producción disponibles.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
