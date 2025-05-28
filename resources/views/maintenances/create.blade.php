@extends('layouts.dashboard')

@section('title', 'Nuevo Reporte de Mantención')

@section('content')
<div class="max-w-4xl mx-auto py-6 font-['Roboto'] text-gray-800">
    <h1 class="text-xl font-bold mb-6 font-['Roboto_Condensed']">Nuevo Reporte de Mantención</h1>

    <form method="POST" action="{{ route('maintenance.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <x-input-label for="title" value="Título" />
        <x-text-input id="title" name="title" class="w-full" required />

        <x-input-label for="description" value="Descripción" />
        <textarea name="description" id="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>

        <x-input-label for="status" value="Estado" />
        <select name="status" id="status" class="w-full border rounded p-2">
            <option value="pendiente">Pendiente</option>
            <option value="en progreso">En progreso</option>
            <option value="finalizado">Finalizado</option>
        </select>

        <x-input-label for="cost" value="Costo" />
        <x-text-input id="cost" name="cost" type="number" step="0.01" class="w-full" />

        <x-input-label for="image" value="Imagen (opcional)" />
        <input type="file" name="image" id="image" class="w-full border rounded p-2" accept="image/*" />

        <div class="mt-4">
            <x-primary-button class="bg-green-600 hover:bg-green-700">Guardar</x-primary-button>
            <a href="{{ route('maintenance.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
