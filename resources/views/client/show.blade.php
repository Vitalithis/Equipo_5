@extends('layouts.dashboard')

@section('title', 'Cliente')

@section('content')
<div class="max-w-2xl mx-auto py-8 font-['Roboto'] text-gray-800">
    <h1 class="text-2xl font-bold mb-4">Cliente:</h1>

    <p><strong>Subdominio:</strong> {{ $cliente->domains->first()->domain ?? '-' }}</p>
    <p><strong>Slug:</strong> {{ $cliente->id }}</p>
    <p><strong>Estado:</strong>
        @if ($cliente->data['activo'] ?? false)
            <span class="text-green-600">Activo</span>
        @else
            <span class="text-red-600">Inactivo</span>
        @endif
    </p>
    <p><strong>Creado en:</strong> {{ $cliente->created_at->format('d/m/Y H:i') }}</p>
    <p><strong>Última actualización:</strong> {{ $cliente->updated_at->format('d/m/Y H:i') }}</p>

    <div class="mt-4">
        <a href="{{ route('clients.index') }}" class="text-blue-600 hover:underline">
            ← Volver a la lista de clientes
        </a>
    </div>
</div>
@endsection
