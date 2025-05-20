

<?php $__env->startSection('title', 'Cuidados de Plantas'); ?>

<?php $__env->startSection('content'); ?>
<div class="py-8 px-4 md:px-8 max-w-6xl mx-auto">
    <div class="flex items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Cuidados de Plantas</h1>
        <a href="<?php echo e(route('dashboard.cuidados.create')); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Cuidado
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-100 text-gray-600 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Producto</th>
                    <th class="px-4 py-3 text-left">Riego</th>
                    <th class="px-4 py-3 text-left">Agua</th>
                    <th class="px-4 py-3 text-left">Luz</th>
                    <th class="px-4 py-3 text-left">Abono</th>
                    <th class="px-4 py-3 text-left">PDF</th>
                    <th class="px-4 py-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $cuidados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuidado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-4 py-3"><?php echo e($cuidado->producto->nombre ?? '-'); ?></td>
                        <td class="px-4 py-3"><?php echo e($cuidado->frecuencia_riego); ?></td>
                        <td class="px-4 py-3"><?php echo e($cuidado->cantidad_agua); ?></td>
                        <td class="px-4 py-3"><?php echo e($cuidado->tipo_luz); ?></td>
                        <td class="px-4 py-3"><?php echo e($cuidado->frecuencia_abono ?? '-'); ?></td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="<?php echo e(route('dashboard.cuidados.edit', $cuidado->id)); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="<?php echo e(route('dashboard.cuidados.destroy', $cuidado->id)); ?>" method="POST"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este cuidado?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <a href="<?php echo e(route('dashboard.cuidados.pdf', $cuidado->id)); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver PDF</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No hay cuidados registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/cuidados.blade.php ENDPATH**/ ?>