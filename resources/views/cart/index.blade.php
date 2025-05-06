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
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1"
                                           class="w-16 px-2 py-1 border border-gray-300 rounded text-center">
                                    <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">Actualizar</button>
                                </form>

                                <form action="{{ route('cart.remove', $id) }}" method="POST">
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

                <form action="{{ route('cart.clear') }}" method="POST" class="mb-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">Vaciar Carrito</button>
                </form>

                <a href="{{ route('checkout.index') }}"
                   class="block text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded transition">
                    Proceder al Pago
                </a>
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


@section('scripts')
<script>
  // Leer/guardar carrito en localStorage
  const CART_KEY = 'my_ecom_cart';
  function getCart() {
    return JSON.parse(localStorage.getItem(CART_KEY) || '{}');
  }
  function saveCart(cart) {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
  }

  // Renderizar carrito en DOM
  function renderCart() {
    const cart = getCart();
    const container = document.getElementById('cart-items');
    container.innerHTML = '';
    let total = 0;
    for (let id in cart) {
      const item = cart[id];
      const sub = item.price * item.quantity;
      total += sub;
      const div = document.createElement('div');
      div.className = 'flex items-center justify-between bg-white p-4 rounded shadow';
      div.innerHTML = `
        <div class="flex items-center space-x-4">
          <img src="/storage/${item.image}" class="w-12 h-12 object-cover rounded">
          <div>
            <h4 class="font-semibold">${item.name}</h4>
            <p class="text-sm text-gray-600">$${item.price.toFixed(2)} c/u</p>
          </div>
        </div>
        <div class="flex items-center space-x-2">
          <button class="px-2 bg-gray-200 rounded decrement" data-id="${id}">−</button>
          <span>${item.quantity}</span>
          <button class="px-2 bg-gray-200 rounded increment" data-id="${id}">+</button>
          <button class="ml-4 text-red-500 remove" data-id="${id}">Eliminar</button>
        </div>
        <div class="ml-4 font-semibold">$${sub.toFixed(2)}</div>
      `;
      container.appendChild(div);
    }
    document.getElementById('cart-total').innerText = total.toFixed(2);

    // Attach event listeners
    document.querySelectorAll('.increment').forEach(btn=>{
      btn.addEventListener('click', e=>{
        const id = e.target.dataset.id;
        const cart = getCart();
        cart[id].quantity++;
        saveCart(cart);
        renderCart();
      });
    });
    document.querySelectorAll('.decrement').forEach(btn=>{
      btn.addEventListener('click', e=>{
        const id = e.target.dataset.id;
        const cart = getCart();
        if (cart[id].quantity>1) cart[id].quantity--;
        else delete cart[id];
        saveCart(cart);
        renderCart();
      });
    });
    document.querySelectorAll('.remove').forEach(btn=>{
      btn.addEventListener('click', e=>{
        const id = e.target.dataset.id;
        const cart = getCart();
        delete cart[id];
        saveCart(cart);
        renderCart();
      });
    });
  }

  // Inicializar
  document.addEventListener('DOMContentLoaded', ()=>{
    renderCart();

    // Add buttons en productos
    document.querySelectorAll('.add-to-cart').forEach(btn=>{
      btn.addEventListener('click', e=>{
        const id = e.target.dataset.id;
        const name = e.target.dataset.name;
        const price = parseFloat(e.target.dataset.price);
        const image = e.target.dataset.image;
        const cart = getCart();
        if (cart[id]) cart[id].quantity++;
        else cart[id] = { name, price, image, quantity: 1 };
        saveCart(cart);
        renderCart();
      });
    });

    // Vaciar carrito
    document.getElementById('clear-cart').addEventListener('click', ()=>{
      localStorage.removeItem(CART_KEY);
      renderCart();
    });
  });
</script>
@endsection
