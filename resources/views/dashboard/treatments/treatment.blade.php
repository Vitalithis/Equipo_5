
    @extends('layouts.dashboard')

    @section('title','Listado de tratamientos')

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div x-data="{ modalTrat: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">

        {{-- Buscador como el del historial --}}
        <form method="GET" action="{{ route('dashboard.treatments') }}" class="flex flex-wrap gap-2 items-center w-full md:max-w-3xl mb-4">

            <input type="text" name="nombre" value="{{ request('nombre') }}" placeholder="Buscar por nombre..."
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

            @if(request('nombre') || request('tipo'))
                <a href="{{ route('dashboard.treatments') }}" class="text-sm text-gray-600 hover:text-gray-800 underline">
                    Limpiar
                </a>
            @endif
        </form>

        
            {{-- Botones a la derecha --}}
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard.treatments.create') }}"
                class="flex items-center text-white border px-3 py-1 rounded transition-colors whitespace-nowrap"
                style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar Tratamiento Plantas
                </a>


                <a href="{{ route('treatment_applications.index') }}"
                class="flex items-center whitespace-nowrap text-amber-600 hover:text-amber-700 border border-amber-600 hover:border-amber-700 px-3 py-1 rounded transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h18M3 7h18M3 11h12M3 15h12M3 19h12"/>
                    </svg>
                    Ver Historial
                </a>
            </div>

    </div>


        <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
            <table class="min-w-full table-auto text-sm text-left text-gray-800 bg-white">
                <thead class="custom-table-header uppercase tracking-wider font-['Roboto_Condensed']">
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
        @if($treatments instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-6 flex justify-center">
                {{ $treatments->withQueryString()->links('components.pagination.custom') }}
            </div>
        @endif

    </div>
    @endsection

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const nombreInput = document.getElementById('nombre');
        const tipoSelect = document.getElementById('tipo');
        const resultados = document.querySelector("tbody");

        function fetchData() {
            const nombre = encodeURIComponent(nombreInput.value);
            const tipo = encodeURIComponent(tipoSelect.value);

            fetch(`/plant-treatments/search?nombre=${nombre}&tipo=${tipo}`)
                .then(response => response.json())
                .then(data => {
                    resultados.innerHTML = "";

                    if (data.data.length === 0) {
                        resultados.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay tratamientos encontrados.</td></tr>`;
                        return;
                    }

                    data.data.forEach(treatment => {
                        resultados.innerHTML += `
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">${treatment.nombre}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${treatment.tipo}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${treatment.stock}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="/dashboard/treatments/${treatment.id}/edit"
                                    class="text-blue-600 hover:text-blue-800 border border-blue-600 hover:border-blue-800 px-3 py-1 rounded transition-colors">Editar</a>
                                </td>
                            </tr>
                        `;
                    });
                });
        }

        nombreInput.addEventListener('input', fetchData);
        tipoSelect.addEventListener('change', fetchData);
    });
    </script>
