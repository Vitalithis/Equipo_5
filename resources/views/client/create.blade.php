@extends('layouts.dashboard')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="max-w-2xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Crear nuevo cliente</h2>

    @if ($errors->any())
        <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('clients.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Nombre del Cliente</label>
            <input type="text" name="nombre" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Subdominio</label>
            <input type="text" name="subdominio" class="w-full border p-2 rounded" required>
            <p class="text-sm text-gray-500">Ejemplo: vivero → vivero.plantaseditha.me</p>
        </div>

        <hr class="my-4">

        <h3 class="text-lg font-semibold">Usuario Administrador</h3>

        <div>
            <label class="block mb-1 font-medium">Correo electrónico</label>
            <input type="email" name="admin_email" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Contraseña</label>
            <input type="password" name="admin_password" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Confirmar contraseña</label>
            <input type="password" name="admin_password_confirmation" class="w-full border p-2 rounded" required>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Crear Cliente</button>
    </form>
</div>
@endsection
