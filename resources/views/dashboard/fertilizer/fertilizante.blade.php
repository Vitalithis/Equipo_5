@extends('layouts.dashboard')

@section('title','Listado de fertilizantes')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div x-data="{ modalFert: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center justify-end space-x-4 mb-6">
    <a href="{{ route('fertilizantes.create') }}"
       class="flex items-center text-green-700 hover:text-green-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 4v16m8-8H4"/>
        </svg>
        Agregar Fertilizante
    </a>

    <a href="{{ route('fertilizations.historial') }}"
       class="flex items-center text-amber-600 hover:text-amber-700 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 3h18M3 7h18M3 11h12M3 15h12M3 19h12"/>
        </svg>
        Ver Historial
    </a>
</div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Tipo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Stock</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @foreach($fertilizantes as $fertilizante)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->tipo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $fertilizante->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-y-1 space-x-2">
    <button @click="modalFert = {{ $fertilizante->id }}"
            class="text-green-600 hover:text-green-800 transition font-medium">
        Ver detalles
    </button>

    <a href="{{ route('fertilizantes.edit', $fertilizante->id) }}"
       class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</a>

    <form action="{{ route('fertilizantes.destroy', $fertilizante->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este fertilizante?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition">Eliminar</button>
    </form>

    {{-- Botón para aplicar fertilizante --}}
    <a href="{{ route('fertilizations.create', ['fertilizante_id' => $fertilizante->id]) }}"
       class="text-amber-600 hover:text-amber-700 font-medium transition block">
        Aplicar
    </a>
</td>

                    </tr>

                    <!-- Modal -->
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
