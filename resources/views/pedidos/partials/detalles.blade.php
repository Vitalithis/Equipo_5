<div id="detalles-{{ $pedido->id }}"
     class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary font-['Roboto'] text-gray-800">
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <p><strong class="text-eprimary">Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
            <p><strong class="text-eprimary">Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
            <p><strong class="text-eprimary">Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div>
            <p class="font-semibold text-eprimary mb-2">Productos:</p>
            <ul class="list-disc list-inside ml-4 space-y-1">
                @foreach ($pedido->detalles as $detalle)
                    <li>
                        <span class="text-gray-800">{{ $detalle->nombre_producto_snapshot }}</span>
                        <span class="text-gray-600">(x{{ $detalle->cantidad }},
                        ${{ number_format($detalle->precio_unitario, 0, ',', '.') }},
                        Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
