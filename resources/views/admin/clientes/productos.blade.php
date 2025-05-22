@extends('layouts.dashboard')

@section('title', 'Productos de ' . $cliente->nombre)

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4 text-green-700">Productos del Cliente: {{ $cliente->nombre }}</h2>

    @if($productos->isEmpty())
        <p class="text-gray-600">No hay productos registrados para este cliente.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Precio</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Stock</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($productos as $producto)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $producto->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">${{ number_format($producto->precio, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $producto->stock }}</td>
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
