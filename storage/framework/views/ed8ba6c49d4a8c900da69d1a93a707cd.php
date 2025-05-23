<?php $__env->startSection('title', 'Órdenes de Producción'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('ordenes.create')); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Orden
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Código</th>
                    <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Cantidad</th>
                    <th class="px-6 py-3 whitespace-nowrap">Fecha Inicio</th>
                    <th class="px-6 py-3 whitespace-nowrap">Fecha Estimada</th>
                    <th class="px-6 py-3 whitespace-nowrap">Estado</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->codigo); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->producto->nombre ?? '-'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->cantidad); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php echo e($orden->fecha_fin_estimada ? \Carbon\Carbon::parse($orden->fecha_fin_estimada)->format('d/m/Y') : '-'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize"><?php echo e($orden->estado); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('ordenes.edit', $orden->id)); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="<?php echo e(route('ordenes.destroy', $orden->id)); ?>" method="POST" class="inline-block ml-2" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">No hay órdenes registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/ordenes.blade.php ENDPATH**/ ?>