@extends('layouts.dashboard')

@section('title', 'Crear Cliente')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-green-700">Nuevo Cliente</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.clientes.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="nombre" class="block font-semibold text-gray-700">Nombre del Cliente:</label>
            <input type="text" name="nombre" id="nombre"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1"
                   value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-4">
            <label for="slug" class="block font-semibold text-gray-700">Slug:</label>
            <input type="text" name="slug" id="slug"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1"
                   value="{{ old('slug') }}" required>
        </div>

        <hr class="my-6">

        <h3 class="text-lg font-semibold text-green-600 mb-2">Usuario Admin</h3>

        <div class="mb-4">
            <label for="email_admin" class="block font-semibold text-gray-700">Correo electrónico:</label>
            <input type="email" name="email_admin" id="email_admin"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1"
                   value="{{ old('email_admin') }}" required>
        </div>

        <div class="mb-4">
            <label for="password_admin" class="block font-semibold text-gray-700">Contraseña:</label>
            <input type="password" name="password_admin" id="password_admin"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
        </div>

        <div class="mb-6">
            <label for="password_admin_confirmation" class="block font-semibold text-gray-700">Confirmar Contraseña:</label>
            <input type="password" name="password_admin_confirmation" id="password_admin_confirmation"
                   class="w-full border border-gray-300 rounded px-3 py-2 mt-1" required>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.clientes.index') }}"
               class="mr-3 text-gray-600 hover:underline">Cancelar</a>
            <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
