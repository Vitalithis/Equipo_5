@extends('layouts.dashboard')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="py-8 px-4 max-w-3xl mx-auto font-['Roboto'] text-gray-800">
    <a href="{{ route('clients.index') }}" class="flex items-center text-green-700 hover:text-green-800 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
        </svg>
        Volver a la lista
    </a>

    <h1 class="text-2xl font-bold mb-6">Crear Nuevo Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="nombre" class="block font-medium mb-1">Nombre del Cliente</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
            @error('nombre')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="subdominio" class="block font-medium mb-1">Subdominio</label>
            <input type="text" id="subdominio" name="subdominio" value="{{ old('subdominio') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
            @error('subdominio')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <hr class="my-6">

        <div>
            <label for="admin_email" class="block font-medium mb-1">Correo del Administrador</label>
            <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email') }}"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
            @error('admin_email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="admin_password" class="block font-medium mb-1">Contraseña</label>
            <input type="password" id="admin_password" name="admin_password"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
            @error('admin_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="admin_password_confirmation" class="block font-medium mb-1">Confirmar Contraseña</label>
            <input type="password" id="admin_password_confirmation" name="admin_password_confirmation"
                   class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-green-500">
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition-colors">
                Guardar Cliente
            </button>
        </div>
    </form>
</div>
@endsection
