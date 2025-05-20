<form action="<?php echo e(route('pedidos.update', $pedido->id)); ?>" method="POST" class="flex items-center gap-2" onclick="event.stopPropagation();">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <?php
        $estados = $pedido->estadosPermitidos();
    ?>

    <?php if(!empty($estados)): ?>
        <select name="estado_pedido"
                class="rounded border border-efore-400 px-2 py-1 text-sm bg-white text-eprimary focus:ring-2 focus:ring-eaccent2-500">
            <?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $texto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($valor); ?>" <?php if($pedido->estado_pedido === $valor): echo 'selected'; endif; ?>>
                    <?php echo e($texto); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php else: ?>
        <span class="text-red-500 text-sm">Método de entrega no reconocido</span>
    <?php endif; ?>

    <button type="submit"
            class="bg-eaccent2 hover:bg-eaccent2-400 text-eprimary font-semibold px-3 py-1 rounded shadow transition text-sm">
        Guardar
    </button>
</form>
 <?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/pedidos/partials/estado_form.blade.php ENDPATH**/ ?>