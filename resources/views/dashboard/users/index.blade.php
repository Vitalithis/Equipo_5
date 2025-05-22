@extends('layouts.dashboard')

@section('title', 'Gestión de Usuarios')

@section('content')
    {{-- Tipografías --}}
    <link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <div class="py-8 px-4 md:px-8 max-w-7xl mx-auto font-['Roboto'] text-gray-800">
        <div class="flex items-center justify-between mb-6">
            {{-- Puedes agregar un botón si lo necesitas --}}
        </div>

        <div class="overflow-x-auto rounded-xl border border-eaccent2">
            <table class="min-w-full table-auto divide-y divide-eaccent2 text-sm text-left bg-white">
                <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Rol actual</th>
                        <th class="px-4 py-3">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                {{ $user->roles->pluck('name')->join(', ') ?: 'Sin rol' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($user->email === 'admin@editha.com')
                                    <span class="text-gray-400 italic">Protegido</span>
                                @else
                                    <form action="{{ route('users.updateRole', $user) }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="border rounded px-2 py-1 text-sm">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700">
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
