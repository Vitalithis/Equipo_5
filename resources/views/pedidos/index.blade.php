@extends('dashboard')

@section('title', 'Gestión de Pedidos')

@section('default-content')
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-8 py-10 bg-efore rounded-xl shadow-lg">
    <h1 class="text-4xl font-extrabold text-eprimary mb-8 text-center">Gestión de Pedidos</h1>

   @if (session('success'))
        <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif


    @if ($pedidos->count())
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">
                @include('pedidos.partials.table-header')
                <tbody class="divide-y divide-efore">
                    @foreach ($pedidos as $pedido)
                        @include('pedidos.partials.table-row', ['pedido' => $pedido])
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    @endif
</div>

@include('pedidos.partials.modals')
@include('pedidos.partials.scripts')

@endsection
