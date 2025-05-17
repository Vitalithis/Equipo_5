@extends('dashboard')

@section('title', 'Crear Pedido')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-8 bg-white rounded-xl shadow">
    <h2 class="text-2xl font-bold text-eprimary mb-6 text-center">Nuevo Pedido</h2>

    <form action="{{ route('pedidos.store') }}" method="POST" id="pedido-form">
        @csrf

        <!-- Método de entrega -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Método de Entrega</label>
            <select name="metodo_entrega" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-eprimary focus:border-eprimary" required>
                <option value="domicilio">Domicilio</option>
                <option value="retiro">Retiro</option>
            </select>
        </div>

        <!-- Estado del pedido -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700">Estado del Pedido</label>
            <select name="estado_pedido" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-eprimary focus:border-eprimary" required>
                <option value="pendiente">Pendiente</option>
                <option value="en_preparacion">En preparación</option>
                <option value="entregado">Entregado</option>
            </select>
        </div>

        <h3 class="text-lg font-semibold text-gray-700 mb-2">Detalle del Pedido</h3>

        <div id="detalle-container" class="space-y-4">
            <div class="grid grid-cols-5 gap-4 items-end">
                <div>
                    <label class="text-sm text-gray-600">Producto</label>
                    <select name="producto_id[]" class="producto-select w-full rounded-md border-gray-300 shadow-sm" required>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->precio }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Cantidad</label>
                    <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border-gray-300 shadow-sm" min="1" value="1" required>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Precio Unitario</label>
                    <input type="number" name="precio_unitario[]" step="0.01" class="precio-input w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Subtotal</label>
                    <input type="number" step="0.01" class="subtotal-input w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                </div>

                <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded hidden">🗑</button>
            </div>
        </div>

        <!-- Botón para agregar fila -->
        <div class="text-right mt-4">
            <button type="button" id="add-detalle" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
                + Agregar Producto
            </button>
        </div>

        <!-- Botón guardar -->
        <div class="text-center mt-8">
            <button type="submit" class="bg-eprimary hover:bg-eprimary-dark text-white font-bold py-2 px-6 rounded shadow">
                Guardar Pedido
            </button>
        </div>
    </form>
</div>

<script>
    function actualizarPreciosYSubtotales(row) {
        const productoSelect = row.querySelector('.producto-select');
        const cantidadInput = row.querySelector('.cantidad-input');
        const precioInput = row.querySelector('.precio-input');
        const subtotalInput = row.querySelector('.subtotal-input');

        const precio = parseFloat(productoSelect.selectedOptions[0].dataset.precio || 0);
        const cantidad = parseInt(cantidadInput.value || 1);

        precioInput.value = precio.toFixed(2);
        subtotalInput.value = (precio * cantidad).toFixed(2);
    }

    function bindEvents(row) {
        row.querySelector('.producto-select').addEventListener('change', () => actualizarPreciosYSubtotales(row));
        row.querySelector('.cantidad-input').addEventListener('input', () => actualizarPreciosYSubtotales(row));

        const removeBtn = row.querySelector('.remove-row');
        removeBtn.addEventListener('click', () => {
            row.remove();
        });

        if (document.querySelectorAll('#detalle-container .grid').length > 1) {
            removeBtn.classList.remove('hidden');
        } else {
            removeBtn.classList.add('hidden');
        }
    }

    document.querySelectorAll('#detalle-container .grid').forEach(bindEvents);

    document.getElementById('add-detalle').addEventListener('click', () => {
        const container = document.getElementById('detalle-container');
        const firstRow = container.querySelector('.grid');
        const newRow = firstRow.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = (input.classList.contains('cantidad-input')) ? 1 : '';
        });

        container.appendChild(newRow);
        bindEvents(newRow);
        actualizarPreciosYSubtotales(newRow);
    });

    document.querySelectorAll('.producto-select').forEach(select => {
        const row = select.closest('.grid');
        actualizarPreciosYSubtotales(row);
    });
</script>
@endsection
