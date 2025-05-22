<tr class="hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles({{ $pedido->id }})">
    <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
    <td class="px-6 py-4 text-center text-gray-900">{{ $pedido->usuario->name }}</td>
    <td class="px-6 py-4 text-center text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</td>
    <td class="px-6 py-4 text-center text-gray-900">
        @include('pedidos.partials.estado_form', ['pedido' => $pedido])
    </td>

    <!-- NUEVO: Botón editar -->
<td class="px-6 py-4 whitespace-nowrap">
    <a href="{{ route('pedidos.edit', $pedido->id) }}" class="text-blue-600 hover:text-blue-900">
        Editar
    </a>

    <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de eliminar este pedido?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:text-red-900">
            Eliminar
        </button>
    </form>
</td>
</tr>
<tr>
    <td colspan="6" class="p-0">
        @include('pedidos.partials.detalles', ['pedido' => $pedido])
    </td>
</tr>
