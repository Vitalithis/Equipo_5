<?php $__env->startSection('title','Listado de fertilizantes'); ?>

<?php $__env->startSection('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Roboto&family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

<div class="py-8 px-4 md:px-8 w-full font-['Roboto'] text-gray-800">
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
                    <th class="px-6 py-3 whitespace-nowrap max-w-[200px]">Composición</th>
                    <th class="px-6 py-3 whitespace-nowrap max-w-[200px]">Descripción</th>
                    <th class="px-6 py-3 whitespace-nowrap">Peso</th>
                    <th class="px-6 py-3 whitespace-nowrap">Unidad</th>
                    <th class="px-6 py-3 whitespace-nowrap">Presentación</th>
                    <th class="px-6 py-3 whitespace-nowrap max-w-[200px]">Aplicación</th>
                    <th class="px-6 py-3 whitespace-nowrap">Precio</th>
                    <th class="px-6 py-3 whitespace-nowrap">Stock</th>
                    <th class="px-6 py-3 whitespace-nowrap">Vencimiento</th>
                    <th class="px-6 py-3 whitespace-nowrap">Activo</th>
                    <th class="px-6 py-3 whitespace-nowrap">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-eaccent2 font-['Roboto'] text-gray-800">
                <?php $__currentLoopData = $fertilizantes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fertilizante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->nombre); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->tipo); ?></td>
                        <td class="px-6 py-4 whitespace-normal break-words max-w-[200px]"><?php echo e(Str::limit($fertilizante->composicion, 100)); ?></td>
                        <td class="px-6 py-4 whitespace-normal break-words max-w-[200px]"><?php echo e(Str::limit($fertilizante->descripcion, 100)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->peso); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->unidad_medida); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->presentacion); ?></td>
                        <td class="px-6 py-4 whitespace-normal break-words max-w-[200px]"><?php echo e(Str::limit($fertilizante->aplicacion, 100)); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">$<?php echo e(number_format($fertilizante->precio, 0, ',', '.')); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->stock); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->fecha_vencimiento); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo e($fertilizante->activo ? 'Sí' : 'No'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="<?php echo e(route('fertilizantes.edit', $fertilizante->id)); ?>" class="text-blue-600 hover:text-blue-900">Editar</a>
                            <form action="<?php echo e(route('fertilizantes.destroy', $fertilizante->id)); ?>" method="POST" class="inline-block ml-2">
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\xampp\Equipo_5\Equipo_5\resources\views/dashboard/fertilizante.blade.php ENDPATH**/ ?>