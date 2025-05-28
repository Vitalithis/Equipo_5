@extends('layouts.dashboard')

@section('title', 'Código QR para ' . $cuidado->producto->nombre)

@section('content')
<div class="p-6 flex flex-col items-center justify-center min-h-[60vh]">
    <h1 class="text-2xl font-bold mb-6">Código QR para {{ $cuidado->producto->nombre }}</h1>
    <div>{!! $qr !!}</div>

    <p class="mt-4 text-gray-700 text-center max-w-md">
        Escanea este código QR para abrir el PDF con los cuidados de la planta.
    </p>
</div>
@endsection
