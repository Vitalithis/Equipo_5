@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Resumen de tu Compra</h2>

    <p>Total: ${{ number_format(session('cart') ? array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart'))) : 0, 0, ',', '.') }}</p>

    <form action="{{ route('checkout.pay') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="amount" value="{{ session('cart') ? array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart'))) : 0 }}">
        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Pagar con Transbank
        </button>
    </form>
</div>
@endsection
