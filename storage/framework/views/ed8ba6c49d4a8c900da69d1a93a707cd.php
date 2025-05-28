<?php $__env->startSection('title', 'Órdenes de Producción'); ?>

<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div x-data="{ modalOrden: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
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
                    <th class="px-6 py-3 whitespace-nowrap">Trabajador</th>
                    <th class="px-6 py-3 whitespace-nowrap">Información</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__empty_1 = true; $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->codigo); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->producto->nombre ?? '-'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($orden->trabajador->name ?? '—'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="modalOrden = <?php echo e($orden->id); ?>"
                                    class="text-green-600 hover:text-green-800 transition font-medium">
                                Ver detalles
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="<?php echo e(route('ordenes.edit', $orden->id)); ?>"
                               class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</a>
                            <form action="<?php echo e(route('ordenes.destroy', $orden->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta orden?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div x-cloak x-show="modalOrden === <?php echo e($orden->id); ?>" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div @click.away="modalOrden = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold">Orden <?php echo e($orden->codigo); ?></h2>
                                <button @click="modalOrden = null" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-sm leading-relaxed">
                                <div><span class="font-semibold">Producto:</span> <?php echo e($orden->producto->nombre ?? '-'); ?></div>
                                <div><span class="font-semibold">Cantidad:</span> <?php echo e($orden->cantidad); ?></div>
                                <div><span class="font-semibold">Fecha de Inicio:</span> <?php echo e(\Carbon\Carbon::parse($orden->fecha_inicio)->format('d/m/Y')); ?></div>
                                <div><span class="font-semibold">Fecha Estimada:</span>
                                    <?php echo e($orden->fecha_fin_estimada ? \Carbon\Carbon::parse($orden->fecha_fin_estimada)->format('d/m/Y') : '-'); ?>

                                </div>
                                <div><span class="font-semibold">Estado:</span> <?php echo e(ucfirst($orden->estado)); ?></div>
                                <div><span class="font-semibold">Trabajador:</span> <?php echo e($orden->trabajador->name ?? '—'); ?></div>
                                <div><span class="font-semibold">Observaciones:</span><br>
                                    <p class="whitespace-pre-line"><?php echo e($orden->observaciones ?? 'Sin observaciones.'); ?></p>
                                </div>
                            </div>
                            <div class="mt-6 text-right">
                                <button @click="modalOrden = null"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">No hay órdenes registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/ordenes.blade.php ENDPATH**/ ?>