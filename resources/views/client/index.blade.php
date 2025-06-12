@extends('layouts.dashboard')

@section('title', 'Clientes')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Clientes</h1>

    <a href="{{ route('clients.create') }}" class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
        + Nuevo Cliente
    </a>

    @if (session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow rounded">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Subdominio</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $cliente->data['nombre'] ?? 'Sin nombre' }}</td>
                        <td class="px-4 py-2">
                            {{ $cliente->domains->first()->domain ?? 'No definido' }}
                        </td>
                        <td class="px-4 py-2">
                            @if ($cliente->data['activo'] ?? false)
                                <span class="text-green-600 font-semibold">Activo</span>
                            @else
                                <span class="text-red-600 font-semibold">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <form method="POST" action="{{ route('clients.toggle', $cliente) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-blue-600 hover:underline">
                                    {{ ($cliente->data['activo'] ?? false) ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <a href="{{ route('clients.show', $cliente) }}" class="text-blue-600 hover:underline">Ver</a>

                            @if ($cliente->domains->first())
                                <a href="http://{{ $cliente->domains->first()->domain }}" target="_blank" class="text-green-600 hover:underline">
                                    Ir al sitio
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
