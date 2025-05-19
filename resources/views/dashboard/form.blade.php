@extends('layouts.dashboard')
@section('title', $role ? 'Editar Rol' : 'Crear Rol')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">{{ $role ? 'Editar Rol' : 'Crear Nuevo Rol' }}</h1>

    <form method="POST" action="{{ $role ? route('roles.update', $role) : route('roles.store') }}" class="space-y-6">
        @csrf
        @if($role)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del rol</label>
            <input type="text" name="name" id="name" value="{{ old('name', $role?->name) }}" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
        </div>

        <div>
            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Permisos</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach ($permissions as $permission)
                    <label class="flex items-center space-x-2 text-sm text-gray-800 dark:text-gray-100">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ $role && $role->permissions->contains($permission) ? 'checked' : '' }}
                            class="rounded text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span>{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                {{ $role ? 'Actualizar' : 'Crear' }}
            </button>
        </div>
    </form>
</div>
@endsection
