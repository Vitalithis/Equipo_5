@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto my-10">
  <h2 class="text-2xl font-bold mb-4">Tu Carrito</h2>
  <div id="cart-items" class="space-y-4"></div>
  <div class="flex justify-between items-center mt-6">
    <h3 class="text-xl font-semibold">Total: $<span id="cart-total">0</span></h3>
    <button id="clear-cart" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">Vaciar Carrito</button>
  </div>
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
