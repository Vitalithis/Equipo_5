@extends('layouts.dashboard')

@section('title', 'Registrar Aplicación de Tratamiento')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp
<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }
</style>
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto font-['Roboto'] text-gray-800">
    <a href="{{ route('dashboard.treatments') }}" class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Volver a Tratamientos
    </a>

    <h2 class="text-2xl font-semibold mb-4">Registrar Aplicación de Tratamiento</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($latestApplications->count())
    <div class="mb-6 p-4 border border-gray-200 rounded bg-gray-50 text-sm text-gray-700">
        <p class="mb-2 font-semibold text-green-700">Últimas aplicaciones registradas:</p>
        <ul class="list-disc list-inside">
            @foreach($latestApplications as $a)
                <li>
                    {{ \Carbon\Carbon::parse($a->fecha_aplicacion)->format('d/m/Y') }}:
                    {{ $a->producto->nombre }} con {{ $a->treatment->nombre }} ({{ $a->dosis_aplicada ?? 'sin dosis' }})
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <form x-data="aplicacionForm()" x-init="init()" action="{{ route('treatment_applications.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="producto_id" class="block text-sm font-medium mb-1">Producto</label>
            <select name="producto_id" id="producto_id" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                <option value="">Selecciona un producto</option>
                @foreach($productos as $producto)
                    <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="fecha_aplicacion" class="block text-sm font-medium mb-1">Fecha de Aplicación</label>
            <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

                <div>
            <label for="plant_treatment_id" class="block text-sm font-medium mb-1">Tratamiento</label>
            <select name="plant_treatment_id" id="plant_treatment_id" required
                    @change="actualizarFrecuencia()"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                <option value="">Selecciona un tratamiento</option>
                @foreach($treatments as $tratamiento)
                    <option 
                        value="{{ $tratamiento->id }}" 
                        data-frecuencia="{{ $tratamiento->frecuencia_aplicacion }}" 
                        {{ old('plant_treatment_id', $selected_treatment_id ?? '') == $tratamiento->id ? 'selected' : '' }}>
                        {{ $tratamiento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="proxima_aplicacion" class="block text-sm font-medium mb-1">Próxima Aplicación</label>
            <input type="date" name="proxima_aplicacion" id="proxima_aplicacion"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>
         
        <div>
            <label for="dosis_aplicada" class="block text-sm font-medium mb-1">Dosis Aplicada</label>
            <input type="text" name="dosis_aplicada" id="dosis_aplicada"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                   placeholder="Ej. 5 ml/litro">
        </div>


        <div>
            <label for="notas" class="block text-sm font-medium mb-1">Notas</label>
            <textarea name="notas" id="notas" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                      placeholder="Observaciones, condiciones climáticas, etc."></textarea>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Registrar Aplicación
            </button>
        </div>
    </form>
</div>
@endsection

<script>
function aplicacionForm() {
    return {
        frecuenciaDias: 0,

        init() {
            this.actualizarFrecuencia();
            this.calcularProximaAplicacion();
        },

        actualizarFrecuencia() {
            const select = document.getElementById('plant_treatment_id');
            const option = select.options[select.selectedIndex];
            const frecuencia = option.getAttribute('data-frecuencia') ?? '';

            switch (frecuencia.toLowerCase()) {
                case 'diaria': this.frecuenciaDias = 1; break;
                case 'cada 2 días': this.frecuenciaDias = 2; break;
                case 'semanal': this.frecuenciaDias = 7; break;
                case 'cada 10 días': this.frecuenciaDias = 10; break;
                case 'quincenal': this.frecuenciaDias = 15; break;
                case 'cada 20 días': this.frecuenciaDias = 20; break;
                case 'mensual': this.frecuenciaDias = 30; break;
                case 'bimestral': this.frecuenciaDias = 60; break;
                case 'cada 3 meses': this.frecuenciaDias = 90; break;
                case '2 veces al año': this.frecuenciaDias = 180; break;
                case 'una vez al año': this.frecuenciaDias = 365; break;
                default: this.frecuenciaDias = 0;
            }

            this.calcularProximaAplicacion();
        },

        calcularProximaAplicacion() {
            const fechaAplicacion = document.getElementById('fecha_aplicacion').value;
            if (!fechaAplicacion || this.frecuenciaDias === 0) return;

            const fecha = new Date(fechaAplicacion);
            fecha.setDate(fecha.getDate() + this.frecuenciaDias);
            const resultado = fecha.toISOString().split('T')[0];
            document.getElementById('proxima_aplicacion').value = resultado;
        }
    }
}
</script>
