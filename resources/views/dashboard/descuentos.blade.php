@extends('layouts.dashboard')
@section( 'title','Descuentos')
@section('content')
    {{-- Discount Management Form - Laravel Blade Template --}}
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.descuentos') }}" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            {{ isset($discount->id) ? 'Editar' : 'Nuevo' }} Descuento
        </h1>
    </div>

    <form action="{{ isset($discount->id) ? route('descuentos.update', $discount->id) : route('descuentos.store') }}"
          method="POST"
          class="space-y-6">
        @csrf
        @if(isset($discount->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre del Descuento --}}
                <div class="col-span-2">
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre del Descuento <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        value="{{ old('nombre', $discount->nombre ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        placeholder="Ej: Descuento de Verano"
                        required
                    >
                    @error('nombre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Porcentaje de Descuento --}}
                <div>
                    <label for="porcentaje" class="block text-sm font-medium text-gray-700 mb-1">
                        Porcentaje <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="number"
                            id="porcentaje"
                            name="porcentaje"
                            value="{{ old('porcentaje', $discount->porcentaje ?? '') }}"
                            min="0"
                            max="100"
                            class="w-full pl-3 pr-8 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                            required
                        >
                        <span class="absolute right-3 top-2 text-gray-500">%</span>
                    </div>
                    @error('porcentaje')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Código de Descuento --}}
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="codigo"
                        name="codigo"
                        value="{{ old('codigo', $discount->codigo ?? '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all uppercase"
                        placeholder="Ej: SUMMER2025"
                        required
                    >
                    @error('codigo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de Inicio --}}
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de Inicio <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="fecha_inicio"
                        name="fecha_inicio"
                        value="{{ old('fecha_inicio', isset($discount->fecha_inicio) ? date('Y-m-d\TH:i', strtotime($discount->fecha_inicio)) : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required
                    >
                    @error('fecha_inicio')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha de Fin --}}
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de Fin <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="datetime-local"
                        id="fecha_fin"
                        name="fecha_fin"
                        value="{{ old('fecha_fin', isset($discount->fecha_fin) ? date('Y-m-d\TH:i', strtotime($discount->fecha_fin)) : '') }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required
                    >
                    @error('fecha_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cantidad Máxima de Usos --}}
                <div>
                    <label for="max_usos" class="block text-sm font-medium text-gray-700 mb-1">
                        Usos Máximos
                    </label>
                    <input
                        type="number"
                        id="max_usos"
                        name="max_usos"
                        value="{{ old('max_usos', $discount->max_usos ?? '') }}"
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        placeholder="Dejar vacío para usos ilimitados"
                    >
                    @error('max_usos')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Activo --}}
                <div class="flex items-center">
                    <input
                        type="hidden"
                        name="activo"
                        value="0"
                    >
                    <input
                        type="checkbox"
                        id="activo"
                        name="activo"
                        value="1"
                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded transition-colors"
                        {{ old('activo', $discount->activo ?? '1') ? 'checked' : '' }}
                    >
                    <label for="activo" class="ml-2 block text-sm text-gray-700">
                        Descuento Activo
                    </label>
                    @error('activo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mt-6">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                </label>
                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Detalles adicionales sobre el descuento"
                >{{ old('descripcion', $discount->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones de acción --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.descuentos') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                {{ isset($discount->id) ? 'Actualizar' : 'Crear' }} Descuento
            </button>
        </div>
    </form>
</div>
"@endsection
