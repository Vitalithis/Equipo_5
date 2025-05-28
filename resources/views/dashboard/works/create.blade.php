@extends('layouts.dashboard')

@section('title', 'Nueva Tarea')

@section('content')
<div class="max-w-2xl mx-auto font-['Roboto'] text-gray-800">

    <div class="flex items-center mb-6">
        <a href="{{ route('works.index') }}"
           class="inline-flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
    </div>

    <form method="POST" action="{{ route('works.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Nombre de la tarea</label>
            <input type="text" name="nombre" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Ubicación</label>
            <select name="ubicacion" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="produccion">Producción</option>
                <option value="venta">Local de Venta</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Responsable</label>
            <select name="responsable" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="" disabled selected>Seleccionar responsable</option>
                @foreach($responsables as $usuario)
                    <option value="{{ $usuario->name }}">{{ $usuario->name }} </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Fecha</label>
            <input type="date" name="fecha" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
        </div>

        <div>
            <label class="block font-medium">Estado</label>
            <select name="estado" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
                <option value="pendiente">Pendiente</option>
                <option value="en progreso">En progreso</option>
                <option value="completada">Completada</option>
            </select>
        </div>

        <div class="flex justify-end items-center space-x-4">
            <a href="{{ route('works.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
            <button type="submit" class="bg-eaccent2 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar tarea
            </button>
        </div>

    </form>
</div>
@endsection
