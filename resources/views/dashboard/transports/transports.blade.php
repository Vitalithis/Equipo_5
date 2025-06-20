@extends('layouts.dashboard')

@section('title','Listado de Gastos en Transporte')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">
<div x-data="{ modalGasto: null }" class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">

    {{-- Buscador --}}
    <form method="GET" action="{{ route('dashboard.transports.index') }}" class="flex flex-wrap gap-2 items-center w-full md:max-w-3xl">
        <input type="text" name="transportista" value="{{ request('transportista') }}" placeholder="Buscar transportista..."
               class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto" />

        <select name="tipo_gasto" class="px-4 py-2 border rounded shadow text-sm w-full md:w-auto">
            <option value="">Todos los tipos</option>
            <option value="movilizacion" {{ request('tipo_gasto') === 'movilizacion' ? 'selected' : '' }}>Movilización</option>
            <option value="reparto" {{ request('tipo_gasto') === 'reparto' ? 'selected' : '' }}>Reparto</option>
            <option value="retiro" {{ request('tipo_gasto') === 'retiro' ? 'selected' : '' }}>Retiro</option>
            <option value="flete" {{ request('tipo_gasto') === 'flete' ? 'selected' : '' }}>Flete</option>
        </select>

        <button type="submit" class="bg-eaccent2 text-white px-3 py-2 rounded hover:bg-green-700 text-sm">
            Buscar
        </button>

        @if(request('transportista') || request('tipo_gasto'))
            <a href="{{ route('dashboard.transports.index') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">
                Limpiar
            </a>
        @endif
    </form>

    {{-- Botón Agregar alineado a la derecha --}}
    <a href="{{ route('dashboard.transports.create') }}"
       class="flex items-center whitespace-nowrap text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-2 rounded transition-colors font-medium">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 4v16m8-8H4"/>
        </svg>
        Agregar Transporte
    </a>

</div>

<div x-data="{ modalGasto: null }" class="overflow-x-auto rounded-xl border border-eaccent2">


        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3">Fecha</th>
                    <th class="px-6 py-3">Tipo de Gasto</th>
                    <th class="px-6 py-3">Transportista</th>
                    <th class="px-6 py-3">Monto</th>
                    <th class="px-6 py-3">Pagado</th>
                    <th class="px-6 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @forelse($gastos as $gasto)
                    <tr>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ ucfirst($gasto->tipo_gasto) }}</td>
                        <td class="px-6 py-4">{{ $gasto->transportista_nombre }}</td>
                        <td class="px-6 py-4">${{ number_format($gasto->monto, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">{{ $gasto->pagado ? 'Sí' : 'No' }}</td>
                        <td class="px-6 py-4 space-x-2">

                            <button @click="modalGasto = {{ $gasto->id }}"
                                class="text-green-600 hover:text-green-700 border border-green-600 hover:border-green-800 px-3 py-1 rounded transition-colors">
                                Ver detalles
                            </button>

                            <a href="{{ route('dashboard.transports.edit', $gasto->id) }}"
                               class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded">Editar</a>

                            <form action="{{ route('dashboard.transports.destroy', $gasto->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este transporte?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 border border-red-600 hover:border-red-800 px-3 py-1 rounded">Eliminar</button>
                            </form>

                           @if($gasto->comprobante_path)
                                <a href="{{ asset('storage/' . $gasto->comprobante_path) }}" target="_blank"
                                class="text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-1 rounded transition-colors">
                                    Ver Comprobante
                                </a>
                            @endif
                        </td>
                    </tr>

                    <div x-cloak x-show="modalGasto === {{ $gasto->id }}" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                    <div @click.away="modalGasto = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold">Detalle Transporte</h2>
                            <button @click="modalGasto = null" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="space-y-3 text-sm leading-relaxed">
                            <div><span class="font-semibold">Fecha:</span> {{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</div>
                            <div><span class="font-semibold">Tipo de Gasto:</span> {{ ucfirst($gasto->tipo_gasto) }}</div>
                            <div><span class="font-semibold">Transportista:</span> {{ $gasto->transportista_nombre }}</div>
                            <div><span class="font-semibold">Contacto:</span> {{ $gasto->transportista_contacto }}</div>
                            <div><span class="font-semibold">Vehículo:</span> {{ $gasto->vehiculo_descripcion ?? 'N/A' }}</div>
                            <div><span class="font-semibold">Monto:</span> ${{ number_format($gasto->monto, 0, ',', '.') }}</div>
                            <div><span class="font-semibold">Detalle:</span> {{ $gasto->detalle }}</div>
                            <div><span class="font-semibold">Pagado:</span> {{ $gasto->pagado ? 'Sí' : 'No' }}</div>

                            @if($gasto->comprobante_path)
                                <div>
                                    <span class="font-semibold">Comprobante:</span>
                                    <a href="{{ asset('storage/'.$gasto->comprobante_path) }}" target="_blank" class="text-blue-600 underline">Ver comprobante</a>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 text-right">
                            <button @click="modalGasto = null" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                Cerrar
                            </button>
                        </div>
                    </div>
                </div>



                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay registros de transporte.</td>
                    </tr>

                    
                @endforelse
            </tbody>
        </table>
    </div>

    @if($gastos instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-6 flex justify-center">
        {{ $gastos->withQueryString()->links('components.pagination.custom') }}
    </div>
@endif


</div>
@endsection
