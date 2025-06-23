@extends('layouts.dashboard')

@section('title', 'Editar Gasto de Transporte')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto font-['Roboto'] text-gray-800">

    <a href="{{ route('dashboard.transports.index') }}" class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15 18L9 12l6-6"/>
        </svg>
        Volver al listado
    </a>

    <h2 class="text-2xl font-semibold mb-4">Editar Gasto de Transporte</h2>

    <form action="{{ route('dashboard.transports.update', ['transport' => $gasto->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha" class="block text-sm font-medium mb-1">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $gasto->fecha) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="tipo_gasto" class="block text-sm font-medium mb-1">Tipo de Gasto</label>
                <select name="tipo_gasto" id="tipo_gasto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <option value="">Selecciona</option>
                    @foreach(['movilizacion','reparto','retiro','flete'] as $tipo)
                        <option value="{{ $tipo }}" {{ old('tipo_gasto', $gasto->tipo_gasto) == $tipo ? 'selected' : '' }}>
                            {{ ucfirst($tipo) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="transportista_nombre" class="block text-sm font-medium mb-1">Nombre del Transportista</label>
                <input type="text" name="transportista_nombre" id="transportista_nombre" value="{{ old('transportista_nombre', $gasto->transportista_nombre) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="transportista_contacto" class="block text-sm font-medium mb-1">Contacto</label>
                <input type="text" name="transportista_contacto" id="transportista_contacto" value="{{ old('transportista_contacto', $gasto->transportista_contacto) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="vehiculo_descripcion" class="block text-sm font-medium mb-1">Vehículo (opcional)</label>
                <input type="text" name="vehiculo_descripcion" id="vehiculo_descripcion" value="{{ old('vehiculo_descripcion', $gasto->vehiculo_descripcion) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div>
                <label for="monto" class="block text-sm font-medium mb-1">Monto</label>
                <input type="number" name="monto" id="monto" step="0.01" value="{{ old('monto', $gasto->monto) }}"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div class="md:col-span-2">
                <label for="detalle" class="block text-sm font-medium mb-1">Detalle</label>
                <textarea name="detalle" id="detalle" rows="3"
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                          placeholder="Descripción adicional...">{{ old('detalle', $gasto->detalle) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label for="comprobante_path" class="block text-sm font-medium mb-1">Actualizar Comprobante (opcional)</label>
                <input type="file" name="comprobante_path" id="comprobante_path"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="pagado" id="pagado" class="mr-2"
                       {{ old('pagado', $gasto->pagado) ? 'checked' : '' }}>
                <label for="pagado" class="text-sm font-medium">¿Pagado?</label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.transports.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Cancelar
            </a>
            <button type="submit" class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
