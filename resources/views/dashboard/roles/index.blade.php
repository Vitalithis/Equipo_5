@extends($layout)

@section('title', 'Listado de Roles')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
            Roles del Sistema
        </h1>
        <a href="{{ route('roles.create', ['source' => $source]) }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Rol
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg">
        <table class="min-w-full table-auto divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase tracking-wider">
                <tr>
                    <th class="w-1/6 px-4 py-3">Nombre</th>
                    <th class="w-3/5 px-4 py-3">Permisos</th>
                    <th class="w-1/6 px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($roles as $role)
                    <tr>
                        {{-- Nombre --}}
                        <td class="px-4 py-3 font-medium text-gray-800 border-r border-gray-200">
                            {{ $role->name }}
                        </td>

                        {{-- Permisos en 2 columnas --}}
                        <td class="px-4 py-3 text-gray-700 border-r border-gray-200">
                            @if($role->permissions->isEmpty())
                                <span class="italic text-gray-400">Sin permisos asignados</span>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1">
                                    @foreach($role->permissions->pluck('name') as $perm)
                                        <span class="text-sm">{{ $perm }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3 text-gray-700">
                            @if($role->name !== 'superadmin')
                                <a href="{{ route('roles.edit', ['role' => $role->id, 'source' => $source]) }}"
                                   class="text-blue-600 hover:underline">Editar</a>
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="inline-block ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Estás seguro de eliminar este rol?')"
                                            class="text-red-600 hover:underline">Eliminar</button>
                                </form>
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
