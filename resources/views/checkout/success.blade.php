@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow rounded text-center">
    <h2 class="text-2xl font-bold text-green-700 mb-4">¡Pago Exitoso!</h2>
    <p class="mb-2">Gracias por tu compra.</p>
    <p class="text-sm text-gray-600">Código de autorización: {{ $response->getAuthorizationCode() }}</p>
    <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:underline">Volver al inicio</a>
</div>
@endsection
