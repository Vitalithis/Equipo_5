@extends('layouts.dashboard')

@section('title', 'Gestión de Clientes')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-green-700">Clientes Registrados</h2>
        <a href="{{ route('admin.clientes.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold">
            + Crear Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if($clientes->isEmpty())
        <p class="text-gray-600">No hay clientes registrados.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left font-semibold uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-center font-semibold uppercase tracking-wider">Usuarios</th>
                        <th class="px-6 py-3 text-center font-semibold uppercase tracking-wider">Productos</th>
                        <th class="px-6 py-3 text-center font-semibold uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($clientes as $cliente)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $cliente->slug }}</td>
                            <td class="px-6 py-4 text-center">{{ $cliente->total_usuarios ?? 0 }}</td>
                            <td class="px-6 py-4 text-center">{{ $cliente->total_productos ?? 0 }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('admin.clientes.usuarios', $cliente) }}"
                                   class="inline-block px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Usuarios
                                </a>
                                <a href="{{ route('admin.clientes.productos', $cliente) }}"
                                   class="inline-block px-3 py-1 bg-purple-600 text-white rounded hover:bg-purple-700">
                                    Productos
                                </a>
                                <form action="{{ route('admin.clientes.destroy', $cliente) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-block px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
