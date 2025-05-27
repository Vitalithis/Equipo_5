@extends('layouts.dashboard')

@section('title', isset($fertilizante->id) ? 'Editar fertilizante' : 'Nuevo fertilizante')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.fertilizantes') }}" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            {{ isset($fertilizante->id) ? 'Editar' : 'Nuevo' }} fertilizante
        </h1>
    </div>

    <form action="{{ isset($fertilizante->id) ? route('fertilizantes.update', $fertilizante->id) : route('fertilizantes.store') }}"
          method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($fertilizante->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del fertilizante</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $fertilizante->nombre ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                {{-- Tipo --}}
                <div>
                    <label for="tipo" class="block text-sm font-medium text-gray-700 mb-1">Tipo <span class="text-red-500">*</span></label>
                    <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $fertilizante->tipo ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                {{-- Peso --}}
                <div>
                    <label for="peso" class="block text-sm font-medium text-gray-700 mb-1">Peso (kg) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="peso" id="peso" value="{{ old('peso', $fertilizante->peso ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                {{-- Unidad de Medida --}}
                <div>
                    <label for="unidad_medida" class="block text-sm font-medium text-gray-700 mb-1">Unidad de Medida</label>
                    <input type="text" name="unidad_medida" id="unidad_medida" value="{{ old('unidad_medida', $fertilizante->unidad_medida ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>

                {{-- Presentación --}}
                <div>
                    <label for="presentacion" class="block text-sm font-medium text-gray-700 mb-1">Presentación</label>
                    <input type="text" name="presentacion" id="presentacion" value="{{ old('presentacion', $fertilizante->presentacion ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>

                {{-- Precio --}}
                <div>
                    <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">Precio <span class="text-red-500">*</span></label>
                    <input type="number" name="precio" id="precio" value="{{ old('precio', $fertilizante->precio ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock <span class="text-red-500">*</span></label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $fertilizante->stock ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all" required>
                </div>

                {{-- Fecha de Vencimiento --}}
                <div>
                    <label for="fecha_vencimiento" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="{{ old('fecha_vencimiento', $fertilizante->fecha_vencimiento ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            {{-- Composición --}}
            <div class="mt-4">
                <label for="composicion" class="block text-sm font-medium text-gray-700 mb-1">Composición</label>
                <textarea name="composicion" id="composicion" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('composicion', $fertilizante->composicion ?? '') }}</textarea>
            </div>

            {{-- Descripción --}}
            <div class="mt-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('descripcion', $fertilizante->descripcion ?? '') }}</textarea>
            </div>

            {{-- Aplicación --}}
            <div class="mt-4">
                <label for="aplicacion" class="block text-sm font-medium text-gray-700 mb-1">Aplicación</label>
                <textarea name="aplicacion" id="aplicacion" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ old('aplicacion', $fertilizante->aplicacion ?? '') }}</textarea>
            </div>

            {{-- Activo --}}
            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1"
                           class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                           {{ old('activo', $fertilizante->activo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Fertilizante activo</span>
                </label>
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.fertilizantes') }}"
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
               Cancelar
            </a>
            <button type="submit"
                class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                {{ isset($fertilizante->id) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@endsection
