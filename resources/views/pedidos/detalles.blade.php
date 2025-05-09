<tr>
    <td colspan="5" class="p-0">
        <div id="detalles-{{ $pedido->id }}"
             class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
            <div class="p-4">
                <p class="mb-2"><strong class="text-eprimary">Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
                <p class="mb-2"><strong class="text-eprimary">Dirección:</strong> {{ $pedido->direccion ?? 'No disponible' }}</p>
                <p class="mb-4"><strong class="text-eprimary">Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
                
                <p class="font-semibold text-eprimary mb-2">Productos:</p>
                <ul class="list-disc list-inside ml-4 mb-4">
                    @foreach ($pedido->detalles as $detalle)
                        <li>
                            {{ $detalle->nombre_producto_snapshot }}
                            (x{{ $detalle->cantidad }},
                            ${{ number_format($detalle->precio_unitario, 0, ',', '.') }},
                            Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})
                        </li>
                    @endforeach
                </ul>

                <p class="flex items-center gap-2 mb-4">
                    <strong class="text-eprimary">Boleta SII:</strong>
                    @if($pedido->boleta_final_path)
                        <span class="text-green-600 font-medium">Subida</span>
                        <a href="{{ asset('storage/' . $pedido->boleta_final_path) }}" 
                           target="_blank"
                           class="text-esecondary hover:text-eaccent text-sm underline"
                           title="Ver Boleta SII">
                           Ver PDF
                        </a>
                    @else
                        <span class="text-red-500 font-medium">No subida</span>
                    @endif

                    <a href="{{ route('boletas.subir', $pedido->id) }}"
                       class="text-eaccent hover:text-eaccent2 text-lg"
                       title="Subir PDF">
                       📤
                    </a>
                </p>

                <div class="mt-4">
                    <a href="{{ route('boletas.provisoria', $pedido->id) }}"
                       class="inline-block bg-eaccent hover:bg-eaccent2 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition">
                        Ver boleta provisoria
                    </a>
                </div>
            </div>
        </div>
    </td>
</tr>
