<?php $__env->startSection('title', 'Gestión de Pedidos'); ?>

<?php $__env->startSection('default-content'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-8 py-10 bg-efore rounded-xl shadow-lg">
    <h1 class="text-4xl font-extrabold text-eprimary mb-8 text-center">Gestión de Pedidos</h1>

   <?php if(session('success')): ?>
        <div id="success-message" class="bg-[#FFF9DB] border-l-4 border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-6 shadow">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <?php if($pedidos->count()): ?>
        <div class="overflow-x-auto bg-white rounded-xl shadow border border-eaccent2">
            <table class="min-w-full divide-y divide-eaccent2 text-sm">
                <?php echo $__env->make('pedidos.partials.table-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <tbody class="divide-y divide-efore">
                    <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('pedidos.partials.table-row', ['pedido' => $pedido], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-lg text-gray-600 mt-10">No hay pedidos registrados.</p>
    <?php endif; ?>
</div>

<?php echo $__env->make('pedidos.partials.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('pedidos.partials.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/pedidos/index.blade.php ENDPATH**/ ?>