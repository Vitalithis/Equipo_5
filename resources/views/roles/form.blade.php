@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $role ? 'Editar Rol' : 'Crear Nuevo Rol' }}</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $role ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
        @csrf
        @if($role)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nombre del Rol:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $role->name ?? '') }}" class="w-full border border-gray-300 px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Permisos:</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                                class="form-checkbox">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                {{ $role ? 'Actualizar Rol' : 'Crear Rol' }}
            </button>
            <a href="{{ route('roles.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
<<<<<<< Updated upstream:resources/views/dashboard/roles/form.blade.php
<<<<<<< Updated upstream:resources/views/dashboard/roles/form.blade.php

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">{{ $role ? 'Editar Rol' : 'Crear Nuevo Rol' }}</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $role ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
        @csrf
        @if($role)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-gray-700">Nombre del Rol:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $role->name ?? '') }}" class="w-full border border-gray-300 px-3 py-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Permisos:</label>
            <div class="grid grid-cols-2 gap-2">
                @foreach($permissions as $permission)
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                {{ (isset($role) && $role->permissions->contains($permission->id)) || (is_array(old('permissions')) && in_array($permission->id, old('permissions'))) ? 'checked' : '' }}
                                class="form-checkbox">
                            <span class="ml-2">{{ $permission->name }}</span>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div>
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                {{ $role ? 'Actualizar Rol' : 'Crear Rol' }}
            </button>
            <a href="{{ route('roles.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
        </div>
    </form>
</div>
@endsection
=======
>>>>>>> Stashed changes:resources/views/roles/form.blade.php
=======
>>>>>>> Stashed changes:resources/views/roles/form.blade.php
