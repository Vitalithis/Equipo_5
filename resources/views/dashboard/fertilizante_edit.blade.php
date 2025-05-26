@extends('layouts.dashboard')

@section('title', 'Editar fertilizante')

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

    <form action="{{ isset($fertilizante->id) ? route('fertilizantes.update', $fertilizante->id) : route('fertilizantes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($fertilizante->id))
            @method('PUT')
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Datos del fertilizante</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-input w-full" value="{{ old('nombre', $fertilizante->nombre ?? '') }}" required>
                </div>

                <div>
                    <label for="tipo">Tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-input w-full" value="{{ old('tipo', $fertilizante->tipo ?? '') }}" required>
                </div>

                <div>
                    <label for="peso">Peso</label>
                    <input type="number" step="0.01" name="peso" id="peso" class="form-input w-full" value="{{ old('peso', $fertilizante->peso ?? '') }}" required>
                </div>

                <div>
                    <label for="unidad_medida">Unidad de Medida</label>
                    <input type="text" name="unidad_medida" id="unidad_medida" class="form-input w-full" value="{{ old('unidad_medida', $fertilizante->unidad_medida ?? '') }}" required>
                </div>

                <div>
                    <label for="presentacion">Presentación</label>
                    <input type="text" name="presentacion" id="presentacion" class="form-input w-full" value="{{ old('presentacion', $fertilizante->presentacion ?? '') }}" required>
                </div>

                <div>
                    <label for="precio">Precio</label>
                    <input type="number" name="precio" id="precio" class="form-input w-full" value="{{ old('precio', $fertilizante->precio ?? '') }}" required>
                </div>

                <div>
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" id="stock" class="form-input w-full" value="{{ old('stock', $fertilizante->stock ?? '') }}" required>
                </div>

                <div>
                    <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-input w-full" value="{{ old('fecha_vencimiento', $fertilizante->fecha_vencimiento ?? '') }}">
                </div>
            </div>

            <div>
                <label for="composicion">Composición</label>
                <textarea name="composicion" id="composicion" class="form-textarea w-full" rows="2">{{ old('composicion', $fertilizante->composicion ?? '') }}</textarea>
            </div>

            <div>
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-textarea w-full" rows="3">{{ old('descripcion', $fertilizante->descripcion ?? '') }}</textarea>
            </div>

            <div>
                <label for="aplicacion">Aplicación</label>
                <textarea name="aplicacion" id="aplicacion" class="form-textarea w-full" rows="3">{{ old('aplicacion', $fertilizante->aplicacion ?? '') }}</textarea>
            </div>

            <div class="mt-4">
                <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
                <input type="file" name="imagen" id="imagen" class="block w-full text-sm text-gray-500">
                @if(isset($fertilizante->imagen))
                    <img src="{{ asset('storage/' . $fertilizante->imagen) }}" alt="Imagen actual" class="mt-2 w-32 h-32 object-cover rounded">
                @endif
                @error('imagen')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="activo" value="1" class="form-checkbox text-green-600" {{ old('activo', $fertilizante->activo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700">Activo</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('dashboard.fertilizantes') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md shadow hover:bg-green-700">
                {{ isset($fertilizante->id) ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </form>
</div>
@endsection