<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">Gestión de Roles</h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded my-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-4">
        <table class="w-full text-sm text-left">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol Actual</th>
                    <th>Asignar Nuevo Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="border-b">
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                        <td>
                            <form action="{{ route('roles.assign', $user) }}" method="POST">
                                @csrf
                                <select name="role" class="border rounded px-2 py-1">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-indigo-500 text-white px-3 py-1 rounded ml-2">Asignar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>