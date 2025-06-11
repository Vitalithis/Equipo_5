
@extends('layouts.dashboard')

@section('title','Listado de tratamientos')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div x-data="{ modalTrat: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center justify-end space-x-4 mb-6">
        <a href="{{ route('dashboard.treatments.create') }}"
           class="flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Tratamiento Plantas
        </a>

        <a href="{{ route('treatment_applications.index') }}"
           class="flex items-center text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-1 rounded transition-colors font-medium">
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
                @foreach($treatments as $treatment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $treatment->nombre }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $treatment->tipo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $treatment->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-y-1 space-x-2">
                            <button @click="modalTrat = {{ $treatment->id }}"
                                    class="text-green-600 hover:text-green-700 border border-green-600 hover:border-green-800 px-3 py-1 rounded transition-colors">
                                Ver detalles
                            </button>

                            <a href="{{ route('dashboard.treatments.edit', $treatment->id)  }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">Editar</a>

                            <form action="{{ route('dashboard.treatments.destroy', $treatment->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este tratamiento?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded transition-colors">Eliminar</button>
                            </form>

                            <a href="{{ route('treatment_applications.create', ['treatment_id' => $treatment->id]) }}"  
                               class="text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-1 rounded transition-colors">
                                Aplicar
                            </a>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div x-cloak x-show="modalTrat === {{ $treatment->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div @click.away="modalTrat = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold">{{ $treatment->nombre }}</h2>
                                <button @click="modalTrat = null" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-sm leading-relaxed">
                                @php
                                    $labels = [
                                        'nombre' => 'Nombre',
                                        'tipo' => 'Tipo',
                                        'peso' => 'Peso (Kg)',
                                        'unidad_medida' => 'Unidad de Medida',
                                        'presentacion' => 'Presentación',
                                        'precio' => 'Precio',
                                        'fecha_vencimiento' => 'Fecha de Vencimiento',
                                        'composicion' => 'Composición',
                                        'descripcion' => 'Descripción',
                                        'aplicacion' => 'Aplicación',
                                        'frecuencia_aplicacion' => 'Frecuencia de Aplicación',
                                        'fabricante' => 'Fabricante',
                                        'activo' => 'Activo',
                                    ];
                                @endphp

                                @foreach($labels as $campo => $etiqueta)
                                    @php $valor = $treatment->$campo; @endphp

                                    @if(!is_null($valor) && $valor !== '')
                                        <div>
                                            <span class="font-semibold">{{ $etiqueta }}:</span>
                                            @if($campo === 'precio')
                                                ${{ number_format($valor, 0, ',', '.') }}
                                            @elseif($campo === 'fecha_vencimiento')
                                                {{ \Carbon\Carbon::parse($valor)->format('d/m/Y') }}
                                            @elseif($campo === 'activo')
                                                {{ $valor ? 'Sí' : 'No' }}
                                            @else
                                                <p class="whitespace-pre-line">{{ $valor }}</p>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach

                                @if($treatment->proxima_aplicacion)
                                    <div>
                                        <span class="font-semibold">Próxima Aplicación:</span>
                                        {{ $treatment->proxima_aplicacion->format('d/m/Y') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-6 text-right">
                                <button @click="modalTrat = null" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
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
