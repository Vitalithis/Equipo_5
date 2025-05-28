@extends('layouts.dashboard')

@section('title', 'Gestión de Pedidos')

@section('content')
{{-- Tipografía --}}
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="max-w-7xl mx-auto px-8 py-10 font-['Roboto'] text-gray-800">
    @if (session('success'))
        <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold font-['Roboto_Condensed'] text-gray-800">Ventas</h2>
        <a href="{{ route('pedidos.create') }}"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Añadir Venta
        </a>
    </div>

    @if ($pedidos->count())
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">

                <!-- Seccion Tabla header -->
                <thead class="bg-eaccent2 text-eprimary uppercase tracking-wide text-xs font-['Roboto_Condensed']">
                    <tr>
                        <th class="px-6 py-4 text-center">ID</th>
                        <th class="px-6 py-4 text-center">Usuario</th>
                        <th class="px-6 py-4 text-center">Total</th>
                        <th class="px-6 py-4 text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <!--Table-row -->
                <tbody class="font-['Roboto']">
                    @foreach ($pedidos as $pedido)
                        <tr class="border-b border-eaccent2 hover:bg-efore transition duration-200 cursor-pointer" onclick="toggleDetalles({{ $pedido->id }}, event)">
                            <td class="px-6 py-4 text-center font-bold text-eprimary">{{ $pedido->id }}</td>
                            <td class="px-6 py-4 text-center">{{ $pedido->usuario->name }}</td>
                            <td class="px-6 py-4 text-center">${{ number_format($pedido->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                @include('pedidos.partials.estado_form', ['pedido' => $pedido])
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('pedidos.edit', $pedido->id) }}" class="text-blue-600 hover:underline">
                                    Editar
                                </a>
                                <button type="button" class="text-red-600 hover:underline ml-2"
                                    onclick="openDeleteModal({{ $pedido->id }}, 'Pedido #{{ $pedido->id }}')">
                                    Eliminar
                                </button>
                            </td>
                        </tr>

                        <!-- Detalles pedido -->
                        <tr>
                            <td colspan="5" class="p-0">
                                <div id="detalles-{{ $pedido->id }}" class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
                                    <div class="p-6 space-y-4">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <p><strong class="text-eprimary">Método de entrega:</strong> {{ $pedido->metodo_entrega }}</p>
                                            <p><strong class="text-eprimary">Dirección:</strong> {{ $pedido->direccion_entrega ?? 'No disponible' }}</p>
                                            <p><strong class="text-eprimary">Fecha de pedido:</strong> {{ $pedido->created_at->format('d-m-Y H:i') }}</p>
                                        </div>

                                        <div>
                                            <p class="font-semibold text-eprimary mb-2">Productos:</p>
                                            <ul class="list-disc list-inside ml-4 space-y-1">
                                                @foreach ($pedido->detalles as $detalle)
                                                    <li>
                                                        <span>{{ $detalle->nombre_producto_snapshot }}</span>
                                                        <span class="text-gray-600">(x{{ $detalle->cantidad }}, ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}, Subtotal: ${{ number_format($detalle->subtotal, 0, ',', '.') }})</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <!-- Seleccion Boleta -->
                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-2">
                                                <strong class="text-eprimary">Boleta SII:</strong>
                                                @if($pedido->boleta_final_path)
                                                    <span class="text-green-600 font-medium">Subida</span>
                                                    <button class="open-modal-pdf text-esecondary hover:text-eaccent text-sm underline"
                                                            data-pdf="{{ asset('storage/' . $pedido->boleta_final_path) }}">
                                                        Ver PDF
                                                    </button>
                                                    <a href="{{ asset('storage/' . $pedido->boleta_final_path) }}"
                                                       target="_blank"
                                                       class="text-sm text-blue-600 hover:text-blue-800 underline ml-2">
                                                        Descargar
                                                    </a>
                                                @else
                                                    <span class="text-red-500 font-medium">No subida</span>
                                                @endif

                                                <button class="open-modal-upload text-eaccent hover:text-eaccent2 text-lg"
                                                        data-action="{{ route('boletas.subir', ['pedido' => $pedido->id]) }}">
                                                    📤
                                                </button>
                                            </div>
                                        </div>

                                        <div class="pt-2">
                                            <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                                                    data-url="{{ route('boletas.provisoria', $pedido->id) }}">
                                                Ver boleta provisoria
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    @endif
</div>

{{-- Modales --}}
@include('pedidos.partials.modals')
@include('pedidos.partials.scripts')

<script>
    // Abre/cierra detalles solo si no clickeaste en botones de acción (editar/eliminar/estado)
    function toggleDetalles(id, event) {
        if(event.target.closest('a, button, select, input, form')) {
            return; // No toggle si click fue en botón o select o formulario
        }

        const detalles = document.getElementById(`detalles-${id}`);
        if (!detalles) return;

        const isOpen = detalles.style.maxHeight && detalles.style.maxHeight !== '0px';

        document.querySelectorAll('[id^="detalles-"]').forEach(el => {
            el.style.maxHeight = '0px';
            el.style.opacity = '0';
        });

        if (!isOpen) {
            detalles.style.maxHeight = detalles.scrollHeight + 'px';
            detalles.style.opacity = '1';
        }
    }

    function openDeleteModal(id, nombre) {
        document.getElementById('modalProductName').textContent = nombre;
        document.getElementById('deleteForm').action = `/pedidos/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Función para abrir el modal de eliminación con la acción adecuada
    function openDeleteModal(id, nombre) {
        document.getElementById('modalProductName').textContent = nombre; // Mostrar nombre en el modal
        // Cambiar la acción del formulario al ID del pedido
        document.getElementById('deleteForm').action = `/pedidos/${id}`;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    // Función para cerrar el modal de eliminación
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    // Cerrar modal al hacer clic en el botón de cerrar
    document.getElementById('delete-modal-close').addEventListener('click', closeDeleteModal);


</script>

@endsection
