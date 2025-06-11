@extends('layouts.dashboard')

@section('title', 'Detalle del Cliente')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Cliente: {{ $cliente->nombre }}</h2>

    <div class="mb-4">
        <p><strong>Subdominio:</strong> {{ $cliente->subdominio }}.plantaseditha.me</p>
        <p><strong>Slug:</strong> {{ $cliente->slug }}</p>
        <p><strong>Estado:</strong>
            @if ($cliente->activo)
                <span class="text-green-600 font-semibold">Activo</span>
            @else
                <span class="text-red-600 font-semibold">Inactivo</span>
            @endif
        </p>
        <p><strong>Creado en:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última actualización:</strong> {{ $cliente->updated_at->format('d/m/Y H:i') }}</p>
    </div>

    <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">
        ← Volver a la lista de clientes
    </a>
</div>
@endsection
