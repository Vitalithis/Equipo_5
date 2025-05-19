<?php $__env->startSection('title','Listado de descuentos'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="py-8 px-4 md:px-8 max-w-3xl mx-auto">
        <div class="flex items center mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                Descuentos
            </h1>
            <a href="<?php echo e(route('descuentos.create')); ?>" class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v16m8-8H4"/></svg>
                Agregar Descuento
            </a>
        </div>
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Porcentaje</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $descuentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $descuento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($descuento->nombre); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap"><?php echo e($descuento->porcentaje); ?>%</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="<?php echo e(route('descuentos_edit',   ["id"=>$descuento->id])); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                                <form action="<?php echo e(route('descuentos.destroy', $descuento->id)); ?>" method="POST" class="inline-block ml-2">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Vitalithis\Documents\GitHub\Equipo_5\resources\views/dashboard/descuentos.blade.php ENDPATH**/ ?>