@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if ($pedidos->count())
        <table class="min-w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Nombre</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                    <th class="px-4 py-2 text-left">Actualizar Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $pedido->id }}</td>
                        <td class="px-4 py-2">{{ $pedido->nombre }}</td>
                        <td class="px-4 py-2">{{ ucfirst($pedido->estado) }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('pedidos.cambiarEstado', $pedido->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                <select name="estado" class="border rounded px-2 py-1 text-sm">
                                    <option value="pendiente" @selected($pedido->estado === 'pendiente')>Pendiente</option>
                                    <option value="enviado" @selected($pedido->estado === 'enviado')>Enviado</option>
                                    <option value="entregado" @selected($pedido->estado === 'entregado')>Entregado</option>
                                </select>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Guardar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay pedidos registrados.</p>
    @endif
</div>
@endsection
