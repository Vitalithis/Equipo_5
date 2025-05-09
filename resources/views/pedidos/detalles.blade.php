<tr>
    <td colspan="5" class="p-0">
        <div id="detalles-{{ $pedido->id }}"
             class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
            <div class="p-6 space-y-6">
                <!-- Info general -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <p><strong class="text-eprimary">Método de entrega:</strong> <span class="text-gray-800">{{ $pedido->metodo_entrega }}</span></p>
                    <p><strong class="text-eprimary">Dirección:</strong> <span class="text-gray-800">{{ $pedido->direccion ?? 'No disponible' }}</span></p>
                    <p><strong class="text-eprimary">Fecha de pedido:</strong> <span class="text-gray-800">{{ $pedido->created_at->format('d-m-Y H:i') }}</span></p>
                </div>

                <!-- Lista de productos -->
                <div>
                    <p class="font-semibold text-eprimary mb-2">Productos:</p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        @foreach ($pedido->detalles as $detalle)
                            <li class="text-gray-700">
                                {{ $detalle->nombre_producto_snapshot }}
                                <span class="text-gray-500">(x{{ $detalle->cantidad }},
                                ${{ number_format($detalle->precio_unitario, 0, ',', '.') }},
                                Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Boleta info -->
                <div class="flex flex-wrap items-center gap-3">
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

                <!-- Botón boleta provisoria -->
                <div class="pt-2">
                    <a href="{{ route('boletas.provisoria', $pedido->id) }}"
                       class="inline-block bg-[#FEF9C3] hover:bg-[#FDE047] text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition">
                        Ver boleta provisoria
                    </a>
                </div>
            </div>
        </div>
    </td>
</tr>
