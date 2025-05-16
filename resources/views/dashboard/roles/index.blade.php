@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Gestión de Roles</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('roles.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Nuevo Rol</a>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Permisos</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $role->name }}</td>
                    <td class="py-2 px-4 border-b">
                        @foreach ($role->permissions as $permission)
                            <span class="inline-block bg-gray-200 text-gray-800 text-xs px-2 py-1 rounded">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('roles.edit', $role->id) }}" class="text-blue-500 hover:underline mr-2">Editar</a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('¿Estás seguro de eliminar este rol?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
