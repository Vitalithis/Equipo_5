// resources/js/app.js

import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// ================= Carrito de Compras =================

// Clave para almacenar en localStorage
const CART_KEY = 'mi_carrito';

// Funciones de gestión del carrito
function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY) || '{}');
}
function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
}
function renderCart() {
  const cart = getCart();
  const container = document.getElementById('cart-items');
  if (!container) return;
  container.innerHTML = '';
  let total = 0;
  Object.values(cart).forEach(item => {
    const sub = item.precio * item.cantidad;
    total += sub;
    const div = document.createElement('div');
    div.className = 'flex items-center justify-between bg-white p-4 rounded shadow';
    div.innerHTML = `
      <div class="flex items-center space-x-4">
        <img src="/storage/${item.imagen}" class="w-12 h-12 object-cover rounded">
        <div>
          <h4 class="font-semibold">${item.nombre}</h4>
          <p class="text-sm text-gray-600">$${item.precio.toFixed(2)} c/u</p>
        </div>
      </div>
      <div class="flex items-center space-x-2">
        <button class="px-2 bg-gray-200 rounded decrement" data-id="${item.id}">−</button>
        <span>${item.cantidad}</span>
        <button class="px-2 bg-gray-200 rounded increment" data-id="${item.id}">+</button>
        <button class="ml-4 text-red-500 remove" data-id="${item.id}">Eliminar</button>
      </div>
      <div class="ml-4 font-semibold">$${sub.toFixed(2)}</div>
    `;
    container.appendChild(div);
  });
  const totalEl = document.getElementById('cart-total');
  if (totalEl) totalEl.innerText = total.toFixed(2);

  // Listeners para botones
  document.querySelectorAll('.increment').forEach(btn => {
    btn.onclick = () => updateQty(btn.dataset.id, +1);
  });
  document.querySelectorAll('.decrement').forEach(btn => {
    btn.onclick = () => updateQty(btn.dataset.id, -1);
  });
  document.querySelectorAll('.remove').forEach(btn => {
    btn.onclick = () => removeItem(btn.dataset.id);
  });
}

function updateQty(id, delta) {
  const cart = getCart();
  if (!cart[id]) return;
  cart[id].cantidad += delta;
  if (cart[id].cantidad < 1) delete cart[id];
  saveCart(cart);
  renderCart();
}

function removeItem(id) {
  const cart = getCart();
  delete cart[id];
  saveCart(cart);
  renderCart();
}

// Inicialización al cargar DOM
document.addEventListener('DOMContentLoaded', () => {
  renderCart();

  // Botones "Agregar al carrito"
  document.querySelectorAll('.add-to-cart').forEach(btn => {
    btn.onclick = () => {
      const id       = btn.dataset.id;
      const cantidad = parseInt(btn.dataset.cantidad) || 1;
      const nombre   = btn.closest('div').querySelector('h3').innerText;
      const precio   = parseFloat(btn.closest('div').querySelector('p').innerText.replace('$', ''));
      const imagen   = btn.dataset.imagen || '';
      const cart     = getCart();
      const item     = { id, nombre, precio, imagen, cantidad };

      if (cart[id]) {
        cart[id].cantidad += cantidad;
      } else {
        cart[id] = item;
      }

      saveCart(cart);
      renderCart();
    };
  });

  // Botón "Vaciar carrito"
  const clearBtn = document.getElementById('clear-cart');
  if (clearBtn) {
    clearBtn.onclick = () => {
      localStorage.removeItem(CART_KEY);
      renderCart();
    };
  }
});
