<div id="detalles-<?php echo e($pedido->id); ?>"
     class="max-h-0 overflow-hidden opacity-0 transition-all duration-300 bg-efore text-sm border-t border-esecondary">
    <div class="p-6 space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <p><strong class="text-eprimary">Método de entrega:</strong> <?php echo e($pedido->metodo_entrega); ?></p>
            <p><strong class="text-eprimary">Dirección:</strong> <?php echo e($pedido->direccion ?? 'No disponible'); ?></p>
            <p><strong class="text-eprimary">Fecha de pedido:</strong> <?php echo e($pedido->created_at->format('d-m-Y H:i')); ?></p>
        </div>

        <div>
            <p class="font-semibold text-eprimary mb-2">Productos:</p>
            <ul class="list-disc list-inside ml-4 space-y-1">
                <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                        <span class="text-gray-800"><?php echo e($detalle->nombre_producto_snapshot); ?></span>
                        <span class="text-gray-600">(x<?php echo e($detalle->cantidad); ?>,
                        $<?php echo e(number_format($detalle->precio_unitario, 0, ',', '.')); ?>,
                        Subtotal: $<?php echo e(number_format($detalle->subtotal, 0, ',', '.')); ?>)</span>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <strong class="text-eprimary">Boleta SII:</strong>
                <?php if($pedido->boleta_final_path): ?>
                    <span class="text-green-600 font-medium">Subida</span>
                    <button class="open-modal-pdf text-esecondary hover:text-eaccent text-sm underline"
                            data-pdf="<?php echo e(asset('storage/' . $pedido->boleta_final_path)); ?>">
                        Ver PDF
                    </button>
                <?php else: ?>
                    <span class="text-red-500 font-medium">No subida</span>
                <?php endif; ?>

                <button class="open-modal-upload text-eaccent hover:text-eaccent2 text-lg"
                        data-action="<?php echo e(route('boletas.subir', ['pedido' => $pedido->id])); ?>">
                    📤
                </button>
            </div>
        </div>

        <div class="pt-2">
            <button class="open-modal-provisoria inline-block bg-yellow-100 hover:bg-yellow-200 text-eprimary font-semibold text-sm px-4 py-2 rounded shadow transition"
                    data-url="<?php echo e(route('boletas.provisoria', $pedido->id)); ?>">
                    Ver boleta provisoria
            </button>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/pedidos/partials/detalles.blade.php ENDPATH**/ ?>