@extends('layouts.dashboard')

@section('title', 'Nueva Tarea')

@section('content')
<div class="max-w-2xl mx-auto font-['Roboto'] text-gray-800">
    <h2 class="text-2xl font-bold mb-6">Registrar nueva tarea</h2>

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
            <input type="text" name="responsable" class="w-full mt-1 px-4 py-2 border rounded shadow" required>
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

        <div class="flex justify-end">
            <a href="{{ route('works.index') }}" class="mr-4 text-gray-600 hover:underline">Cancelar</a>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar tarea
            </button>
        </div>
    </form>
</div>
@endsection
