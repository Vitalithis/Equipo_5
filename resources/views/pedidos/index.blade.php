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
                        <th class="px-6 py-3">Usuario</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Estado actual</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore-300 text-gray-800">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-eaccent2-50 transition">
                            <td class="px-6 py-4">{{ $pedido->id }}</td>
                            <td class="px-6 py-4">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')

                                    @php
                                        $estados = [
                                            'pendiente' => 'Pendiente',
                                            'en_preparacion' => 'En preparación',
                                            'en_camino' => 'En camino',
                                            'enviado' => 'Enviado',
                                            'entregado' => 'Entregado',
                                            'listo_para_retiro' => 'Listo para retiro',
                                        ];
                                    @endphp

                                    <select name="estado_pedido"
                                            class="rounded border border-efore-400 px-2 py-1 text-sm bg-white text-eprimary focus:ring-2 focus:ring-eaccent2-500">
                                        @foreach ($estados as $valor => $texto)
                                            <option value="{{ $valor }}" @selected($pedido->estado_pedido === $valor)>
                                                {{ $texto }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit"
                                            class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-3 py-1 rounded shadow transition text-sm">
                                        Guardar
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4 overflow-x-auto text-sm"> 

                                    {{-- Generar boleta --}}
                                    <div class="pl-4 border-l border-r border-efore-300">
                                        <form action="{{ route('pedidos.generarBoleta', $pedido->id) }}" method="GET">
                                            <button type="submit" class="bg-white border border-gray-300 hover:bg-gray-100 text-eprimary font-semibold px-3 py-1 rounded shadow transition">
                                                Boleta
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Subir archivo --}}
                                    <div class="pl-4 border-l border-r border-efore-300">
                                        <form action="{{ route('pedidos.subirBoleta', $pedido->id) }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-2">
                                            @csrf
                                            <input type="file" name="boleta_pdf" accept="application/pdf"
                                                class="text-xs border border-gray-300 rounded px-2 py-1 max-w-[180px] truncate">
                                            <button type="submit" class="bg-white border border-gray-300 hover:bg-gray-100 text-eprimary font-semibold px-3 py-1 rounded shadow transition">
                                                Subir SII
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Ver detalles --}}
                                    <div class="pl-4 border-l border-efore-300">
                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="text-blue-600 hover:text-blue-800 underline">
                                            Ver Detalles
                                        </a>
                                    </div>

                                    </div>

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
