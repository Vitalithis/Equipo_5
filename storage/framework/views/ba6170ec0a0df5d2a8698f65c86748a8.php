<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h2 class="text-3xl font-bold mb-8 text-[#486379] text-center">Tu Carrito</h2>

    <?php if(session('cart') && count(session('cart')) > 0): ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lista de productos -->
            <div class="lg:col-span-2 space-y-6">
                <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex flex-col sm:flex-row items-center bg-white shadow-md rounded-lg overflow-hidden p-4 gap-4">
                        <img src="<?php echo e($item['imagen']); ?>" alt="<?php echo e($item['nombre']); ?>" class="w-28 h-28 object-cover rounded-lg border">
                        <div class="flex-1 w-full">
                            <h3 class="text-lg font-semibold text-gray-900"><?php echo e($item['nombre']); ?></h3>
                            <p class="text-sm text-gray-500 mb-2">Precio: $<?php echo e(number_format($item['precio'], 0, ',', '.')); ?></p>

                            <div class="flex flex-col sm:flex-row items-center gap-3">
                                <form action="<?php echo e(route('cart.update', $id)); ?>" method="POST" class="flex items-center gap-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <input type="number" name="cantidad" value="<?php echo e($item['cantidad']); ?>" min="1"
                                        class="w-16 px-2 py-1 border rounded text-center">
                                    <button type="submit"
                                        class="px-3 py-1 text-white text-sm rounded"
                                        style="background-color: #70A37F;">
                                        Actualizar
                                    </button>
                                </form>
                                <form action="<?php echo e(route('cart.remove.solo', $id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="text-red-500 hover:underline text-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        <div class="text-right font-semibold text-gray-800">
                            $<?php echo e(number_format($item['precio'] * $item['cantidad'], 0, ',', '.')); ?>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- Descuento -->
                <div class="bg-gray-50 border rounded-lg p-4">
                    <h3 class="text-lg font-semibold mb-2 text-[#486379]">Aplicar Código de Descuento</h3>
                    <form action="<?php echo e(route('cart.aplicar-descuento')); ?>" method="POST" class="flex flex-col sm:flex-row gap-3">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="codigo" placeholder="Ingresa tu código"
                            class="flex-1 px-3 py-2 border rounded">
                        <button type="submit"
                            class="px-4 py-2 text-white rounded"
                            style="background-color: #79B473;">
                            Aplicar
                        </button>
                    </form>
                    <?php if(session('descuento_error')): ?>
                        <p class="mt-2 text-sm text-red-600"><?php echo e(session('descuento_error')); ?></p>
                    <?php endif; ?>
                    <?php if(session('descuento_aplicado')): ?>
                        <div class="mt-4 bg-green-100 border-l-4 border-green-500 p-3 text-green-800 rounded">
                            <p class="font-bold">Descuento aplicado:</p>
                            <p>
                                Código: <?php echo e(session('descuento_aplicado.codigo')); ?> -
                                <?php if(session('descuento_aplicado.tipo') === 'porcentaje'): ?>
                                    <?php echo e(session('descuento_aplicado.valor')); ?>% de descuento
                                <?php elseif(session('descuento_aplicado.tipo') === 'monto_fijo'): ?>
                                    $<?php echo e(number_format(session('descuento_aplicado.valor'), 0, ',', '.')); ?> de descuento
                                <?php else: ?>
                                    Envío gratis
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Resumen -->
            <div class="p-6 rounded-lg shadow-md sticky top-10" >
                <h3 class="text-xl font-bold mb-4 border-b pb-2 text-[#486379]">Resumen del Pedido</h3>
                <?php
                    $subtotal = array_sum(array_map(fn($i) => $i['precio'] * $i['cantidad'], session('cart', [])));
                    $descuentoTotal = 0;
                    if (session('descuento_aplicado')) {
                        foreach (session('cart', []) as $item) {
                            if (isset($item['precio_con_descuento'])) {
                                $descuentoTotal += ($item['precio'] - $item['precio_con_descuento']) * $item['cantidad'];
                            }
                        }
                    }
                    $total = $subtotal - $descuentoTotal;
                ?>

                <div class="space-y-2 text-sm text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span>$<?php echo e(number_format($subtotal, 0, ',', '.')); ?></span>
                    </div>
                    <?php if($descuentoTotal > 0): ?>
                        <div class="flex justify-between text-green-600 font-semibold">
                            <span>Descuento:</span>
                            <span>- $<?php echo e(number_format($descuentoTotal, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="flex justify-between text-lg font-bold border-t pt-2 mt-2">
                        <span>Total:</span>
                        <span>$<?php echo e(number_format($total, 0, ',', '.')); ?></span>
                    </div>
                </div>

                <form action="<?php echo e(route('cart.vaciar')); ?>" method="POST" class="mt-6">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full text-white py-2 rounded hover:opacity-90">
                        Vaciar Carrito
                    </button>
                </form>

                <form action="<?php echo e(route('checkout.pay')); ?>" method="POST" class="mt-4">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="amount" value="<?php echo e($total); ?>">
                    <button type="submit" class="w-full text-white py-2 rounded hover:opacity-90"
                        style="background-color: #40C239;">
                        Proceder al Pago con Webpay
                    </button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white p-8 rounded-lg shadow text-center mt-10">
            <p class="text-gray-700 text-lg">Tu carrito está vacío.</p>
            <a href="<?php echo e(route('home')); ?>" class="mt-4 inline-block text-blue-600 hover:underline">Volver a la tienda</a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\TRABAJO\Equipo_5\resources\views/cart/index.blade.php ENDPATH**/ ?>