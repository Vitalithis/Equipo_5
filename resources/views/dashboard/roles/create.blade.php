@extends('layouts.dashboard')

@section('title', 'Crear Rol')

@section('content')
<div class="max-w-2xl mx-auto py-8" style="font-family: 'Roboto', sans-serif;">

    {{-- Botón Volver --}}
    <a href="{{ route('roles.index') }}"
       class="mb-4 inline-flex items-center text-green-700 hover:text-green-800 transition-colors">
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

    <form action="{{ route('roles.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf

        {{-- Nombre del rol --}}
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Rol</label>
            <input type="text" name="name" id="name" required
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-eaccent focus:border-eaccent">
        </div>

        {{-- Permisos --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Permisos</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-2">
                @foreach($permissions as $permission)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                               class="form-checkbox text-eaccent border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Botón Guardar --}}
        <div class="mt-6">
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
