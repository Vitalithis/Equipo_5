@extends('layouts.dashboard')

@section('title', isset($treatment->id) ? 'Editar Tratamiento' : 'Nuevo Tratamiento')

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
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.treatments') }}"
        class="mb-6 inline-flex items-center text-white border px-3 py-1 rounded transition-colors"
        style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a la lista
        </a>
    </div>

    <form action="{{ isset($treatment->id) ? route('dashboard.treatments.update', $treatment->id) : route('dashboard.treatments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($treatment->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del Tratamiento</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $treatment->nombre ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>
            <!--Seleccion de tipo !-->
            <div x-data="{ tipo: '{{ old('tipo', $treatment->tipo ?? '') }}' }">
                <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-red-500">*</span></label>
                <select x-model="tipo" name="tipo" id="tipo" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    <option value="">Seleccione tipo</option>
                    <option value="Fertilizante">Fertilizante</option>
                    <option value="Insecticida">Insecticida</option>
                    <option value="Fungicida">Fungicida</option>
                    <option value="Herbicida">Herbicida</option>
                    <option value="Regulador de crecimiento">Regulador de crecimiento</option>
                    <option value="Otro">Otro</option>
                </select>

                <div x-show="tipo === 'Otro'" class="mt-3">
                    <label for="tipo_otro" class="block text-sm font-medium text-gray-700">Especificar otro tipo</label>
                    <input type="text" name="tipo_otro" id="tipo_otro"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        placeholder="Ej: Bioestimulante" value="{{ old('tipo_otro') }}">
                </div>
            </div>

                <div>
                    <label for="peso" class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="peso" id="peso" value="{{ old('peso', $treatment->peso ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                <div>
                    <label for="presentacion" class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                    <input type="text" name="presentacion" id="presentacion" value="{{ old('presentacion', $treatment->presentacion ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>

                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio <span class="text-red-500">*</span></label>
                    <input type="number" name="precio" id="precio" value="{{ old('precio', $treatment->precio ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $treatment->stock ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                <div>
                    <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento', $treatment->fecha_vencimiento ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="frecuencia_aplicacion" class="block text-sm font-medium text-gray-700 mb-1">Frecuencia de Aplicación</label>
                    <select name="frecuencia_aplicacion" id="frecuencia_aplicacion"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition">
                        <option value="">Seleccionar</option>
                        @php
                            $frecuencias = [
                                'diaria',
                                'cada 2 días',
                                'semanal',
                                'cada 10 días',
                                'quincenal',
                                'cada 20 días',
                                'mensual',
                                'bimestral',
                                'cada 3 meses',
                                '2 veces al año',
                                'una vez al año',
                            ];
                        @endphp
                        @foreach($frecuencias as $freq)
                            <option value="{{ $freq }}" {{ old('frecuencia_aplicacion', $treatment->frecuencia_aplicacion ?? '') === $freq ? 'selected' : '' }}>
                                {{ ucfirst($freq) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label for="composicion" class="block text-sm font-medium text-gray-700 mb-1">Composición</label>
                <textarea name="composicion" id="composicion" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('composicion', $treatment->composicion ?? '') }}</textarea>
            </div>

            <div class="mt-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('descripcion', $treatment->descripcion ?? '') }}</textarea>
            </div>

            


            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500" {{ old('activo', $treatment->activo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Tratamiento activo</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.treatments') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">Cancelar</a>
        <button type="submit"
            class="text-white px-4 py-2 rounded transition-colors"
            style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
            {{ isset($treatment->id) ? 'Actualizar' : 'Guardar' }}
        </button>

        </div>
    </form>
</div>
@endsection
