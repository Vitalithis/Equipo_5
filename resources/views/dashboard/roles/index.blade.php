@extends('layouts.dashboard')

@section('title', 'Listado de Roles')

@section('content')
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <div class="flex items-center mb-6">
            @can('crear roles')
                <a href="{{ route('roles.create', ['source' => $source]) }}"
                   class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 4v16m8-8H4"/>
                    </svg>
                    Agregar Rol
                </a>
            @endcan
        </div>

        <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
            <table class="min-w-full table-auto divide-y divide-eaccent2 text-sm text-left text-gray-800 border border-eaccent2">
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="w-1/6 px-4 py-3">Nombre</th>
                        <th class="w-4/6 px-4 py-3">Permisos</th>
                        <th class="w-1/6 px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto']">
                    @foreach($roles as $role)
                        <tr>
                            {{-- Nombre --}}
                            <td class="px-4 py-3 font-medium border-r border-eaccent2 align-top">
                                {{ $role->name }}
                            </td>

                            {{-- Permisos agrupados --}}
                            <td class="px-4 py-3 border-r border-eaccent2 align-top">
                                @if($role->permissions->isEmpty())
                                    <span class="italic text-gray-400">Sin permisos asignados</span>
                                @else
                                    @php
                                        $grouped = collect($role->permissions)->groupBy(function ($perm) {
                                            $parts = explode(' ', $perm->name);
                                            return $parts[1] ?? $parts[0];
                                        });
                                    @endphp

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($grouped as $modulo => $permisos)
                                            <div>
                                                <div class="font-semibold text-eprimary capitalize mb-1">{{ $modulo }}</div>
                                                <ul class="list-disc list-inside text-sm text-gray-800 ml-2">
                                                    @foreach($permisos as $perm)
                                                        <li>{{ $perm->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 align-top">
                                @if($role->name !== 'admin' && $role->name !== 'user')
                                    @can('editar roles')
                                        <a href="{{ route('roles.edit', ['role' => $role->id, 'source' => $source]) }}"
                                           class="text-blue-600 hover:underline">Editar</a>
                                    @endcan

                                    @can('eliminar roles')
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                                    class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    @endcan
                                @else
                                    <span class="text-gray-400 italic">Protegido</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
