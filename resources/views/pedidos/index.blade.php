@extends('dashboard')

@section('title', 'Gestión de Pedidos')

@section('default-content')
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-8 py-10 bg-efore rounded-xl shadow-lg">
    <h1 class="text-4xl font-extrabold text-eprimary mb-8 text-center">Gestión de Pedidos</h1>

    @if (session('success'))
        <div class="bg-[#FFF9DB] border-l-4 border-yellow-300 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-efore">
                    @foreach ($pedidos as $pedido)
                        <tr class="hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles({{ $pedido->id }})">
                            <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center text-gray-900">
                                @include('pedidos.estado_form', ['pedido' => $pedido])
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="icon-{{ $pedido->id }}" class="inline-block">
                                    <!-- SVG inicial: plus -->
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
                                        <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
                                    </svg>
                                </span>
                            </td>
                        </tr>
                        @include('pedidos.detalles', ['pedido' => $pedido])
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    @endif
</div>

<script>
function toggleDetalles(id) {
    const detalles = document.getElementById('detalles-' + id);
    const iconSpan = document.getElementById('icon-' + id);
    const isOpen = detalles.classList.contains('max-h-[500px]');

    const minusSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
            <path d="M3.75 7.25a.75.75 0 0 0 0 1.5h8.5a.75.75 0 0 0 0-1.5h-8.5Z" />
        </svg>`;

    const plusSVG = `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-5 h-5 text-eprimary">
            <path d="M8.75 3.75a.75.75 0 0 0-1.5 0v3.5h-3.5a.75.75 0 0 0 0 1.5h3.5v3.5a.75.75 0 0 0 1.5 0v-3.5h3.5a.75.75 0 0 0 0-1.5h-3.5v-3.5Z" />
        </svg>`;

    if (isOpen) {
        detalles.classList.remove('max-h-[500px]', 'opacity-100');
        detalles.classList.add('max-h-0', 'opacity-0');
        iconSpan.innerHTML = plusSVG;
    } else {
        detalles.classList.remove('max-h-0', 'opacity-0');
        detalles.classList.add('max-h-[500px]', 'opacity-100');
        iconSpan.innerHTML = minusSVG;
    }
}
</script>
@endsection
