@extends('dashboard')

@section('title', 'Boleta')

@section('default-content')
@endsection

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10 bg-white rounded shadow border border-gray-300">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Vivero Plantas Editha</h1>
    <p class="text-center text-sm text-gray-600 mb-6">
        RUT: 12.345.678-9 | Av. Pedro Aguirre cerda 2999, San Pedro de la paz | +56 9 1234 5678
    </p>

    <div class="mb-4">
        <p><strong>Fecha:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
        <p><strong>N° Pedido:</strong> {{ $pedido->id }}</p>
        <p><strong>Cliente:</strong> {{ $pedido->usuario->name }}</p>
        <p><strong>Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
        <p><strong>Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
    </div>

    <div class="overflow-x-auto rounded-lg shadow mb-4">
        <table class="min-w-full divide-y divide-gray-300 text-sm">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-2 py-1 text-left">Producto</th>
                    <th class="px-2 py-1 text-right">Cantidad</th>
                    <th class="px-2 py-1 text-right">Precio Unitario</th>
                    <th class="px-2 py-1 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($pedido->detalles as $detalle)
                    <tr>
                        <td class="px-2 py-1">{{ $detalle->nombre_producto_snapshot }}</td>
                        <td class="px-2 py-1 text-right">{{ $detalle->cantidad }}</td>
                        <td class="px-2 py-1 text-right">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                        <td class="px-2 py-1 text-right">${{ number_format($detalle->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-right text-sm mb-6">
        <p><strong>Subtotal:</strong> ${{ number_format($subtotal, 0, ',', '.') }}</p>
        <p><strong>Descuento (10%):</strong> -${{ number_format($descuento, 0, ',', '.') }}</p>
        <p class="text-lg font-bold"><strong>Total Final:</strong> ${{ number_format($totalFinal, 0, ',', '.') }}</p>
    </div>

    <div class="text-center text-gray-600">
        <p>Gracias por su compra</p>
        <p class="text-xs">Documento generado electrónicamente - No válido como documento fiscal</p>
    </div>

    <div class="mt-6 text-center">
        <a href="{{ route('pedidos.index') }}"
           class="inline-block bg-eaccent2 hover:bg-eaccent2-400 text-eprimary px-4 py-2 rounded shadow transition">
            Volver a pedidos
        </a>
        <a href="{{ route('boletas.pdf', $pedido->id) }}"
            class="inline-block bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded shadow transition ml-2">
                Descargar PDF
        </a>

    </div>
</div>
@endsection
