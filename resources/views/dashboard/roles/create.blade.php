@extends('layouts.dashboard')

@section('title', 'Crear Rol')

@section('content')
<div class="max-w-6xl mx-auto py-8 font-['Roboto'] text-gray-800">

    <a href="{{ route('roles.index') }}"
       class="mb-4 inline-flex items-center text-white transition-colors px-3 py-1 rounded"
       style="background-color: var(--table-header-color);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6" />
        </svg>
        Volver a la lista
    </a>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('roles.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 border" style="border-color: var(--table-header-color);">
        @csrf

        {{-- Nombre del Rol --}}
        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Rol</label>
            <input type="text" name="name" id="name" required
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent px-4 py-2">
        </div>

        {{-- Permisos --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Permisos</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-0 border rounded overflow-hidden"
                 style="border-color: var(--table-header-color);">

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
                    <div class="border-t border-r p-4" style="border-color: var(--table-header-color);">
                        <h3 class="font-bold text-black mb-2">{{ $group }}</h3>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-2">
                            @foreach($permissions as $permission)
                                @if(in_array($permission->name, $perms))
                                    <label class="inline-flex items-center text-black">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                               class="form-checkbox text-black border-black rounded focus:ring-black">
                                        <span class="ml-2 text-sm text-black">{{ $permission->name }}</span>
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
                    class="text-white font-semibold px-6 py-2 rounded shadow"
                    style="background-color: var(--table-header-color);">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
