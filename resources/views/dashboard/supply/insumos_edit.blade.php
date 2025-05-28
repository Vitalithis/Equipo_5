@extends('layouts.dashboard')

@section('title', isset($insumo->id) ? 'Editar insumo' : 'Nuevo insumo')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.insumos') }}"
           class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        
    </div>

    <form action="{{ isset($insumo->id) ? route('insumos.update', $insumo->id) : route('insumos.store') }}"
          method="POST" class="space-y-6">
        @csrf
        @if(isset($insumo->id))
            @method('PUT')
        @endif

        {{-- Información básica --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                Información del insumo
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nombre --}}
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $insumo->nombre ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                           required>
                    @error('nombre')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stock --}}
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="stock" name="stock" min="0"
                           value="{{ old('stock', $insumo->stock ?? 0) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                           required>
                    @error('stock')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Costo --}}
                <div>
                    <label for="costo" class="block text-sm font-medium text-gray-700 mb-1">
                        Costo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">$</span>
                        </div>
                        <input type="number" id="costo" name="costo" min="0" step="1"
                               value="{{ old('costo', $insumo->costo ?? 0) }}"
                               class="pl-7 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all"
                               required>
                    </div>
                    @error('costo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Descripción --}}
            <div class="mt-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                    Descripción
                </label>
                <textarea id="descripcion" name="descripcion" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 transition-all">{{ old('descripcion', $insumo->descripcion ?? '') }}</textarea>
                @error('descripcion')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.insumos') }}"
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm text-gray-700 bg-white hover:bg-gray-50 focus:ring-green-500">
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
                {{ isset($insumo->id) ? 'Actualizar' : 'Guardar' }} insumo
            </button>
        </div>
    </form>
</div>
@endsection
