<tr>
    <td colspan="5" class="p-0">
        <div id="detalles-{{ $pedido->id }}"
             class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore-200 text-sm border-t border-efore-300">
            <div class="p-4">
                <p><strong>Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
                <p><strong>Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
                <p><strong>Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
                
                <p><strong>Productos:</strong></p>
                <ul class="list-disc list-inside ml-4">
                    @foreach ($pedido->detalles as $detalle)
                        <li>
                            {{ $detalle->nombre_producto_snapshot }}
                            (x{{ $detalle->cantidad }},
                            ${{ number_format($detalle->precio_unitario, 0, ',', '.') }},
                            Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})
                        </li>
                    @endforeach
                </ul>
                <p class="flex items-center gap-2">
    <strong>Boleta SII:</strong>
    @if($pedido->boleta_final_path)
        Subida
        <a href="{{ asset('storage/' . $pedido->boleta_final_path) }}" 
           target="_blank"
           class="text-blue-500 hover:text-blue-700 text-sm underline"
           title="Ver Boleta SII">
           Ver PDF
        </a>
    @else
        No subida
    @endif

    <a href="{{ route('boletas.subir', $pedido->id) }}"
       class="text-indigo-500 hover:text-indigo-700 text-lg"
       title="Subir PDF">
       📤
    </a>
</p>



                {{-- Botón para generar boleta --}}
                <div class="mt-4">
                    <a href="{{ route('boletas.provisoria', $pedido->id) }}"
                       class="inline-block bg-green-500 hover:bg-green-600 text-white text-sm px-4 py-2 rounded shadow transition">
                        Ver boleta provisoria
                    </a>
                </div>
            </div>
        </div>
    </td>
</tr>
