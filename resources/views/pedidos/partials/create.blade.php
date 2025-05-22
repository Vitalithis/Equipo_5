@extends('dashboard')

@section('title', 'Crear Pedido')
@section('default-content')
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 bg-white rounded-2xl shadow-xl">
    <h2 class="text-4xl font-extrabold text-eprimary mb-8 text-center">Nueva Venta</h2>

    <div class="mb-6">
        <a href="{{ route('pedidos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-eprimary font-semibold rounded-lg shadow-sm transition">
            ← Volver a la lista de pedidos

        </a>

    </div>
        <form action="{{ route('pedidos.store') }}" method="POST" id="pedido-form">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Método de entrega -->
            <div>
                <label for="metodo-entrega" class="block text-sm font-semibold text-gray-700 mb-1">Método de Entrega</label>
                <select name="metodo_entrega" id="metodo-entrega" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" required>
                    <option value="retiro">Retiro en tienda</option>
                    <option value="domicilio">Entrega a domicilio</option>
                </select>
            </div>

            <!-- Estado del pedido -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Estado del Pedido</label>
                <select name="estado_pedido" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" required>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_preparacion">En preparación</option>
                    <option value="entregado">Entregado</option>
                </select>
            </div>
        </div>

        <!-- Dirección si es domicilio -->
        <div id="direccion-contenedor" class="mt-6 hidden">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Dirección de entrega</label>
            <textarea name="direccion_entrega" rows="3" class="w-full rounded-lg border border-gray-300 py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" placeholder="Ej: Calle 123, Depto 4B, Comuna..."></textarea>
        </div>
        
        <h3 class="text-2xl font-semibold text-eprimary mt-10 mb-4">Detalle del Pedido</h3>

        <div id="detalle-container" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end relative">
                <div class="relative">
                    <label class="text-sm text-gray-700">Producto</label>
                    <input type="text" class="producto-nombre w-full rounded-md border-gray-300 shadow-sm" placeholder="Buscar producto..." autocomplete="off" required>
                    <input type="hidden" name="producto_id[]" class="producto-id">
                    <ul class="sugerencias absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-40 overflow-y-auto hidden z-10"></ul>
                </div>

                <div>
                    <label class="text-sm text-gray-700">Cantidad</label>
                    <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border-gray-300 shadow-sm" min="1" value="1" required>
                </div>

                <div>
                    <label class="text-sm text-gray-700">Precio Unitario</label>
                    <input type="number" name="precio_unitario[]" step="0.01" class="precio-input w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                </div>

                <div>
                    <label class="text-sm text-gray-700">Subtotal</label>
                    <input type="number" step="0.01" class="subtotal-input w-full rounded-md border-gray-300 shadow-sm bg-gray-100" readonly>
                </div>

                <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded hidden">🗑</button>
            </div>
        </div>

        <div class="text-right mt-6">
            <button type="button" id="add-detalle" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">
                + Agregar Producto
            </button>
        </div>
        
        <!-- Descuento porcentual -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Descuento (%)</label>
            <input type="number" name="descuento_porcentaje" min="0" max="100" step="0.01"
                class="w-full rounded-lg border border-gray-300 py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50"
                placeholder="Ej: 10">
            <small class="text-gray-500">Ingresa un número entre 0 y 100. Ej: 10 para 10% de descuento.</small>
        </div>
        <!-- Forma de pago -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Forma de Pago</label>
            <select name="forma_pago" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" required>
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta</option>
                <option value="transferencia">Transferencia</option>
            </select>
        </div>

                <!-- Estado de pago -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Estado del Pago</label>
            <select name="estado_pago" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" required>
                <option value="pendiente">Pendiente</option>
                <option value="pagado">Pagado</option>
                <option value="parcial">Parcial</option>
                <option value="reembolsado">Reembolsado</option>
            </select>
        </div>

        <!-- Monto Pagado -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Monto Pagado</label>
            <input type="number" step="0.01" name="monto_pagado" class="w-full rounded-lg border border-gray-300 py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50">
        </div>

        <!-- Tipo de Documento -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tipo de Documento</label>
            <select name="tipo_documento" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" required>
                <option value="boleta">Boleta</option>
                <option value="factura">Factura</option>
            </select>
        </div>


        <!-- Observaciones -->
        <div class="mt-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones</label>
            <textarea name="observaciones" rows="3" class="w-full rounded-lg border border-gray-300 py-2 px-4 shadow-sm focus:border-eprimary focus:ring focus:ring-eprimary/50" placeholder="Opcional"></textarea>
        </div>

        <div class="text-center mt-10">
            <button type="submit" class="bg-eprimary hover:bg-eprimary-dark text-white font-bold py-3 px-8 rounded-xl shadow transition transform hover:scale-105">
                Guardar Pedido
            </button>
        </div>
    </form>
</div>

<script>
    const productos = @json($productos);

    document.addEventListener('DOMContentLoaded', () => {
        const metodoSelect = document.getElementById('metodo-entrega');
        const direccionContenedor = document.getElementById('direccion-contenedor');

        metodoSelect.addEventListener('change', () => {
            direccionContenedor.classList.toggle('hidden', metodoSelect.value !== 'domicilio');
        });

        function configurarBuscadores() {
            document.querySelectorAll('.producto-nombre').forEach((input) => {
                const contenedor = input.closest('.relative');
                const hiddenId = contenedor.querySelector('.producto-id');
                const lista = contenedor.querySelector('.sugerencias');

                function mostrarResultados(texto) {
                    const filtrados = texto ? productos.filter(p => p.nombre.toLowerCase().includes(texto)).slice(0, 10) : productos.slice(0, 20);

                    lista.innerHTML = '';
                    filtrados.forEach(producto => {
                        const li = document.createElement('li');
                        li.textContent = producto.nombre;
                        li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';
                        li.addEventListener('click', () => {
                            input.value = producto.nombre;
                            hiddenId.value = producto.id;
                            lista.classList.add('hidden');

                            const fila = input.closest('.grid');
                            if (fila) {
                                const precio = fila.querySelector('.precio-input');
                                const cantidad = fila.querySelector('.cantidad-input');
                                const subtotal = fila.querySelector('.subtotal-input');

                                precio.value = parseFloat(producto.precio).toFixed(2);
                                subtotal.value = (cantidad.value * producto.precio).toFixed(2);
                            }
                        });
                        lista.appendChild(li);
                    });
                    lista.classList.remove('hidden');
                }

                input.addEventListener('input', () => {
                    mostrarResultados(input.value.toLowerCase());
                });

                input.addEventListener('focus', () => {
                    mostrarResultados(input.value.toLowerCase());
                });

                input.addEventListener('blur', () => {
                    setTimeout(() => lista.classList.add('hidden'), 150);
                });
            });
        }

        function bindEvents(row) {
            row.querySelector('.cantidad-input').addEventListener('input', () => {
                const precio = parseFloat(row.querySelector('.precio-input').value || 0);
                const cantidad = parseInt(row.querySelector('.cantidad-input').value || 1);
                row.querySelector('.subtotal-input').value = (precio * cantidad).toFixed(2);
            });

            const removeBtn = row.querySelector('.remove-row');
            removeBtn.addEventListener('click', () => row.remove());

            if (document.querySelectorAll('#detalle-container .grid').length > 1) {
                removeBtn.classList.remove('hidden');
            } else {
                removeBtn.classList.add('hidden');
            }
        }

        document.querySelectorAll('#detalle-container .grid').forEach(row => {
            bindEvents(row);
        });

        configurarBuscadores();

        document.getElementById('add-detalle').addEventListener('click', () => {
            const container = document.getElementById('detalle-container');
            const firstRow = container.querySelector('.grid');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelectorAll('input').forEach(input => {
                if (!input.classList.contains('producto-id')) input.value = '';
                if (input.classList.contains('cantidad-input')) input.value = 1;
            });

            container.appendChild(newRow);
            bindEvents(newRow);
            configurarBuscadores();
        });
    });
    // aaaaaaaaaaaaaaa
document.getElementById('pedido-form').addEventListener('submit', function(e) {
    const productosIds = document.querySelectorAll('.producto-id');
    let valido = true;

    productosIds.forEach(id => {
        if (!id.value) {
            valido = false;
        }
    });

    if (!valido) {
        alert('Debes seleccionar los productos desde la lista desplegable. No escribas el nombre manualmente.');
        e.preventDefault();
    }
});

</script>
@endsection
