@extends('layouts.dashboard')

@section('title', 'Nuevo proveedor')

@section('content')
@php
    $pref = Auth::user()?->preference;
@endphp
<style>
    :root {
        --table-header-color: {{ $pref?->table_header_color ?? '#0a2b59' }};
        --table-header-text-color: {{ $pref?->table_header_text_color ?? '#FFFFFF' }};
    }
</style>
<div class="py-8 px-4 md:px-8 max-w-4xl mx-auto font-['Roboto'] text-gray-800">
<a href="{{ route('proveedores.index') }}"
   class="mb-6 inline-flex items-center text-white border px-3 py-1 rounded transition-colors"
   style="background-color: var(--table-header-color); border-color: var(--table-header-color);">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="m15 18-6-6 6-6"/>
    </svg>
    Volver a la lista
</a>


    <form method="POST" action="{{ route('proveedores.store') }}" class="space-y-6">
        @csrf

        @include('proveedores.form-fields')
        
        <div class="flex justify-end space-x-4 mt-4">
            <a href="{{ route('proveedores.index') }}"
               class="px-4 py-2 border border-gray-400 text-sm text-gray-700 bg-white rounded hover:bg-gray-100 transition">
                Cancelar
            </a>
            <button type="submit"
                    class="px-6 py-2 text-white rounded transition"
                    style="background-color: var(--table-header-color);">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
