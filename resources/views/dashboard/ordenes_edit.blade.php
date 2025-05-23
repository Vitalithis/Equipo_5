@extends('layouts.dashboard')

@section('title', isset($orden) ? 'Editar Orden de Producción' : 'Nueva Orden de Producción')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('dashboard.ordenes') }}" class="text-green-700 hover:text-green-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver al listado
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            {{ isset($orden) ? 'Editar' : 'Nueva' }} Orden de Producción
        </h1>
    </div>

    <form method="POST"
          action="{{ isset($orden) ? route('ordenes.update', $orden->id) : route('ordenes.store') }}"
          class="bg-white p-6 rounded-lg shadow space-y-6">
        @csrf
        @if(isset($orden)) @method('PUT') @endif

        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <input type="text" name="codigo" id="codigo" required
                   class="form-input mt-1 w-full"
                   value="{{ old('codigo', $orden->codigo ?? '') }}">
        </div>

        <div>
            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
            <select name="producto_id" id="producto_id" required class="form-select mt-1 w-full">
                <option value="">Selecciona un producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id }}"
                        {{ old('producto_id', $orden->producto_id ?? '') == $producto->id ? 'selected' : '' }}>
                        {{ $producto->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" required min="1"
                   class="form-input mt-1 w-full"
                   value="{{ old('cantidad', $orden->cantidad ?? '') }}">
        </div>

        <div>
            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" required
                   class="form-input mt-1 w-full"
                   value="{{ old('fecha_inicio', isset($orden) ? $orden->fecha_inicio : now()->toDateString()) }}">
        </div>

        <div>
            <label for="fecha_fin_estimada" class="block text-sm font-medium text-gray-700">Fecha Estimada de Fin</label>
            <input type="date" name="fecha_fin_estimada" id="fecha_fin_estimada"
                   class="form-input mt-1 w-full"
                   value="{{ old('fecha_fin_estimada', $orden->fecha_fin_estimada ?? '') }}">
        </div>

        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" id="estado" class="form-select mt-1 w-full" required>
                @php
                    $estadoActual = old('estado', $orden->estado ?? 'pendiente');
                @endphp
                @foreach (['pendiente', 'en proceso', 'completada'] as $estado)
                    <option value="{{ $estado }}" {{ $estado === $estadoActual ? 'selected' : '' }}>
                        {{ ucfirst($estado) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="observaciones" class="block text-sm font-medium text-gray-700">Observaciones</label>
            <textarea name="observaciones" id="observaciones" rows="3"
                      class="form-textarea mt-1 w-full">{{ old('observaciones', $orden->observaciones ?? '') }}</textarea>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ route('dashboard.ordenes') }}"
               class="px-4 py-2 border border-gray-300 rounded bg-white text-gray-700 hover:bg-gray-50">
               Cancelar
            </a>
            <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                {{ isset($orden) ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>
</div>
@endsection
