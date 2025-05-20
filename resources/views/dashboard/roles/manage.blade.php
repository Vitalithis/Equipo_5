@extends($layout)
@section('title', 'Gestión de Roles')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">
    <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
        Gestión de Roles
    </h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if ($users->isEmpty())
        <p class="text-gray-600">No hay usuarios registrados aún.</p>
    @else
        <div class="overflow-auto">
            <table class="min-w-full bg-white shadow rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Rol Actual</th>
                        <th class="px-6 py-3 text-left">Asignar Nuevo Rol</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                {{ $user->roles->pluck('name')->join(', ') ?: 'Sin rol' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($user->hasRole('superadmin'))
                                    <span class="text-gray-400 italic">Protegido</span>
                                @else
                                    <form action="{{ route('users.updateRole', $user) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="border border-gray-300 rounded px-2 py-1 mr-2" required>
                                            <option value="" disabled selected>Selecciona un rol</option>
                                            @foreach ($roles as $role)
                                                @if($role->name !== 'superadmin')
                                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded">
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
    @endif
</div>
@endsection
