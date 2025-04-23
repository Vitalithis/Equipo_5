<!-- resources/views/livewire/cart.blade.php -->

<div class="p-6 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
    <h2 class="text-3xl font-extrabold mb-6 text-gray-900 dark:text-gray-100">🛒 Carrito de Compras</h2>

    @if (empty($cart))
        <p class="text-center text-gray-500 dark:text-gray-400">Tu carrito está vacío.</p>
    @else
        <div class="space-y-4">
            @foreach ($cart as $id => $item)
                <div class="flex flex-col sm:flex-row items-center sm:justify-between bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <!-- Imagen y nombre -->
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-md shadow-sm">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $item['name'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($item['price'], 2) }} c/u</p>
                        </div>
                    </div>

                    <!-- Cantidad controls -->
                    <div class="flex items-center mt-4 sm:mt-0 space-x-2">
                        <button wire:click="decrement({{ $id }})"
                                class="px-3 py-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 rounded-md">
                            −
                        </button>
                        <span class="px-3 py-1 bg-white dark:bg-gray-800 rounded-md font-medium">{{ $item['quantity'] }}</span>
                        <button wire:click="increment({{ $id }})"
                                class="px-3 py-1 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 rounded-md">
                            +
                        </button>
                    </div>

                    <!-- Subtotal y eliminar -->
                    <div class="flex items-center space-x-4 mt-4 sm:mt-0">
                        <span class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                        </span>
                        <button wire:click="remove({{ $id }})"
                                class="text-red-500 hover:text-red-700 dark:hover:text-red-400 font-medium">
                            Eliminar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Total y vaciar -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-between bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Total: ${{ number_format($this->total, 2) }}
            </h3>
            <button wire:click="clear"
                    class="mt-4 sm:mt-0 bg-red-500 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-800 text-white font-bold py-2 px-6 rounded-lg transition">
                Vaciar carrito
            </button>
        </div>
    @endif
</div>
