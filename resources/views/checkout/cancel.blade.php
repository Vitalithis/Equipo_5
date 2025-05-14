@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded text-center">
    <h2 class="text-2xl font-bold text-red-600 mb-4">Pago Cancelado</h2>
    <p>Tu pago fue cancelado o falló. Puedes intentar nuevamente.</p>
    <a href="{{ route('cart.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Volver al carrito</a>
</div>
@endsection