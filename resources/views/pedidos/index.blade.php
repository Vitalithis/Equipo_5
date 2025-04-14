@extends('layouts.app')

@section('title', 'Gestión de Pedidos')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-efore rounded shadow">
    <h1 class="text-3xl font-bold text-eprimary mb-6">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-eaccent2-100 text-eprimary border-l-4 border-eaccent2-400 px-4 py-3 rounded mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-efore-100 rounded-lg shadow">
            <table class="min-w-full divide-y divide-efore-300 text-sm">
                <thead class="bg-eaccent2-100 text-eprimary uppercase text-left">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Estado actual</th>
                        <th class="px-6 py-3">Actualizar estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore-300 text-gray-800">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-eaccent2-100 transition">
                            <td class="px-6 py-4">{{ $pedido->id }}</td>
                            <td class="px-6 py-4">{{ $pedido->nombre }}</td>
                            <td class="px-6 py-4 font-medium">{{ ucfirst($pedido->estado) }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('pedidos.cambiarEstado', $pedido->id) }}" method="POST" class="flex items-center gap-3">
                                    @csrf
                                    <select name="estado" class="rounded border-efore-400 px-3 py-1 text-sm bg-white text-eprimary focus:ring-2 focus:ring-eaccent2-500">
                                        <option value="pendiente" @selected($pedido->estado === 'pendiente')>Pendiente</option>
                                        <option value="enviado" @selected($pedido->estado === 'enviado')>Enviado</option>
                                        <option value="entregado" @selected($pedido->estado === 'entregado')>Entregado</option>
                                    </select>
                                    <button type="submit" class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-4 py-1 rounded shadow text-sm transition">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-eprimary mt-6">No hay pedidos registrados.</p>
    @endif
</div>
@endsection
