@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto my-10">
  <h2 class="text-2xl font-bold mb-4">Tu Carrito</h2>
  <div id="cart-items" class="space-y-4"></div>
  
  <div class="flex justify-between items-center mt-6">
    <h3 class="text-xl font-semibold">Total: $<span id="cart-total">0.00</span></h3>
    <div class="flex space-x-4">
      <button id="clear-cart" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">
        Vaciar Carrito
      </button>
      <a href="{{ route('webpay.pagar') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Pagar con Webpay
      </a>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@endsection
