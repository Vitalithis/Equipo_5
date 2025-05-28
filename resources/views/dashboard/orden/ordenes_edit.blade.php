@extends('layouts.dashboard')

@section('title', isset($orden) ? 'Editar orden de producción' : 'Nueva orden de producción')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.ordenes') }}"
           class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            {{ isset($orden) ? 'Editar' : 'Nueva' }} orden de producción
        </h1>
    </div>

    <form action="{{ isset($orden) ? route('ordenes.update', $orden->id) : route('ordenes.store') }}"
          method="POST" class="space-y-6">
        @csrf
        @if(isset($orden)) @method('PUT') @endif

        {{-- Sección: Información de la orden --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">
                Información básica
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Código --}}
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">
                        Código <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="codigo" name="codigo" required
                           value="{{ old('codigo', $orden->codigo ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('codigo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Producto --}}
                <div>
                    <label for="producto_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Producto <span class="text-red-500">*</span>
                    </label>
                    <select name="producto_id" id="producto_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}"
                                {{ old('producto_id', $orden->producto_id ?? '') == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('producto_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cantidad --}}
                <div>
                    <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-1">
                        Cantidad <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="cantidad" name="cantidad" required min="1"
                           value="{{ old('cantidad', $orden->cantidad ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('cantidad')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha inicio --}}
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de inicio <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" required
                           value="{{ old('fecha_inicio', isset($orden) ? $orden->fecha_inicio : now()->toDateString()) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('fecha_inicio')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Fecha fin --}}
                <div>
                    <label for="fecha_fin_estimada" class="block text-sm font-medium text-gray-700 mb-1">
                        Fecha estimada de fin
                    </label>
                    <input type="date" id="fecha_fin_estimada" name="fecha_fin_estimada"
                           value="{{ old('fecha_fin_estimada', $orden->fecha_fin_estimada ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                    @error('fecha_fin_estimada')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Estado --}}
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado <span class="text-red-500">*</span>
                    </label>
                    <select name="estado" id="estado" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        @php $estadoActual = old('estado', $orden->estado ?? 'pendiente'); @endphp
                        @foreach (['pendiente', 'en proceso', 'completada'] as $estado)
                            <option value="{{ $estado }}" {{ $estado === $estadoActual ? 'selected' : '' }}>
                                {{ ucfirst($estado) }}
                            </option>
                        @endforeach
                    </select>
                    @error('estado')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Trabajador --}}
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                        Trabajador asignado
                    </label>
                    <select name="user_id" id="user_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                        <option value="">Selecciona un trabajador</option>
                        @foreach ($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('user_id', $orden->user_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Observaciones --}}
            <div class="mt-6">
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">
                    Observaciones
                </label>
                <textarea name="observaciones" id="observaciones" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">{{ old('observaciones', $orden->observaciones ?? '') }}</textarea>
                @error('observaciones')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Botones --}}
        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.ordenes') }}"
               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                    class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block h-5 w-5 mr-2 -ml-1" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                    <polyline points="17 21 17 13 7 13 7 21"/>
                    <polyline points="7 3 7 8 15 8"/>
                </svg>
                {{ isset($orden) ? 'Actualizar' : 'Guardar' }} orden
            </button>
        </div>
    </form>
</div>
@endsection
