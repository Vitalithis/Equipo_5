<?php $__env->startSection('title','Listado de fertilizantes'); ?>

<?php $__env->startSection('content'); ?>
<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div x-data="{ modalFert: null }" class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
    <div class="flex items-center mb-6">
        <a href="<?php echo e(route('fertilizantes.create')); ?>"
           class="ml-auto flex items-center text-green-700 hover:text-green-800 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 4v16m8-8H4"/>
            </svg>
            Agregar Fertilizante
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow sm:rounded-lg w-full">
        <table class="min-w-full divide-y divide-eaccent2 text-sm text-left">
            <thead class="bg-eaccent2 text-gray-800 uppercase tracking-wider font-['Roboto_Condensed']">
                <tr>
                    <th class="px-6 py-3 whitespace-nowrap">Nombre</th>
                    <th class="px-6 py-3 whitespace-nowrap">Tipo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Stock</th>
                    <th class="px-6 py-3 whitespace-nowrap">Información</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__currentLoopData = $fertilizantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fertilizante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->nombre); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->tipo); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->stock); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button @click="modalFert = <?php echo e($fertilizante->id); ?>"
                                    class="text-green-600 hover:text-green-800 transition font-medium">
                                Ver detalles
                            </button>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <a href="<?php echo e(route('fertilizantes.edit', $fertilizante->id)); ?>"
                               class="text-blue-600 hover:text-blue-800 font-medium transition">Editar</a>
                            <form action="<?php echo e(route('fertilizantes.destroy', $fertilizante->id)); ?>" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este fertilizante?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium transition">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div x-cloak x-show="modalFert === <?php echo e($fertilizante->id); ?>" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div @click.away="modalFert = null" class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl font-['Roboto'] text-gray-800">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold"><?php echo e($fertilizante->nombre); ?></h2>
                                <button @click="modalFert = null" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-3 text-sm leading-relaxed">
                                <div><span class="font-semibold">Tipo:</span> <?php echo e($fertilizante->tipo); ?></div>
                                <div><span class="font-semibold">Peso:</span> <?php echo e($fertilizante->peso); ?> <?php echo e($fertilizante->unidad_medida); ?></div>
                                <div><span class="font-semibold">Presentación:</span> <?php echo e($fertilizante->presentacion); ?></div>
                                <div><span class="font-semibold">Precio:</span> $<?php echo e(number_format($fertilizante->precio, 0, ',', '.')); ?></div>
                                <div><span class="font-semibold">Fecha de vencimiento:</span> <?php echo e($fertilizante->fecha_vencimiento ? \Carbon\Carbon::parse($fertilizante->fecha_vencimiento)->format('d/m/Y') : '-'); ?></div>
                                <div><span class="font-semibold">Composición:</span><br><p class="whitespace-pre-line"><?php echo e($fertilizante->composicion); ?></p></div>
                                <div><span class="font-semibold">Descripción:</span><br><p class="whitespace-pre-line"><?php echo e($fertilizante->descripcion); ?></p></div>
                                <div><span class="font-semibold">Aplicación:</span><br><p class="whitespace-pre-line"><?php echo e($fertilizante->aplicacion); ?></p></div>
                                <div><span class="font-semibold">Activo:</span> <?php echo e($fertilizante->activo ? 'Sí' : 'No'); ?></div>
                            </div>
                            <div class="mt-6 text-right">
                                <button @click="modalFert = null" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\resources\views/dashboard/fertilizante.blade.php ENDPATH**/ ?>