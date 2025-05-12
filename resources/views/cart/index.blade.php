@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto my-10 px-4">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Tu Carrito</h2>

        @if (session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Productos en el carrito -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach (session('cart') as $id => $item)
                        <div class="flex items-center gap-4 bg-white rounded-lg shadow p-4">
                            <img src="{{ $item['imagen'] }}" alt="{{ $item['nombre'] }}" class="w-24 h-24 object-cover rounded">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item['nombre'] }}</h3>
                                <p class="text-sm text-gray-500">Precio: ${{ number_format($item['precio'], 0, ',', '.') }}</p>
                                <div class="flex items-center mt-2 gap-2">
                                    <!-- Formulario para actualizar la cantidad -->
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1"
                                            class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                                        <button type="submit"
                                            class="ml-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Actualizar</button>
                                    </form>
                                    <!-- Formulario para eliminar el producto del carrito -->
                                    <form action="{{ route('cart.remove.solo', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="ml-2 text-red-500 hover:underline text-sm">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                            <div class="text-right font-bold text-gray-700">
                                ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                    <!-- Código para aplicar un descuento -->
                    <div class="bg-gray-100 p-4 rounded-lg mt-4">
                        <h3 class="text-lg font-semibold mb-2">Aplicar Descuento</h3>
                        <form action="{{ route('cart.aplicar-descuento') }}" method="POST" class="flex items-center">
                            @csrf
                            <input type="text" name="codigo" placeholder="Código de descuento"
                                class="w-full px-3 py-2 border border-gray-300 rounded mr-2">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Aplicar</button>
                        </form>
                        @if(session('descuento_error'))
                            <div class="mt-2 text-red-500">
                                {{ session('descuento_error') }}
                            </div>
                        @endif

                    @if(session('descuento_aplicado'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            <p class="font-bold">Descuento aplicado:</p>
                            <p>
                                Código: {{ session('descuento_aplicado.codigo') }} -
                                @if(session('descuento_aplicado.tipo') == 'porcentaje')
                                    {{ session('descuento_aplicado.valor') }}% de descuento
                                @elseif(session('descuento_aplicado.tipo') == 'monto_fijo')
                                    ${{ number_format(session('descuento_aplicado.valor'), 2) }} de descuento
                                @else
                                    Envío gratis
                                @endif
                            </p>
                        </div>
                    @endif
                    </div>
                </div>
                <!-- Resumen del carrito -->
                <div class="bg-white p-6 rounded-lg shadow-md h-fit">
                    <h3 class="text-xl font-bold mb-4">Resumen</h3>

                    @php
                        // Calcular subtotal (suma de precios originales)
                        $subtotal = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart', [])));

                        // Calcular descuento total
                        $descuentoTotal = 0;
                        if (session('descuento_aplicado')) {
                            foreach (session('cart', []) as $item) {
                                if (isset($item['precio_con_descuento'])) {
                                    $descuentoTotal += ($item['precio'] - $item['precio_con_descuento']) * $item['cantidad'];
                                }
                            }
                        }

                        // Calcular total final
                        $total = $subtotal - $descuentoTotal;
                    @endphp

                    <!-- Mostrar subtotal -->
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">${{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <!-- Mostrar descuento si existe -->
                    @if($descuentoTotal > 0)
                        <div class="flex justify-between mb-1 text-green-600">
                            <span>Descuento:</span>
                            <span class="font-medium">-${{ number_format($descuentoTotal, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <!-- Mostrar total final -->
                    <div class="flex justify-between border-t pt-2 mt-2">
                        <span class="text-lg font-semibold text-gray-700">Total:</span>
                        <span class="text-lg font-bold">${{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <!-- Vaciar el carrito -->
                    <form action="{{ route('cart.clear') }}" method="POST" class="mb-4 mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">
                            Vaciar Carrito
                        </button>
                    </form>

                    {{-- Formulario para proceder al pago con Transbank --}}
                    <form action="{{ route('checkout.pay') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $total }}">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded transition">
                            Proceder al Pago con Webpay
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="bg-white p-6 rounded-lg shadow text-center mt-6">
                <p class="text-gray-700 text-lg">Tu carrito está vacío.</p>
                <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Volver a la tienda</a>
            </div>
        @endif
    </div>
@endsection
