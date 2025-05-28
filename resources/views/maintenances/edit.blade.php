@extends('layouts.dashboard')

@section('title', 'Editar Reporte de Mantención')

@section('content')
<div class="max-w-4xl mx-auto py-6 font-['Roboto'] text-gray-800">
    <h1 class="text-xl font-bold mb-6 font-['Roboto_Condensed']">Editar Reporte</h1>

    <form method="POST" action="{{ route('maintenance.update', $maintenance->id) }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <x-input-label for="title" value="Título" />
        <x-text-input id="title" name="title" value="{{ old('title', $maintenance->title) }}" class="w-full" required />

        <x-input-label for="description" value="Descripción" />
        <textarea name="description" id="description" rows="4" class="w-full border rounded p-2">{{ old('description', $maintenance->description) }}</textarea>

        <x-input-label for="status" value="Estado" />
        <select name="status" id="status" class="w-full border rounded p-2">
            @foreach(['pendiente', 'en progreso', 'finalizado'] as $estado)
                <option value="{{ $estado }}" @selected($maintenance->status === $estado)>{{ ucfirst($estado) }}</option>
            @endforeach
        </select>

        <x-input-label for="cost" value="Costo" />
        <x-text-input id="cost" name="cost" type="number" step="0.01" value="{{ old('cost', $maintenance->cost) }}" class="w-full" />

        <x-input-label for="image" value="Reemplazar Imagen (opcional)" />
        <input type="file" name="image" id="image" class="w-full border rounded p-2" accept="image/*" />

        @if($maintenance->image)
            <div class="mt-2">
                <p class="text-sm text-gray-600">Imagen actual:</p>
                <img src="{{ asset($maintenance->image) }}" alt="Imagen actual" class="w-32 h-auto mt-1 rounded shadow">
            </div>
        @endif

        <div class="mt-4">
            <x-primary-button class="bg-blue-600 hover:bg-blue-700">Actualizar</x-primary-button>
            <a href="{{ route('maintenance.index') }}" class="ml-3 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
