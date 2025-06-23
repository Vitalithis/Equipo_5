@extends('layouts.dashboard')

@section('title', 'Registrar Gasto de Transporte')

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

<a href="{{ route('dashboard.transports.index') }}"
   class="mb-6 inline-flex items-center text-white border px-3 py-1 rounded transition-colors"
   style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 18L9 12l6-6"/>
    </svg>
    Volver a Transportes
</a>


    <h2 class="text-2xl font-semibold mb-4">Registrar Gasto de Transporte</h2>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('dashboard.transports.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf

        <div>
            <label for="fecha" class="block text-sm font-medium mb-1">Fecha</label>
            <input type="date" name="fecha" id="fecha" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="tipo_gasto" class="block text-sm font-medium mb-1">Tipo de Gasto</label>
            <select name="tipo_gasto" id="tipo_gasto" required class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
                <option value="">Selecciona</option>
                <option value="movilizacion">Movilización</option>
                <option value="reparto">Reparto</option>
                <option value="retiro">Retiro</option>
                <option value="flete">Flete</option>
            </select>
        </div>

        <div>
            <label for="transportista_nombre" class="block text-sm font-medium mb-1">Nombre del Transportista</label>
            <input type="text" name="transportista_nombre" id="transportista_nombre" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="transportista_contacto" class="block text-sm font-medium mb-1">Contacto del Transportista</label>
            <input type="text" name="transportista_contacto" id="transportista_contacto" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="vehiculo_descripcion" class="block text-sm font-medium mb-1">Vehículo (opcional)</label>
            <input type="text" name="vehiculo_descripcion" id="vehiculo_descripcion"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="monto" class="block text-sm font-medium mb-1">Monto</label>
            <input type="number" name="monto" id="monto" step="0.01" required
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div>
            <label for="detalle" class="block text-sm font-medium mb-1">Detalle</label>
            <textarea name="detalle" id="detalle" rows="3"
                      class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500"
                      placeholder="Descripción adicional..."></textarea>
        </div>

        <div>
            <label for="comprobante_path" class="block text-sm font-medium mb-1">Comprobante (opcional)</label>
            <input type="file" name="comprobante_path" id="comprobante_path"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex items-center">
            <input type="checkbox" name="pagado" id="pagado" class="mr-2">
            <label for="pagado" class="text-sm font-medium">¿Pagado?</label>
        </div>

        <div class="text-right">
        <button type="submit"
            class="text-white px-4 py-2 rounded border shadow transition-colors"
            style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
            Guardar Gasto
        </button>

        </div>
    </form>
</div>
@endsection
