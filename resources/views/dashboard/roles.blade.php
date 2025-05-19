@extends('layouts.dashboard')
@section('title', 'Roles y Permisos')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Listado de Roles</h1>
        <a href="{{ route('roles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear nuevo rol</a>
    </div>

    @foreach ($roles as $role)
        <div class="bg-white dark:bg-gray-800 shadow rounded p-4 mb-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $role->name }}</h2>
                <div class="flex gap-2">
                    <a href="{{ route('roles.edit', $role) }}" class="text-yellow-500 hover:underline">Editar</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('¿Eliminar este rol?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:underline">Eliminar</button>
                    </form>
                </div>
            </div>
            <p class="text-sm text-gray-700 dark:text-gray-300">Permisos: {{ $role->permissions->pluck('name')->join(', ') ?: 'Sin permisos' }}</p>
        </div>
    @endforeach
</div>
@endsection
