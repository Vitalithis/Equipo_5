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
                                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Actualizar</button>
                                </form>

                                <!-- Formulario para eliminar el producto del carrito -->
                                <form action="{{ route('cart.remove.solo', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ml-2 text-red-500 hover:underline text-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right font-bold text-gray-700">
                            ${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Resumen del carrito -->
            <div class="bg-white p-6 rounded-lg shadow-md h-fit">
                <h3 class="text-xl font-bold mb-4">Resumen</h3>
                @php
                    $total = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart')));
                @endphp
                <p class="text-lg font-semibold text-gray-700 mb-2">Total: ${{ number_format($total, 0, ',', '.') }}</p>

                <!-- Vaciar el carrito -->
                <form action="{{ route('cart.clear') }}" method="POST" class="mb-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">Vaciar Carrito</button>
                </form>

                {{-- Paso 6-7: Formulario para proceder al pago con Transbank --}}
                <form action="{{ route('checkout.pay') }}" method="POST">
                    @csrf
                    <input type="hidden" name="amount" value="{{ $total }}">
                    <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded transition">
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
