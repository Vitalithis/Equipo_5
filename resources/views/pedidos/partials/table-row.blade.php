<tr class="hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles({{ $pedido->id }})">
    <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
    <td class="px-6 py-4 text-center text-gray-900">{{ $pedido->usuario->name }}</td>
    <td class="px-6 py-4 text-center text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</td>
    <td class="px-6 py-4 text-center text-gray-900">
        @include('pedidos.partials.estado_form', ['pedido' => $pedido])
    </td>
    <td class="px-6 py-4 text-center">
        <span id="icon-{{ $pedido->id }}" class="inline-block">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                 class="w-5 h-5 text-eprimary">
                <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
            </svg>
        </span>
    </td>
</tr>
<tr>
    <td colspan="5" class="p-0">
        @include('pedidos.partials.detalles', ['pedido' => $pedido])
    </td>
</tr>
