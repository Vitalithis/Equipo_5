<?php $__env->startSection('title', 'Cuidados de Plantas'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('dashboard.cuidados.create')); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" stroke="currentColor"
                 stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Cuidado
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Producto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Riego</th>
                    <th class="px-6 py-3 whitespace-nowrap">Agua</th>
                    <th class="px-6 py-3 whitespace-nowrap">Luz</th>
                    <th class="px-6 py-3 whitespace-nowrap">Abono</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                    <th class="px-6 py-3 whitespace-nowrap">PDF</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $cuidados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cuidado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($cuidado->producto->nombre ?? '-'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($cuidado->frecuencia_riego); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($cuidado->cantidad_agua); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($cuidado->tipo_luz); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($cuidado->frecuencia_abono ?? '-'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('dashboard.cuidados.edit', $cuidado->id)); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="<?php echo e(route('dashboard.cuidados.destroy', $cuidado->id)); ?>" method="POST" class="inline-block ml-2"
                                  onsubmit="return confirm('¿Estás seguro de eliminar este cuidado?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('dashboard.cuidados.pdf', $cuidado->id)); ?>" target="_blank" class="text-indigo-600 hover:text-indigo-900">Ver PDF</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">No hay cuidados registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\Equipo_5\resources\views/dashboard/cuidados.blade.php ENDPATH**/ ?>