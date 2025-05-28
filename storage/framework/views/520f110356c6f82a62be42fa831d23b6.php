<?php $__env->startSection('title','Resumen Financiero'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-green-100 text-green-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Total Ingresos</h3>
            <p class="text-xl font-semibold">$<?php echo e(number_format($totalIngresos, 0, ',', '.')); ?></p>
        </div>
        <div class="bg-red-100 text-red-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Total Egresos</h3>
            <p class="text-xl font-semibold">$<?php echo e(number_format($totalEgresos, 0, ',', '.')); ?></p>
        </div>
        <div class="bg-blue-100 text-blue-800 p-4 rounded shadow">
            <h3 class="font-bold text-lg">Balance</h3>
            <p class="text-xl font-semibold">$<?php echo e(number_format($balance, 0, ',', '.')); ?></p>
        </div>
    </div>

    
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('finanzas.create')); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Movimiento
        </a>
    </div>


    
    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider" style="font-family: 'Roboto Condensed', sans-serif;">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Fecha</th>
                    <th class="px-6 py-3 whitespace-nowrap">Tipo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Monto</th>
                    <th class="px-6 py-3 whitespace-nowrap">Categoría</th>
                    <th class="px-6 py-3 whitespace-nowrap">Descripción</th>
                    <th class="px-6 py-3 whitespace-nowrap">Registrado por</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $finanzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e(\Carbon\Carbon::parse($item->fecha)->format('d/m/Y')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap capitalize">
                            <?php if($item->tipo === 'ingreso'): ?>
                                <span class="text-green-700 font-semibold">Ingreso</span>
                            <?php else: ?>
                                <span class="text-red-700 font-semibold">Egreso</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">$<?php echo e(number_format($item->monto, 0, ',', '.')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($item->categoria); ?></td>
                        <td class="px-6 py-4 whitespace-normal break-words max-w-[300px]"><?php echo e($item->descripcion ?: '—'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($item->usuario->name ?? '—'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('finanzas.edit', $item->id)); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="<?php echo e(route('finanzas.destroy', $item->id)); ?>" method="POST" class="inline-block ml-2"
                                  onsubmit="return confirm('¿Deseas eliminar este movimiento?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                            No hay registros financieros.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/finanzas.blade.php ENDPATH**/ ?>