@extends('layouts.app')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
  @foreach($productos as $p)
    <div class="bg-white p-4 rounded shadow">
      <img src="{{ asset('storage/'.$p->imagen) }}" class="w-full h-40 object-cover rounded">
      <h3 class="font-bold mt-2">{{ $p->nombre }}</h3>
      <p class="text-gray-600">${{ number_format($p->precio,2) }}</p>
      <button 
        class="add-to-cart mt-2 bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded"
        data-id="{{ $p->id }}"
        data-cantidad="1"
      >Agregar</button>
    </div>
  @endforeach
</div>
@endsection
