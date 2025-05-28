@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('content')
{{-- Tipografías --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
    {{-- Encabezado con buscador y botón --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
        {{-- Filtro por email --}}
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-grow items-center space-x-3">
            <input type="text" name="email" value="{{ request('email') }}"
                   class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring focus:border-green-500"
                   placeholder="Buscar por correo electrónico">
            <button type="submit"
                    class="bg-eaccent2 text-white px-4 py-2 rounded border border-eaccent2 hover:bg-green-700 shadow">
                Buscar
            </button>
            @if(request('email'))
                <a href="{{ route('users.index') }}"
                   class="text-gray-500 hover:underline text-sm">Limpiar</a>
            @endif
        </form>

        {{-- Botón Nuevo Usuario --}}
        @can('gestionar usuarios')
            <a href="{{ route('users.create') }}"
               class="flex items-center text-green-700 hover:text-green-800 border border-green-700 hover:border-green-800 px-3 py-1 rounded transition-colors whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Usuario
            </a>
        @endcan
    </div>

    {{-- Tabla de usuarios --}}
    <div class="w-full overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
        <table class="min-w-full table-auto divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-4 py-3 whitespace-nowrap">Email</th>
                    <th class="px-4 py-3 whitespace-nowrap">Rol actual</th>
                    <th class="px-4 py-3 whitespace-nowrap">Acción</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3 font-medium whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $user->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $user->roles->pluck('name')->join(', ') ?: 'user' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($user->email === 'admin@editha.com')
                                <span class="text-gray-400 italic">Protegido</span>
                            @else
                                <form action="{{ route('users.updateRole', $user) }}" method="POST" class="flex items-center space-x-2 flex-wrap">
                                    @csrf
                                    @method('PUT')
                                    <select name="role" class="border rounded px-2 py-1 text-sm">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                            class="text-indigo-600 hover:text-indigo-800 border border-indigo-600 hover:border-indigo-800 px-3 py-1 rounded transition-colors">
                                        Asignar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
