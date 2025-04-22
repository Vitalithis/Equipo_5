<!-- resources/views/livewire/cart.blade.php -->

<div class="p-6 bg-white shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Carrito de Compras</h2>

    @if (empty($cart))
        <p class="text-gray-500">Tu carrito está vacío.</p>
    @else
        <table class="w-full text-left mb-4">
            <thead class="border-b">
                <tr>
                    <th class="py-2">Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $id => $item)
                    <tr class="border-b">
                        <td class="py-2 flex items-center gap-2">
                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-12 h-12 object-cover rounded">
                            {{ $item['name'] }}
                        </td>
                        <td>${{ number_format($item['price'], 2) }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <button wire:click="decrement({{ $id }})" class="px-2 py-1 bg-gray-200 rounded">-</button>
                                {{ $item['quantity'] }}
                                <button wire:click="increment({{ $id }})" class="px-2 py-1 bg-gray-200 rounded">+</button>
                            </div>
                        </td>
                        <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                        <td>
                            <button wire:click="remove({{ $id }})" class="text-red-600 hover:underline">Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold">Total: ${{ number_format($this->total, 2) }}</h3>
            <button wire:click="clear" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Vaciar carrito
            </button>
        </div>
    @endif
</div>
