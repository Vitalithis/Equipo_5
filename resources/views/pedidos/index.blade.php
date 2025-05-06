@extends('dashboard')

@section('title', 'Gestión de Pedidos')

@section('default-content')
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-efore rounded shadow">
    <h1 class="text-3xl font-bold text-eprimary mb-6">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-eaccent2-100 text-eprimary border-l-4 border-eaccent2-400 px-4 py-3 rounded mb-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-efore-100 rounded-lg shadow">
            <table class="min-w-full divide-y divide-efore-300 text-sm">
                <thead class="bg-eaccent2-100 text-eprimary uppercase text-left">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Usuario</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Estado actual</th>
                        <th class="px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore-300 text-gray-800">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-eaccent2-50 transition">
                            <td class="px-6 py-4">{{ $pedido->id }}</td>
                            <td class="px-6 py-4">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @include('pedidos.estado_form', ['pedido' => $pedido])
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="toggleDetalles({{ $pedido->id }})"
                                        class="flex items-center justify-center w-8 h-8 text-eaccent2 hover:text-eaccent2-400 transition">
                                    <svg id="arrow-{{ $pedido->id }}" class="w-5 h-5 transform transition-transform duration-300"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @include('pedidos.detalles', ['pedido' => $pedido])
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-eprimary mt-6">No hay pedidos registrados.</p>
    @endif
</div>

<script>
function toggleDetalles(id) {
    const detalles = document.getElementById('detalles-' + id);
    const arrow = document.getElementById('arrow-' + id);
    const isOpen = detalles.classList.contains('max-h-[500px]');

    if (isOpen) {
        detalles.classList.remove('max-h-[500px]', 'opacity-100');
        detalles.classList.add('max-h-0', 'opacity-0');
        arrow.classList.remove('rotate-180');
    } else {
        detalles.classList.remove('max-h-0', 'opacity-0');
        detalles.classList.add('max-h-[500px]', 'opacity-100');
        arrow.classList.add('rotate-180');
    }
}
</script>
@endsection
