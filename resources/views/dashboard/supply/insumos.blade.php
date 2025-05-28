@extends('layouts.dashboard')

@section('title','Listado de insumos')

@section('content')
    {{-- Tipografías --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
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
            <th class="px-6 py-3 whitespace-nowrap">Costo</th>
            <th class="px-6 py-3 whitespace-nowrap">Descripción</th>
            <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
    @forelse($insumos as $insumo)
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->nombre }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->cantidad }}</td>
            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($insumo->costo, 0, ',', '.') }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ $insumo->descripcion }}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <a href="{{ route('insumos.edit', $insumo->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                <form action="{{ route('insumos.destroy', $insumo->id) }}" method="POST" class="inline-block ml-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" class="px-6 py-6 text-center text-gray-500 italic">
                No hay insumos registrados.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

        </div>
    </div>
@endsection
