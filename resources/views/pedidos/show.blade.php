@extends('layouts.app')

@section('title', 'Detalle del Pedido')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-10 bg-efore rounded shadow">
    <h1 class="text-3xl font-bold text-eprimary mb-6">Detalle del Pedido #{{ $pedido->id }}</h1>

    {{-- Información general del pedido --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6 text-sm text-eprimary">
        <div><strong>Usuario:</strong> {{ $pedido->usuario->name }}</div>
        <div><strong>Fecha del pedido:</strong> {{ $pedido->fecha_pedido }}</div>
        <div><strong>Método de entrega:</strong> {{ ucfirst($pedido->metodo_entrega) }}</div>
        <div><strong>Dirección de entrega:</strong> {{ $pedido->direccion_entrega ?? '-' }}</div>
        <div><strong>Estado:</strong> {{ ucfirst(str_replace('_', ' ', $pedido->estado_pedido)) }}</div>
        <div><strong>Forma de pago:</strong> {{ ucfirst($pedido->forma_pago) }}</div>
        <div><strong>Tipo de documento:</strong> {{ ucfirst($pedido->tipo_documento) }}</div>
        <div><strong>Monto pagado:</strong> ${{ number_format($pedido->monto_pagado ?? $pedido->total, 0, ',', '.') }}</div>
        @if ($pedido->observaciones)
            <div class="sm:col-span-2"><strong>Observaciones:</strong> {{ $pedido->observaciones }}</div>
        @endif
    </div>

    {{-- Tabla de productos --}}
    <h2 class="text-xl font-semibold text-eprimary mb-3">Productos comprados</h2>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-gray-800">
            <thead class="bg-eaccent2-100 text-eprimary">
                <tr>
                    <th class="px-4 py-2 text-left">Producto</th>
                    <th class="px-4 py-2 text-left">Cantidad</th>
                    <th class="px-4 py-2 text-left">Precio Unitario</th>
                    <th class="px-4 py-2 text-left">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedido->detalles as $detalle)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $detalle->nombre_producto_snapshot }}</td>
                        <td class="px-4 py-2">{{ $detalle->cantidad }}</td>
                        <td class="px-4 py-2">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Total final --}}
    <div class="mt-6 text-right text-eprimary text-lg font-semibold">
        Total: ${{ number_format($pedido->total, 0, ',', '.') }}
    </div>

    {{-- Botón de volver --}}
    <div class="mt-6">
        <a href="{{ route('pedidos.index') }}"
           class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-4 py-2 rounded shadow transition text-sm">
            ← Volver a la lista de pedidos
        </a>
    </div>
</div>
@endsection
