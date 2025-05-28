@extends('layouts.dashboard')

@section('title', 'Nuevo proveedor')

@section('content')
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto">
    <div class="flex items-center mb-6">
        <a href="{{ route('proveedores.index') }}" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 18-6-6 6-6"/>
            </svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">Nuevo proveedor</h1>
    </div>

    <form method="POST" action="{{ route('proveedores.store') }}" class="space-y-6">
        @csrf

        @include('proveedores.form-fields')
        
        <div class="flex justify-end space-x-4 mt-4">
            <a href="{{ route('proveedores.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50 transition">Cancelar</a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">Guardar</button>
        </div>
    </form>
</div>
@endsection
