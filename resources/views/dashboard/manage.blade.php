@extends('layouts.dashboard')
@section('title', 'Asignar Roles a Usuarios')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Asignar Roles a Usuarios</h1>

    @foreach ($users as $user)
        <div class="bg-white dark:bg-gray-800 shadow rounded p-4 mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }} <span class="text-sm text-gray-500">({{ $user->email }})</span></h2>

            <form action="{{ route('roles.assign', $user) }}" method="POST" class="mt-3 flex gap-4 items-center">
                @csrf
                <select name="role" id="role_{{ $user->id }}"
                        class="px-3 py-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white dark:border-gray-600">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Asignar</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
