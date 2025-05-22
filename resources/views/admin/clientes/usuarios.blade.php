@extends('layouts.dashboard')

@section('title', 'Usuarios de ' . $cliente->nombre)

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Usuarios del Cliente: {{ $cliente->nombre }}</h2>

    @if($usuarios->isEmpty())
        <p class="text-gray-600">No hay usuarios registrados para este cliente.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Correo</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Roles</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($usuarios as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $user->getRoleNames()->join(', ') ?: 'Sin rol' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.clientes.index') }}" class="text-green-700 hover:underline">
            ← Volver al listado de clientes
        </a>
    </div>
</div>
@endsection
