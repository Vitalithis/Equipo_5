<tr>
    <td colspan="5" class="p-0">
        <div id="detalles-{{ $pedido->id }}"
             class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
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

                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-2">
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
                    </div>
                </div>

                <div class="pt-2">
                    <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                            data-url="{{ route('boletas.provisoria', $pedido->id) }}">
                            Ver boleta provisoria
                    </button>

                </div>
            </div>
        </div>
    </td>
</tr>
