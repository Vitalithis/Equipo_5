@extends('layouts.dashboard')

@section('title', 'Clientes')

@section('content')
<div x-data="{ modalCliente: null }" class="py-8 px-4 font-['Roboto'] text-gray-800">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Clientes Registrados</h1>
        <a href="{{ route('clients.create') }}" class="text-green-600 hover:text-green-800 flex items-center">
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Cliente
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Subdominio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Activo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($clientes as $cliente)
                    <tr>
                        <td class="px-6 py-4">{{ $cliente->nombre }}</td>
                        <td class="px-6 py-4">{{ $cliente->subdominio }}</td>
                        <td class="px-6 py-4">{{ $cliente->activo ? 'Sí' : 'No' }}</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <button @click="modalCliente = {{ $cliente->id }}" class="text-blue-600 hover:text-blue-800">Ver</button>
                            <form action="{{ route('clients.toggle', $cliente->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="text-sm {{ $cliente->activo ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }}">
                                    {{ $cliente->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div x-show="modalCliente === {{ $cliente->id }}"
                         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                         style="display: none;">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                            <h2 class="text-xl font-semibold mb-4">Detalle del Cliente</h2>
                            <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                            <p><strong>Subdominio:</strong> {{ $cliente->subdominio }}</p>
                            <p><strong>Slug:</strong> {{ $cliente->slug }}</p>
                            <p><strong>Activo:</strong> {{ $cliente->activo ? 'Sí' : 'No' }}</p>

                            <div class="mt-4 text-right">
                                <button @click="modalCliente = null" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Cerrar</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
