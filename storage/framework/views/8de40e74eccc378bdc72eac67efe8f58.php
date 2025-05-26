<?php $__env->startSection('title', isset($pedido->id) ? 'Editar Venta' : 'Nueva Venta'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-5xl mx-auto">

    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('pedidos.index')); ?>" class="flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6" />
            </svg>
            Volver a la lista
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 ml-auto">
            <?php echo e(isset($pedido->id) ? 'Editar' : 'Nueva'); ?> Venta
        </h1>
    </div>

    <form action="<?php echo e(isset($pedido->id) ? route('pedidos.update', $pedido->id) : route('pedidos.store')); ?>"
        method="POST" id="pedido-form" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php if(isset($pedido->id)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Información de la Venta</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="metodo-entrega" class="block text-sm font-medium text-gray-700 mb-1">
                        Método de Entrega <span class="text-red-500">*</span>
                    </label>
                    <select name="metodo_entrega" id="metodo-entrega"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                        <option value="retiro" <?php echo e((old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'retiro') ? 'selected' : ''); ?>>
                            Retiro en tienda
                        </option>
                        <option value="domicilio" <?php echo e((old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'domicilio') ? 'selected' : ''); ?>>
                            Entrega a domicilio
                        </option>
                    </select>
                </div>

                <div>
                    <label for="estado_pedido" class="block text-sm font-medium text-gray-700 mb-1">
                        Estado del Pedido <span class="text-red-500">*</span>
                    </label>
                    <select name="estado_pedido"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                        required>
                        <option value="pendiente" <?php echo e((old('estado_pedido', $pedido->estado_pedido ?? '') == 'pendiente') ? 'selected' : ''); ?>>
                            Pendiente
                        </option>
                        <option value="en_preparacion" <?php echo e((old('estado_pedido', $pedido->estado_pedido ?? '') == 'en_preparacion') ? 'selected' : ''); ?>>
                            En preparación
                        </option>
                        <option value="entregado" <?php echo e((old('estado_pedido', $pedido->estado_pedido ?? '') == 'entregado') ? 'selected' : ''); ?>>
                            Entregado
                        </option>
                    </select>
                </div>
            </div>

            <div id="direccion-contenedor" class="mt-6 <?php echo e((old('metodo_entrega', $pedido->metodo_entrega ?? '') == 'domicilio') ? '' : 'hidden'); ?>">
                <label for="direccion_entrega" class="block text-sm font-medium text-gray-700 mb-1">Dirección de entrega</label>
                <textarea name="direccion_entrega" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Ej: Calle 123, Depto 4B, Comuna..."><?php echo e(old('direccion_entrega', $pedido->direccion_entrega ?? '')); ?></textarea>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-medium text-gray-800 mb-4 pb-2 border-b border-gray-200">Detalle del Pedido</h2>

            <div id="detalle-container" class="space-y-4">
                <?php if(isset($pedido) && $pedido->detalles->count() > 0): ?>
                    <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end relative">
                        <div class="relative">
                            <label class="text-sm text-gray-700">Producto</label>
                            <input type="text" class="producto-nombre w-full rounded-md border border-gray-300 shadow-sm"
                                placeholder="Buscar producto..." autocomplete="off" required
                                value="<?php echo e(old('producto_nombre', $detalle->nombre_producto_snapshot)); ?>">
                            <input type="hidden" name="producto_id[]" class="producto-id" value="<?php echo e(old('producto_id[]', $detalle->producto_id)); ?>">
                            <ul class="sugerencias absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-40 overflow-y-auto hidden z-10"></ul>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border border-gray-300 shadow-sm"
                                min="1" value="<?php echo e(old('cantidad[]', $detalle->cantidad)); ?>" required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Precio Unitario</label>
                            <input type="number" name="precio_unitario[]" step="0.01"
                                class="precio-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly
                                value="<?php echo e(old('precio_unitario[]', $detalle->precio_unitario)); ?>">
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Subtotal</label>
                            <input type="number" step="0.01"
                                class="subtotal-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly
                                value="<?php echo e(old('subtotal[]', $detalle->subtotal)); ?>">
                        </div>

                        <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded hidden">🗑</button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end relative">
                        <div class="relative">
                            <label class="text-sm text-gray-700">Producto</label>
                            <input type="text" class="producto-nombre w-full rounded-md border border-gray-300 shadow-sm"
                                placeholder="Buscar producto..." autocomplete="off" required>
                            <input type="hidden" name="producto_id[]" class="producto-id">
                            <ul class="sugerencias absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-40 overflow-y-auto hidden z-10"></ul>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Cantidad</label>
                            <input type="number" name="cantidad[]" class="cantidad-input w-full rounded-md border border-gray-300 shadow-sm"
                                min="1" value="1" required>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Precio Unitario</label>
                            <input type="number" name="precio_unitario[]" step="0.01"
                                class="precio-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>

                        <div>
                            <label class="text-sm text-gray-700">Subtotal</label>
                            <input type="number" step="0.01"
                                class="subtotal-input w-full rounded-md border border-gray-300 shadow-sm bg-gray-100" readonly>
                        </div>

                        <button type="button" class="remove-row bg-red-500 text-white px-2 py-1 rounded hidden">🗑</button>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-right mt-6">
                <button type="button" id="add-detalle"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded shadow">+ Agregar Producto</button>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 space-y-6">
            <div>
                <label for="descuento_porcentaje" class="block text-sm font-medium text-gray-700 mb-1">Descuento (%)</label>
                <input type="number" name="descuento_porcentaje" min="0" max="100" step="0.01"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Ej: 10" value="<?php echo e(old('descuento_porcentaje', isset($pedido) ? round(($pedido->descuento / max($pedido->subtotal, 1)) * 100, 2) : '')); ?>">
                <small class="text-gray-500">Ingresa un número entre 0 y 100. Ej: 10 para 10% de descuento.</small>
            </div>

            <div>
                <label for="forma_pago" class="block text-sm font-medium text-gray-700 mb-1">Forma de Pago</label>
                <select name="forma_pago"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="efectivo" <?php echo e(old('forma_pago', $pedido->forma_pago ?? '') == 'efectivo' ? 'selected' : ''); ?>>Efectivo</option>
                    <option value="tarjeta" <?php echo e(old('forma_pago', $pedido->forma_pago ?? '') == 'tarjeta' ? 'selected' : ''); ?>>Tarjeta</option>
                    <option value="transferencia" <?php echo e(old('forma_pago', $pedido->forma_pago ?? '') == 'transferencia' ? 'selected' : ''); ?>>Transferencia</option>
                </select>
            </div>

            <div>
                <label for="estado_pago" class="block text-sm font-medium text-gray-700 mb-1">Estado del Pago</label>
                <select name="estado_pago"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="pendiente" <?php echo e(old('estado_pago', $pedido->estado_pago ?? '') == 'pendiente' ? 'selected' : ''); ?>>Pendiente</option>
                    <option value="pagado" <?php echo e(old('estado_pago', $pedido->estado_pago ?? '') == 'pagado' ? 'selected' : ''); ?>>Pagado</option>
                    <option value="parcial" <?php echo e(old('estado_pago', $pedido->estado_pago ?? '') == 'parcial' ? 'selected' : ''); ?>>Parcial</option>
                    <option value="reembolsado" <?php echo e(old('estado_pago', $pedido->estado_pago ?? '') == 'reembolsado' ? 'selected' : ''); ?>>Reembolsado</option>
                </select>
            </div>

            <div>
                <label for="monto_pagado" class="block text-sm font-medium text-gray-700 mb-1">Monto Pagado</label>
                <input type="number" step="0.01" name="monto_pagado"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    value="<?php echo e(old('monto_pagado', $pedido->monto_pagado ?? '')); ?>">
            </div>

            <div>
                <label for="tipo_documento" class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                <select name="tipo_documento"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    required>
                    <option value="boleta" <?php echo e(old('tipo_documento', $pedido->tipo_documento ?? '') == 'boleta' ? 'selected' : ''); ?>>Boleta</option>
                    <option value="factura" <?php echo e(old('tipo_documento', $pedido->tipo_documento ?? '') == 'factura' ? 'selected' : ''); ?>>Factura</option>
                </select>
            </div>

            <div>
                <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                <textarea name="observaciones" rows="3"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                    placeholder="Opcional"><?php echo e(old('observaciones', $pedido->observaciones ?? '')); ?></textarea>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="<?php echo e(route('pedidos.index')); ?>"
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                Cancelar
            </a>
            <button type="submit"
                class="group relative px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                <?php echo e(isset($pedido->id) ? 'Actualizar' : 'Guardar'); ?> Pedido
            </button>
        </div>
    </form>
</div>

<script>
    const productos = <?php echo json_encode($productos, 15, 512) ?>;

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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/pedidos/partials/create.blade.php ENDPATH**/ ?>