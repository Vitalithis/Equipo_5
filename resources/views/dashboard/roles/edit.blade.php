@extends('layouts.dashboard')

@section('title', 'Editar Rol')

@section('content')
<div class="max-w-6xl mx-auto py-8 font-['Roboto'] text-gray-800">

    <a href="{{ route('roles.index') }}"
       class="mb-4 inline-flex items-center text-green-700 hover:text-green-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    <form action="{{ route('roles.update', $role->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')

        {{-- Nombre del Rol --}}
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Rol</label>
            <input type="text" name="name" id="name" value="{{ $role->name }}" required
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent px-4 py-2">
        </div>

        {{-- Permisos --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Permisos</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-0 border border-eaccent2 rounded overflow-hidden">

                @php
                    $grouped = [
                        'Dashboard' => ['ver dashboard'],
                        'Usuarios' => ['gestionar usuarios', 'ver usuarios'],
                        'Permisos' => ['gestionar permisos'],
                        'Roles' => ['ver roles', 'crear roles', 'editar roles', 'eliminar roles'],
                        'Órdenes' => ['ver ordenes', 'crear ordenes', 'editar ordenes', 'eliminar ordenes'],
                        'Ingresos' => ['gestionar ingresos'],
                        'Egresos' => ['gestionar egresos'],
                        'Productos' => ['gestionar productos'],
                        'Catálogo' => ['gestionar catálogo'],
                        'Descuentos' => ['gestionar descuentos'],
                        'Reportes' => ['ver reportes'],
                        'Pedidos' => ['gestionar pedidos']
                    ];
                @endphp

                @foreach($grouped as $group => $perms)
                    <div class="border-t border-eaccent2 border-r p-4">
                        <h3 class="font-bold text-eprimary mb-2">{{ $group }}</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                            @foreach($permissions as $permission)
                                @if(in_array($permission->name, $perms))
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                            @if($role->permissions->contains($permission)) checked @endif
                                            class="form-checkbox text-eaccent border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
